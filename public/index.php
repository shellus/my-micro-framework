<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 17:27
 */


define('_APP_ROOT_PATH_', __DIR__ . DIRECTORY_SEPARATOR . '..');

require _APP_ROOT_PATH_ . '/vendor/autoload.php';



\Sh\Config::load_config(_APP_ROOT_PATH_ . '/config');

\Sh\View::load_config(_APP_ROOT_PATH_ . '/app/view/');

require _APP_ROOT_PATH_ . '/app/routes.php';

$uri = array_key_exists('REQUEST_URI', $_SERVER) ? $_SERVER['REQUEST_URI'] : '/';

$queryString = parse_url($uri, PHP_URL_QUERY);
$path = parse_url($uri, PHP_URL_PATH);


echo \Sh\Router::d($path);

