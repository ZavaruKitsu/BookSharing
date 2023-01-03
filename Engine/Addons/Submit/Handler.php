<?php

namespace Engine\Addons\Submit;

use Engine\Addons\Auth\User;
use Engine\Addons\Books\Books;
use Engine\Helpers;
use Engine\TemplateApi;
use R;

if (!User::isAuthorized())
    return;

function submit()
{
    if ($_POST['desc'] == '')
        $_POST['desc'] = 'NO_DESC';
    $result = Submit::submitBook($_POST['name'], $_POST['author'], $_POST['desc'], User::$id);
    if ($result)
        Helpers::jsonPrinter('Запрос создан!', true);
    else
        Helpers::jsonPrinter('Запрос не создан! Возможно, вы уже отправили его.', false);
}

function hideSubmit()
{
    $submit = Submit::getSubmitById($_POST['id']);
    if ($submit == null)
        Helpers::jsonPrinter('Что-то пошло не так!', false);
    if ($submit->owner != User::$id)
        Helpers::jsonPrinter('Навіщо тобі обманювати систему?(((', false);
    $submit->hidden = true;
    R::store($submit);
    Helpers::jsonPrinter('Уведомление скрыто. Перезагрузите страницу.', true);
}

function loadDesc()
{
    $result = Submit::getDescription($_POST['id']);
    Helpers::jsonPrinter($result, true);
}

function confirmBook()
{
    $submit = Submit::getSubmitById($_POST['id']);
    $result = Books::addBook($submit->name, $submit->author, $submit->desc, $submit->owner, true);
    if (!$result)
        Helpers::jsonPrinter('Книга с таким названием уже есть!', false);
    $submit->status = 'confirmed';
    R::store($submit);
    Helpers::jsonPrinter('Книга подтверждена! ID: ' . $result, true);
}

function declineBook()
{
    $submit = Submit::getSubmitById($_POST['id']);
    if ($submit == null)
        Helpers::jsonPrinter('Книга не отклонена!', false);
    $submit->status = 'declined';
    $submit->reason = $_POST['reason'];
    R::store($submit);
    Helpers::jsonPrinter('Книга отклонена!', true);
}

TemplateApi::addHandler('Submit', 'submit', function () {
    submit();
}, ['name', 'author', 'desc']);
TemplateApi::addHandler('Submit', 'hideSubmit', function () {
    hideSubmit();
}, ['id']);
TemplateApi::addHandler('Submit', 'loadDesc', function () {
    loadDesc();
}, ['id', 'isAdmin']);
TemplateApi::addHandler('Submit', 'confirmBook', function () {
    confirmBook();
}, ['id', 'isAdmin']);
TemplateApi::addHandler('Submit', 'declineBook', function () {
    declineBook();
}, ['id', 'isAdmin']);

