<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/16
 * Time: 14:05
 */

namespace Sh;


class Session
{
    protected static $attributes;

    public static function start()
    {
        session_start();
        self::$attributes = $_SESSION;
        return true;
    }
    public static function getId()
    {
        return session_id();
    }
    public static function setId($id = null)
    {
        return session_id($id);
    }
    public static function get($name, $default = null)
    {

        return self::$attributes[$name];
    }
    public static function set($name, $value)
    {
        self::$attributes[$name] = $value;
        $_SESSION = self::$attributes;
    }
    public static function save()
    {
        session_write_close();
    }
}