<?php


namespace Engine\Addons\Auth;

session_start();

require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Auth.php';

if (isset($_GET['logout'])) {
    User::logout();
    header('Location: /');
}

if (isset($_SESSION['id'])) {
    $user = User::getUserById($_SESSION['id']);
    if ($user == null)
        return;
    User::$id = $user['id'];
    User::$first_name = $user['first_name'];
    User::$last_name = $user['last_name'];
    User::$login = $user['login'];
    User::$reg_date = $user['reg_date'];
    User::$honesty = $user['honesty'];
    User::$role = $user['role'];
    User::$email = $user['email'];
    User::$telegram = $user['telegram'];
    User::$vk = $user['vk'];
}
