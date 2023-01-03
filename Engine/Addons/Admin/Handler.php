<?php

namespace Engine\Addons\Admin;

use Engine\Addons\Auth\User;
use Engine\Helpers;
use Engine\TemplateApi;

function ban()
{
    $result = User::ban($_POST['id']);
    if ($result)
        Helpers::jsonPrinter('Пользователь забанен!', true);
    else
        Helpers::jsonPrinter('Пользователь не забанен!', false);
}

function unBan()
{
    $result = User::unBan($_POST['id']);
    if ($result)
        Helpers::jsonPrinter('Пользователь разбанен!', true);
    else
        Helpers::jsonPrinter('Пользователь не разбанен!', false);
}

TemplateApi::addCheck('isAdmin', function () {
    return User::isAdmin();
});

TemplateApi::addHandler('Admin', 'ban', function () {
    ban();
}, ['id', 'isAdmin']);
TemplateApi::addHandler('Admin', 'unBan', function () {
    unBan();
}, ['id', 'isAdmin']);

