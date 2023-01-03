<?php

namespace Engine\Addons\History;

use Engine\Addons\Auth\User;
use Engine\TemplateConfig;
use R;
use RedBeanPHP\OODBBean;

/**
 * Class History
 * @package Engine\Addons\History
 */
class History
{
    /**
     * @param $id
     * @return array|null
     */
    public static function getHistoryByUserId($id)
    {
        $user = User::getUserById($id);
        if ($user == null)
            return null;
        return R::findAll('history', 'user_id = ? ORDER BY id DESC', [$user->id]);
    }

    /**
     * @param $id
     * @param $param
     * @param $value
     * @return bool
     */
    public static function editHistory($id, $param, $value)
    {
        $history = R::load('history', $id);
        if ($history == null)
            return false;
        $history[$param] = $value;
        R::store($history);
        return true;
    }

    /**
     * @param $id
     * @param $user
     * @param $status
     * @return bool
     */
    public static function addHistory($id, $user, $status)
    {
        $book = self::getOneBookHistory($id, $user, $status);
        if ($book != null)
            return false;
        $history = R::dispense('history');
        $history->user_id = $user;
        $history->book_id = $id;
        $history->status = $status;
        $history->rating = null;
        R::store($history);
        return true;
    }

    /**
     * @param $id
     * @param $user
     * @param $status
     * @return NULL|OODBBean
     */
    public static function getOneBookHistory($id, $user, $status)
    {
        return R::findOne('history', 'book_id = ? AND user_id = ? AND status = ?', [$id, $user, $status]);
    }

    /**
     * @param $id
     * @return int
     */
    public static function countUserHistory($id)
    {
        return R::count('history', 'WHERE user_id = ?', [$id]);
    }

    /**
     * @param $id
     * @return array
     */
    public static function getFullBookHistoryById($id)
    {
        return R::findAll('history', 'book_id = ? ORDER BY id DESC', [$id]);
    }

    /**
     * @param $userId
     * @param int $page
     * @param bool $isAdmin
     * @return array
     */
    public static function getUserBookHistoryById($userId, $page = 1, $isAdmin = false)
    {
        if (!$isAdmin)
            return R::findAll('history', 'user_id = ? ORDER BY status DESC LIMIT ? OFFSET ?', [$userId, TemplateConfig::$historyPerPage, (($page - 1) * TemplateConfig::$historyPerPage)]);
        else
            return R::findAll('history', 'user_id = ? ORDER BY status DESC LIMIT ? OFFSET ?', [$userId, TemplateConfig::$historyPerPage, (($page - 1) * TemplateConfig::$historyPerPage)]);
    }

    /**
     * @param $id
     * @param int $page
     * @return array
     */
    public static function getBookHistoryById($id, $page = 1)
    {
        return R::findAll('history', 'book_id = ? ORDER BY id DESC LIMIT ? OFFSET ?', [$id, TemplateConfig::$historyPerPage, (($page - 1) * TemplateConfig::$historyPerPage)]);
    }

    /**
     * @param $id
     * @return int
     */
    public static function countHistory($id)
    {
        return R::count('history', 'WHERE book_id = ?', [$id]);
    }
}