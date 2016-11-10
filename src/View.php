<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/10
 * Time: 10:01
 */

namespace Sh;


class View
{
    static protected $path;


    static public function load_config($path){
//        static::$path = \Sh\Config::get('app.view_path');
        static::$path = $path;
    }

    static public function render($view){
        ob_start();
        require static::$path . $view . '.php';
        $body = ob_get_clean();

        if(empty($title)){
            $title = '';
        }
        ob_start();
        require static::$path . 'layout' . '.php';
        $html = ob_get_clean();

        return $html;
    }
}