<?php

namespace Engine\Addons\Auth;

use Engine\Helpers;
use Engine\TemplateApi;


require_once __DIR__ . '/Loader.php';

function auth()
{
    $auth_result = Auth::authorize($_POST['login'], $_POST['password']);
    if (!$auth_result)
        Helpers::jsonPrinter('Неправильный логин или пароль!', false);
    else
        Helpers::jsonPrinter('Успешная авторизация!', true);
}

function reg()
{
    $reg_result = Auth::register($_POST['login'], $_POST['email'], $_POST['password'], $_POST['first'], $_POST['last']);
    if (!$reg_result)
        Helpers::jsonPrinter('Пользователь с таким логином уже существует!', false);
    else
        Helpers::jsonPrinter('Успешная регистрация!', true);
}

function captcha()
{
    if (!isset($_POST['captcha']))
        return false;

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => '6LfmaJwaAAAAAILROIjGGOXj6Fr7RJhzvWYPBvot',
        'response' => $_POST['captcha']
    ];
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);
    if ($captcha_success->success == false)
        return false;
    return true;
}

TemplateApi::addCheck('captcha', function () {
    return captcha();
});
TemplateApi::addCheck('isAuthorized', function () {
    return User::isAuthorized();
});

TemplateApi::addHandler('Auth', 'auth', function () {
    auth();
}, ['login', 'password', 'captcha']);
TemplateApi::addHandler('Auth', 'reg', function () {
    reg();
}, ['login', 'password', 'email', 'first', 'last', 'captcha']);
