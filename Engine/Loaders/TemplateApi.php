<?php


namespace Engine;


class TemplateApi
{
    private static $actions = [];
    private static $custom_checks = [];

    public static function addHandler($addon, $action, $func, $checks)
    {
        self::$actions[self::createAlias($addon, $action)] = [$func, $checks];
    }

    private static function createAlias($addon, $action)
    {
        return $addon . '.' . $action;
    }

    public static function addCheck($check, $func)
    {
        self::$custom_checks[$check] = $func;
    }

    public static function registerAll()
    {
        foreach (glob(__DIR__ . '/../Addons/*/Handler.php') as $filename) {
            require_once $filename;
        }
    }

    public static function executeHandler($addon, $action)
    {
        $alias = self::createAlias($addon, $action);
        if (!array_key_exists($alias, self::$actions))
            Helpers::jsonPrinter("Неизвестный запрос!", false);

        $env = self::$actions[$alias];

        foreach ($env[1] as $field) {
            if (array_key_exists($field, self::$custom_checks)) {
                $func = self::$custom_checks[$field];
                $res = $func();
                if (!$res)
                    Helpers::jsonPrinter("Ошибка при обработке $field!", false);
                continue;
            }

            if (!isset($_POST[$field]))
                Helpers::jsonPrinter("Поле $field не заполнено!", false);
        }

        $env[0]();
    }
}

if (!isset($api)) return;
if (!$api) return;

TemplateApi::registerAll();
TemplateApi::executeHandler($_POST['addon'], $_POST['action']);