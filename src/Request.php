<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/11
 * Time: 18:16
 */

namespace Sh;


class Request
{
    static public $requestUri;
    static public $path;
    static public $queryString = '';
    static public $query = [];
    static public $method;

    static public $formats = [];
    static public $raw_content;
    static public $content = [];


    static public function createFromWEB()
    {
        static::$requestUri = array_key_exists('REQUEST_URI', $_SERVER) ? $_SERVER['REQUEST_URI'] : '/';

        $queryString = parse_url(static::$requestUri, PHP_URL_QUERY);
        parse_str($queryString, static::$query);

        static::$path = parse_url(static::$requestUri, PHP_URL_PATH);

        $file = pathinfo(static::$path, PATHINFO_BASENAME);

        // 兼容/index.php的方式访问
        if($file == "index.php"){
            static::$path = str_replace($file, '', static::$path);
        }

        static::$method = strtoupper($_SERVER['REQUEST_METHOD']);

        if (!empty($_SERVER['HTTP_CONTENT_TYPE'])){
            static::$raw_content = file_get_contents('php://input');

            if (0 === strpos($_SERVER['HTTP_CONTENT_TYPE'], 'application/x-www-form-urlencoded'))
            {
                parse_str(static::$raw_content, static::$content);
            }elseif (0 === strpos($_SERVER['HTTP_CONTENT_TYPE'], 'application/json'))
            {
                static::$content = json_decode(static::$raw_content, true)?:[];
            }
        }
    }

    static function get($key = null, $default = null)
    {
        if($key === null)return static::$query;
        if(empty(static::$query[$key]))return $default;
        return static::$query[$key];
    }
    static function post($key = null, $default = null){
        if($key === null)return static::$content;
        if(empty(static::$content[$key]))return $default;
        return static::$content[$key];
    }
}