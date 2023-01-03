<?php


namespace Engine;

/**
 * Class Vars
 * @package Engine
 */
class Vars
{
    /**
     * @var
     */
    public static $template_dir;

    /**
     * @var
     */
    public static $web_dir;

    /**
     * Initializes static @class Vars
     */
    public static function initialize()
    {
        Vars::$template_dir = __DIR__ . '/Templates/' . Config::$template . '/';
        Vars::$web_dir = Config::$site_url . '/Engine/Templates/' . Config::$template . '/';
    }
}