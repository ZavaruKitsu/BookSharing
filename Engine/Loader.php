<?php


namespace Engine;

// Подключаем класс конфигурации
require_once __DIR__ . '/Config.php';

// Если включён режим разработчика - отображаем все ошибки и предупреждения
if (Config::$is_development) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

// Подключаем библиотеки
foreach (glob(__DIR__ . "/Libs/*.php") as $filename) {
    require_once $filename;
}

// Алиас для RedBeans
use R;

// Подключаем все остальные классы
foreach (glob(__DIR__ . "/*.php") as $filename) {
    require_once $filename;
}

/**
 * Class Loader
 * @package Engine
 */
class Loader
{
    /**
     * Initializes engine
     */
    public static function loadAll()
    {
        // Инициализируем класс с вспом. переменными
        Vars::initialize();

        // Инициализируем базу данных
        Loader::loadDb();

        // Выставляем заголовки
        Loader::setHeaders();
    }

    /**
     * Connects to database
     */
    private static function loadDb()
    {
        // Авторизовываемся
        R::setup(Config::$db_engine . ':host=' . Config::$db_host . ';dbname=' . Config::$db_name, Config::$db_user, Config::$db_password);

        // Тест соединения
        if (!R::testConnection()) ErrorsHandler::internalError();
    }

    /**
     * Sets headers for page
     */
    private static function setHeaders()
    {
        header('Content-Security-Policy: default-src https:; script-src https: http: \'unsafe-inline\'; style-src https: \'unsafe-inline\'; img-src https: http://www.w3.org \'self\' data: \'unsafe-inline\';');
        header('x-powered-by: Radolyn-Python');
        // Ловушка Джокера
        header('engine: WordPress 5.3');
        header('Content-Type: text/html; charset=utf-8');

        if (Config::$is_development)
            header('DEVELOPMENT: TRUE');
    }
}

Loader::loadAll();

// Подключаем все аддоны
foreach (glob(__DIR__ . "/Addons/*/Loader.php") as $filename) {
    require_once $filename;
}

// Подключаем аддоны для template
foreach (Config::$template_loaders[Config::$template] as $filename) {
    require_once __DIR__ . $filename;
}