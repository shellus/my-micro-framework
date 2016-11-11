<?php namespace Sh;

/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 17:27
 */
class Router
{
    static $routers = [];

    static public function get($pattern, $action)
    {
        return static::router($pattern, $action, "GET");
    }
    static public function post($pattern, $action)
    {
        return static::router($pattern, $action, "POST");
    }

    static public function router($pattern, $action, $method)
    {
        static::$routers[] = [
            'pattern' => $pattern,
            'action' => $action,
            'method' => $method,
        ];
    }

    static public function d()
    {
        foreach (self::$routers as $route) {
            if (preg_match($route['pattern'], $path) !== 0 && $route['method'] === ) {
                list($c, $a) = explode('@', $route['action']);
                $html = (new $c)->$a();
                return $html;
            }
        }
        return view('404');
    }
}

