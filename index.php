<?php

namespace Engine;

require_once __DIR__ . '/Engine/Loader.php';


/**
 * @param $name
 */
function loadPage($name)
{
    // prevent from directory escaping
    $name = str_replace('..', '', $name);
    $name = str_replace('/', '', $name);

    $template = Vars::$web_dir;
    $path = Vars::$template_dir . $name . '.php';

    if (file_exists($path))
        require_once $path;
    else
        ErrorsHandler::notFoundError();
}

/**
 * @param $id
 */
function loadBook()
{
    require_once Vars::$template_dir . 'book.php';
}

if (Config::$template_changing && isset($_GET['template'])) {
    Config::$template = $_GET['template'];
    Vars::initialize();
}

if (!isset($_GET['book']) && !isset($_GET['page'])) {
    loadPage('index');
} elseif (isset($_GET['book']) && !isset($_GET['page'])) {
    loadBook();
} elseif (!isset($_GET['book']) && isset($_GET['page'])) {
    loadPage($_GET['page']);
} else {
    ErrorsHandler::internalError();
}