<?php


namespace Engine;


/**
 * Class Helpers
 * @package Engine
 */
class Helpers
{
    /**
     * @param $str
     * @return string|string[]
     */
    public static function replaceNewLines($str)
    {
        return str_replace(array("\r\n", "\r", "\n"), '<br>', $str);
    }

    /**
     * @param $str
     * @return string|string[]
     */
    public static function reverseNewLines($str)
    {
        return str_replace('<br>', "\n", $str);
    }


    /**
     * @param $str
     * @return string|string[]|null
     */
    public static function clearStr($str)
    {
        return preg_replace('%[^A-Za-zА-Яа-я0-9_]%', '', $str);
    }

    /**
     * @param $msg
     * @param $code
     * @param null $aditInfo
     */
    public static function jsonPrinter($msg, $code, $aditInfo = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        if ($aditInfo != null)
            echo(json_encode(array('message' => $msg, 'code' => $code, 'aditInfo' => $aditInfo)));
        else
            echo(json_encode(array('message' => $msg, 'code' => $code)));
        exit();
    }
}