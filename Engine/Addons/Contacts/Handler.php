<?php

namespace Engine\Addons\Contacts;

use Engine\Addons\Auth\User;
use Engine\Helpers;
use Engine\TemplateApi;

if (!User::isAuthorized())
    return;

function changeTelegram()
{
    $telegramResult = User::changeTelegram(User::$id, Helpers::clearStr($_POST['telegram']));
    if ($telegramResult)
        Helpers::jsonPrinter('Telegram изменён успешно!', true);
    else
        Helpers::jsonPrinter('Telegram не изменён!', false);
}

function changeVk()
{
    $vkResult = User::changeVk(User::$id, Helpers::clearStr($_POST['vk']));
    if ($vkResult)
        Helpers::jsonPrinter('Адрес ВКонтакте изменён успешно!', true);
    else
        Helpers::jsonPrinter('Адрес ВКонтакте не изменён!', false);
}

TemplateApi::addHandler('Contacts', 'changeTelegram', function () {
    changeTelegram();
}, ['telegram', 'isAuthorized']);
TemplateApi::addHandler('Contacts', 'changeVk', function () {
    changeVk();
}, ['vk', 'isAuthorized']);
