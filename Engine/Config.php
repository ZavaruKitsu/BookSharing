<?php


namespace Engine;

/**
 * Class Config
 * @package Engine
 */
class Config
{
    // Данные для подключения к базе данных
    /**
     * @var string
     */
    public static $db_engine = 'pgsql';
    /**
     * @var string
     */
    public static $db_host = 'localhost';
    /**
     * @var string
     */
    public static $db_user = 'PUM';
    /**
     * @var string
     */
    public static $db_password = '<changed>';
    /**
     * @var string
     */
    public static $db_name = 'BookSharing';

    // Домен сайта + '/' в конце
    /**
     * @var string
     */
    public static $site_url = '//pum.radolyn.com/';

    // Название шаблона
    /**
     * @var string
     */
    public static $template = 'MaterialDesign';

    // Название сайта
    /**
     * @var string
     */
    public static $site_name = 'Book Crossing';

    // Режим разработки
    /**
     * @var bool
     */
    public static $is_development = true;

    // позволяет сменить шаблон с помощью явного указания template=NAME в запросе
    /**
     * @var bool
     */
    public static $template_changing = true;

    public static $template_loaders = ['MaterialDesign' => ['/Loaders/TemplateConfig.php', '/Loaders/TemplateApi.php']];
}
