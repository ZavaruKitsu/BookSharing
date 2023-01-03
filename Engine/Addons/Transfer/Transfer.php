<?php


namespace Engine\Addons\Auth;

use Engine\Addons\Books\Books;
use Engine\Addons\History\History;
use R;
use RedBeanPHP\OODBBean;

/**
 * Class Transfer
 * @package Engine\Addons\Auth
 */
class Transfer
{
    /**
     * @param $bookId
     * @param $distId
     * @param $rating
     * @return bool
     */
    public static function addTransfer($bookId, $distId, $rating)
    {
        if (Transfer::getQueuedTransferByBookAndDist($bookId, $distId) != null)
            return false;
        $transfer = R::dispense('transfers');
        $transfer->book_id = $bookId;
        $transfer->dist_id = $distId;
        $transfer->rating = $rating;
        $transfer->status = 'queued';
        $transfer->state = 'great';
        $transfer->hidden = false;

        R::store($transfer);
        return true;
    }

    /**
     * @param $bookId
     * @param $distId
     * @return NULL|OODBBean
     */
    public static function getQueuedTransferByBookAndDist($bookId, $distId)
    {
        return R::findOne('transfers', 'book_id = ? AND dist_id = ? AND status = ?', [$bookId, $distId, 'queued']);
    }

    /**
     * @param $bookId
     * @return NULL|OODBBean
     */
    public static function getQueuedTransfersByBookId($bookId)
    {
        return R::findOne('transfers', 'book_id = ? AND status = ?', [$bookId, 'queued']);
    }

    /**
     * @param $id
     * @return array
     */
    public static function getUserTransfersById($id)
    {
        return R::findAll('transfers', 'dist_id = ? AND status = ?', [$id, 'queued']);
    }

    /**
     * @param $status
     * @return string
     */
    public static function statusToText($status)
    {
        $status = strtolower($status);
        switch ($status) {
            case 'queued':
                return 'В очереди';
            case 'completed':
                return 'Получил';
            case 'canceled':
                return 'Отменил';
        }
        return 'error';
    }

    /**
     * @param $state
     * @return string
     */
    public static function stateToText($state)
    {
        $state = strtolower($state);
        switch ($state) {
            case 'terrible':
                return 'Ужасное';
            case 'bad':
                return 'Плохое';
            case 'good':
                return 'Хорошее';
            case 'great':
                return 'Отличное';
        }
        return 'error';
    }

    /**
     * @param $transfer
     * @param $newOwner
     * @return bool
     */
    public static function changeOwner($transfer, $newOwner)
    {
        $history = History::getOneBookHistory($transfer->book_id, Books::getById($transfer->book_id)->owner, 'reading');
        if ($history == null)
            return false;
        $history->status = 'read';
        R::store($history);
        $result2 = Books::editBook($transfer->book_id, 'owner', $newOwner);
        if (!$result2)
            return false;
        $result3 = self::editTransfer($transfer->id, 'hidden', true);
        if (!$result3)
            return false;
        $result4 = self::editTransfer($transfer->id, 'status', 'completed');
        if (!$result4)
            return false;
        $history2 = History::getOneBookHistory($transfer->book_id, $newOwner, 'queued');
        if ($history2 == null)
            return false;
        $history2->status = 'reading';
        $history2->rating = $transfer->rating;
        R::store($history2);
        return true;
    }

    /**
     * @param $id
     * @param $param
     * @param $value
     * @return bool
     */
    public static function editTransfer($id, $param, $value)
    {
        $transfer = Transfer::getTransferById($id);
        if ($transfer == null)
            return false;
        $transfer[$param] = $value;
        R::store($transfer);
        return true;
    }

    /**
     * @param $id
     * @return OODBBean
     */
    public static function getTransferById($id)
    {
        return R::load('transfers', $id);
    }

    /**
     * @param $prevState
     * @param $lastState
     * @return int
     */
    public static function getHonestyValue($prevState, $lastState)
    {
        if ($prevState == $lastState)
            return 1;
        else {
            $prevState = self::stateToNum($prevState);
            $lastState = self::stateToNum($lastState);
            if ($prevState < $lastState)
                return 2;
            else if ($prevState > $lastState)
                return -4;
        }
        return 0;
    }

    /**
     * @param $state
     * @return int
     */
    public static function stateToNum($state)
    {
        $state = strtolower($state);
        switch ($state) {
            case 'terrible':
                return 0;
            case 'bad':
                return 1;
            case 'good':
                return 2;
            case 'great':
                return 3;
        }
        return 20;
    }
}