<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 17:27
 */

define('_APP_ROOT_PATH_', __DIR__ . '/..' .  DIRECTORY_SEPARATOR);



require __DIR__ . '/../vendor/autoload.php';


\Sh\Config::load_config(__DIR__ . '/../config');

\Sh\ORM::$db = new \Sh\DB(config('app.database'));

\Sh\View::load_config(__DIR__ . '/../view/');

require __DIR__ . '/../routes.php';

$uri = array_key_exists('REQUEST_URI', $_SERVER) ? $_SERVER['REQUEST_URI'] : '/';

$queryString = parse_url($uri, PHP_URL_QUERY);
$path = parse_url($uri, PHP_URL_PATH);

$response = \Sh\Router::d($path);

if (is_array($response) || $response instanceof \Sh\Collection){
    header('Content-Type: application/json; charset=utf-8');
}


echo $response;
