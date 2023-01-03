<?php


namespace Engine\Addons\Auth;


use Engine\Addons\History\History;
use Engine\ErrorsHandler;
use R;
use RedBeanPHP\OODBBean;

/**
 * Class User
 * @package Engine\Addons\Auth
 */
class User
{
    /**
     * @var
     */
    public static $first_name;
    /**
     * @var
     */
    public static $last_name;

    /**
     * @var
     */
    public static $id;
    /**
     * @var
     */
    public static $login;
    /**
     * @var
     */
    public static $email;
    /**
     * @var
     */
    public static $reg_date;
    /**
     * @var
     */
    public static $honesty;

    /**
     * @var
     */
    public static $telegram;
    /**
     * @var
     */
    public static $vk;

    /**
     * @var
     */
    public static $role;

    /**
     * @param $id
     * @return int
     */
    public static function countReadBooks($id)
    {
        $history = History::getHistoryByUserId($id);
        if ($history == null)
            return 0;
        $readHistory = [];
        foreach ($history as $item) {
            if ($item != null)
                if ($item->status == 'read')
                    array_push($readHistory, $item);
        }
        return count($readHistory);
    }

    /**
     * @param $id
     * @return bool
     */
    public static function ban($id)
    {
        $user = self::getUserById($id);
        if ($user == null)
            return false;
        $user->role = 'banned';
        R::store($user);
        return true;
    }

    /**
     * @param $id
     * @return OODBBean
     */
    public static function getUserById($id)
    {
        return R::load('users', $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public static function unBan($id)
    {
        $user = self::getUserById($id);
        if ($user == null)
            return false;
        $user->role = 'user';
        R::store($user);
        return true;
    }

    /**
     *
     */
    public static function onlyForAdmins()
    {
        if (self::isAdmin())
            return;
        ErrorsHandler::forbiddenError();
    }

    /**
     * @return bool
     */
    public static function isAdmin()
    {
        if (self::isAuthorized() && self::$role == 'admin')
            return true;
        return false;
    }

    /**
     * @return bool
     */
    public static function isAuthorized()
    {
        if (isset($_SESSION['id']))
            return true;
        return false;
    }

    /**
     * @param $id
     * @param $telegram
     * @return bool
     */
    public static function changeTelegram($id, $telegram)
    {
        $telegram = str_replace('@', '', strtolower($telegram));
        $user = self::getUserById($id);
        if ($user == null)
            return false;
        $user->telegram = $telegram;
        R::store($user);
        return true;
    }

    /**
     * @param $id
     * @param $vk
     * @return bool
     */
    public static function changeVk($id, $vk)
    {
        $vk = str_replace('/', '', str_replace('https://', '', str_replace('vk.com', '', strtolower($vk))));
        $user = self::getUserById($id);
        if ($user == null)
            return false;
        $user->vk = $vk;
        R::store($user);
        return true;
    }

    /**
     * @param $user
     * @return string
     */
    public static function getName($user)
    {
        if ($user == null)
            return 'errorName';
        return $user->first_name . ' ' . $user->last_name;
    }

    /**
     *
     */
    public static function onlyForMembers()
    {
        if (self::isAuthorized() && self::$role != 'banned')
            return;
        ErrorsHandler::forbiddenError();
    }

    /**
     * @param $role
     * @return string
     */
    public static function roleToText($role)
    {
        switch (strtolower($role)) {
            case 'user':
                return 'Пользователь';
                break;
            case 'vip':
                return 'ВИП';
                break;
            case 'admin':
                return 'Администратор';
                break;
            case 'banned':
                return 'Забанен';
                break;
        }
        return 'error';
    }

    /**
     * @param $login
     * @return NULL|OODBBean
     */
    public static function getUserByLogin($login)
    {
        return R::findOne('users', 'login = ?', [$login]);
    }

    /**
     *
     */
    public static function logout()
    {
        session_destroy();
    }
}