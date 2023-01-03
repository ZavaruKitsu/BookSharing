<?php


namespace Engine;


/**
 * Class Web
 * @package Engine
 */
class Web
{
    /**
     * Includes header
     */
    public static function header()
    {
        $template = Vars::$web_dir;
        require_once Vars::$template_dir . 'header.php';
    }

    /**
     * Includes footer
     */
    public static function footer()
    {
        $template = Vars::$web_dir;
        require_once Vars::$template_dir . 'footer.php';
    }
}