<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/10
 * Time: 9:44
 */

namespace Sh;


class Config
{
    static public $config;

    static public function load_config($path){
        $dir = @ dir($path);

        while (($file = $dir->read())!==false)
        {
            $path = $dir -> path . '/' . $file;
            if(!is_dir($path) AND ($file != ".") AND ($file != "..")) {
                \Sh\Config::set(pathinfo($path, PATHINFO_FILENAME), (require $path));
            }
        }
        $dir->close();
    }

    static public function set($key, $value)
    {
        static::$config[$key] = $value;
    }
    static public function get($key = null)
    {
        $s = static::$config;
        $arr = explode('.', $key);
        foreach ($arr as $item){
            $s = $s[$item];
        }

        if($key === null){
            return static::$config;
        }

        return $s;
    }

}