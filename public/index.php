<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 17:27
 */


define('_APP_ROOT_PATH_', __DIR__ . DIRECTORY_SEPARATOR . '..');

require _APP_ROOT_PATH_ . '/vendor/autoload.php';
function config($key = null){

    return $config = [
        'app' => [
            'view_path' => _APP_ROOT_PATH_ . '/app/view/'
        ],
    ];
}

function view($view){
    ob_start();
    require config()['app']['view_path'] . $view . '.php';
    $body = ob_get_clean();

    if(empty($title)){
        $title = '';
    }
    ob_start();
    require config()['app']['view_path'] . 'layout' . '.php';
    $html = ob_get_clean();

    return $html;
}

$routes = require _APP_ROOT_PATH_ . '/app/routes.php';

$uri = $_SERVER['REQUEST_URI'];

$queryString = parse_url($uri, PHP_URL_QUERY);
$path = parse_url($uri, PHP_URL_PATH);


echo \Sh\Router::d($path);

