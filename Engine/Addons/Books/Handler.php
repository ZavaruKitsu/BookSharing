<?php

namespace Engine\Addons\Books;

use Engine\Addons\History\History;
use Engine\Config;
use Engine\Helpers;
use Engine\TemplateApi;
use Engine\Vars;
use R;

function convertImage($originalImage, $outputImage, $name)
{
    // jpg, png, gif or bmp?
    $exploded = explode('.', $name);
    $ext = $exploded[count($exploded) - 1];

    if (preg_match('/jpg|jpeg/i', $ext))
        $imageTmp = imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i', $ext))
        $imageTmp = imagecreatefrompng($originalImage);
    else
        return false;

    imagejpeg($imageTmp, $outputImage, 75);
    imagedestroy($imageTmp);

    return true;
}

function uploadImage()
{
    $imageName = $_POST['id'] . '.jpg';
    $upload = Vars::$template_dir . Config::$imgDir . $imageName;
    $image = $_FILES['img'];
    if (file_exists($upload))
        unlink($upload);
    if (!convertImage($image['tmp_name'], $upload, $image['name']))
        Helpers::jsonPrinter('Проiзошiв троллiнг, обратитесь к разработчику.', false);
    $book = Books::getById($_POST['id']);
    $book->image = $imageName;
    R::store($book);
    Helpers::jsonPrinter('Обложка загружена!', true);
}

function editBook()
{
    $book = Books::getById($_POST['id']);
    if ($book->owner !== $_POST['owner']) {
        $history = History::getOneBookHistory($book->id, $book->owner, 'reading');
        if ($history != null) {
            History::editHistory($history->id, 'status', 'read');
            History::addHistory($book->id, $_POST['owner'], 'reading');
            $book->owner = $_POST['owner'];
        }
    }
    $book->name = $_POST['name'];
    $book->author = $_POST['author'];
    $book->desc = Helpers::replaceNewLines($_POST['desc']);
    $book->hidden = filter_var($_POST['hidden'], FILTER_VALIDATE_BOOLEAN);
    R::store($book);
    Helpers::jsonPrinter('Книга изменена!', true);
}

function addBook()
{
    $result = Books::addBook($_POST['name'], $_POST['author'], $_POST['desc'], $_POST['owner'], filter_var($_POST['hidden'], FILTER_VALIDATE_BOOLEAN));
    if (!$result)
        Helpers::jsonPrinter('Книга с таким названием уже есть!', false);
    Helpers::jsonPrinter('Книга добавлена! ID: ' . $result, true, $result);
}

TemplateApi::addHandler('Books', 'uploadImage', function () {
    uploadImage();
}, ['id', 'isAdmin']);
TemplateApi::addHandler('Books', 'editBook', function () {
    editBook();
}, ['id', 'isAdmin']);
TemplateApi::addHandler('Books', 'addBook', function () {
    addBook();
}, ['name', 'author', 'owner', 'hidden', 'isAdmin']);