<?php


namespace Engine\Addons\Auth;

use Engine\Helpers;
use R;

/**
 * Class Auth
 * @package Engine\Addons\Auth
 */
class Auth
{
    /**
     * @param $login
     * @param $email
     * @param $password
     * @param $first
     * @param $last
     * @return bool
     */
    public static function register($login, $email, $password, $first, $last)
    {
        $tempUser = R::findOne('users', 'login = ?', [$login]);
        if ($tempUser != null)
            return false;
        $user = R::dispense('users');
        $user->login = Helpers::clearStr($login);
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->regDate = date("Y-m-d");
        $user->honesty = 10.0;
        $user->first_name = $first;
        $user->last_name = $last;
        $user->role = 'user';
        $user->vk = '';
        $user->telegram = '';
        R::store($user);
        self::authorize($login, $password);
        return true;
    }

    /**
     * @param $login
     * @param $password
     * @return bool
     */
    public static function authorize($login, $password)
    {
        $user = R::findOne('users', 'login = ?', [$login]);
        if ($user == null)
            return false;
        if (!password_verify($password, $user->password))
            return false;
        $_SESSION['id'] = $user->id;
        return true;
    }
}
