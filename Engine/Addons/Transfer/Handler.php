<?php

namespace Engine\Addons\Transfer;

use Engine\Addons\Auth\Transfer;
use Engine\Addons\Auth\User;
use Engine\Addons\Books\Books;
use Engine\Addons\History\History;
use Engine\Helpers;
use Engine\TemplateApi;
use R;

function createTransfer()
{
    $book = Books::getById($_POST['bookId']);

    if ($book == null || $book->owner != User::$id)
        Helpers::jsonPrinter("Обновите страницу!", false);

    $user = User::getUserByLogin($_POST['distId']);

    if ($user == null)
        Helpers::jsonPrinter('Такого пользователя не существует!', false);
    if ($book->owner == $user->id)
        Helpers::jsonPrinter('Не передавайте книгу сами себе!', false);

    $history = History::getOneBookHistory($book->id, $user->id, 'queued');

    if ($history == null)
        Helpers::jsonPrinter('Человек не стоит в очереди!', false);

    $result = Transfer::addTransfer($_POST['bookId'], $user->id, $_POST['rating']);

    if ($result)
        Helpers::jsonPrinter('Запрос на передачу создан!', true);
    else
        Helpers::jsonPrinter('Запрос на передачу не создан! Возможно, вы уже отправили запрос.', false);
}

function acceptTransfer()
{
    $transfer = Transfer::getTransferById($_POST['transferId']);

    if ($transfer == null)
        Helpers::jsonPrinter('Запрос не принят! Возможно, вы уже его приняли.', false);

    $book = Books::getById($transfer->book_id);
    $book->state = $_POST['state'];
    $bookOwner = $book->owner;

    if ($bookOwner == User::$id)
        Helpers::jsonPrinter('Запрос не принят! Возможно, вы уже его приняли.', false);

    if ($transfer->dist_id != User::$id)
        Helpers::jsonPrinter('Навіщо тобі обманювати систему?(((', false);

    $user = User::getUserById($bookOwner);
    $user->honesty += Transfer::getHonestyValue($book->state, $_POST['state']);

    R::store($user);
    R::store($book);

    $result = Transfer::changeOwner($transfer, User::getUserById($transfer->dist_id)->id);

    if ($result)
        Helpers::jsonPrinter('Теперь книга в вашем расположении!', true);
    else
        Helpers::jsonPrinter('Произошла ошибка при измении владельца!', false);
}

function cancelTransfer()
{
    $transfer = Transfer::getTransferById($_POST['transferId']);

    if ($transfer == null)
        Helpers::jsonPrinter('Запрос не отклонён! Возможно, вы уже его приняли.', false);

    $book = Books::getById($transfer->book_id);

    if ($book->owner == User::$id)
        Helpers::jsonPrinter('Запрос не отклонён! Возможно, вы уже его приняли.', false);

    $user = User::getUserById($book->owner);

    if ($user == null)
        Helpers::jsonPrinter('Произошiв критический сбой.', false);

    if ($transfer->dist_id != User::$id)
        Helpers::jsonPrinter('Навіщо тобі обманювати систему?(((', false);

    $transfer->status = 'canceled';
    $transfer->hidden = true;

    R::store($transfer);

    History::editHistory(History::getOneBookHistory($book->id, User::$id, 'queued')->id, 'status', 'canceled');

    Helpers::jsonPrinter('Передача отменена!', true);
}

function queueTransfer()
{
    $result = History::addHistory($_POST['bookId'], User::$id, 'queued');

    if ($result)
        Helpers::jsonPrinter('Вы встали в очередь!', true);
    else
        Helpers::jsonPrinter('Не удалось встать в очередь. Возможно, вы уже стоите в ней.', false);
}

function cancelQueue()
{
    $history = R::findOne('history', 'book_id = ? AND user_id = ? AND status = \'queued\'', [$_POST['bookId'], User::$id]);

    if ($history == null)
        Helpers::jsonPrinter('Не удалось выйти из очереди. Возможно, вы не стоите в ней.', false);

    R::trash($history);

    $transfer = Transfer::getQueuedTransferByBookAndDist($_POST['bookId'], User::$id);

    if ($transfer != null)
        R::trash($transfer);

    Helpers::jsonPrinter('Вы вышли из очереди!', true);
}

TemplateApi::addHandler('Transfer', 'createTransfer', function () {
    createTransfer();
}, ['distId', 'rating', 'bookId', 'isAuthorized']);
TemplateApi::addHandler('Transfer', 'acceptTransfer', function () {
    acceptTransfer();
}, ['transferId', 'state', 'isAuthorized']);
TemplateApi::addHandler('Transfer', 'cancelTransfer', function () {
    cancelTransfer();
}, ['transferId', 'isAuthorized']);
TemplateApi::addHandler('Transfer', 'queueTransfer', function () {
    queueTransfer();
}, ['bookId', 'isAuthorized']);
TemplateApi::addHandler('Transfer', 'cancelQueue', function () {
    cancelQueue();
}, ['bookId', 'isAuthorized']);
