<?php


namespace Engine;


/**
 * Class ErrorsHandler
 * @package Engine
 */
class ErrorsHandler
{
    /**
     *
     */
    public static function notFoundError()
    {
        include_once Vars::$template_dir . 'errors/404.php';
        exit();
    }

    /**
     *
     */
    public static function internalError()
    {
        include_once Vars::$template_dir . 'errors/500.php';
        exit();
    }

    /**
     *
     */
    public static function forbiddenError()
    {
        include_once Vars::$template_dir . 'errors/403.php';
        exit();
    }

    /**
     *
     */
    public static function underconstructionError()
    {
        include_once Vars::$template_dir . 'errors/underconstruction.php';
        exit();
    }
}