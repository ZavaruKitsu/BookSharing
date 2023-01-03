<?php


namespace Engine\Addons\Submit;

use Engine\Addons\Books\Books;
use Engine\Helpers;
use R;
use RedBeanPHP\OODBBean;

/**
 * Class Submit
 * @package Engine\Addons\Submit
 */
class Submit
{
    /**
     * @param $name
     * @param $author
     * @param $desc
     * @param $userId
     * @return bool
     */
    public static function submitBook($name, $author, $desc, $userId)
    {
        if (self::getSubmit($name, $author) != null)
            return false;
        if (Books::findBook($name, $author) != null)
            return false;
        $submit = R::dispense('submits');
        $submit->name = $name;
        $submit->author = $author;
        $submit->desc = Helpers::replaceNewLines($desc);
        $submit->owner = $userId;
        $submit->image = null;
        $submit->status = 'pending';
        $submit->hidden = false;
        $submit->reason = null;

        R::store($submit);
        return true;
    }

    /**
     * @param $name
     * @param $author
     * @return NULL|OODBBean
     */
    public static function getSubmit($name, $author)
    {
        return R::findOne('submits', 'name = ? AND author = ?', [$name, $author]);
    }

    /**
     * @return array
     */
    public static function getUnconfirmed()
    {
        return R::findAll('submits', 'status = ?', ['pending']);
    }

    /**
     * @param $id
     * @return mixed|string
     */
    public static function getDescription($id)
    {
        $submit = self::getSubmitById($id);
        if ($submit == null)
            return '';
        return $submit->desc;
    }

    /**
     * @param $id
     * @return OODBBean
     */
    public static function getSubmitById($id)
    {
        return R::load('submits', $id);
    }

    /**
     * @param $id
     * @return array
     */
    public static function getSubmitsByUserId($id)
    {
        return R::findAll('submits', 'owner = ? AND hidden = ? AND status != ?', [$id, 0, 'pending']);
    }

    /**
     * @param $status
     * @return string
     */
    public static function statusToText($status)
    {
        switch (strtolower($status)) {
            case 'pending':
                return 'Ожидает подтверждения';
            case 'confirmed':
                return 'Подтверждено';
            case 'declined':
                return 'Отклонено';
        }
        return 'error';
    }
}