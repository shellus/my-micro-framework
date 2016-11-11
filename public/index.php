<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 17:27
 */

require __DIR__ . '../app/bootstrap.php';

$response = \Sh\Router::d($path);

if (is_array($response) || $response instanceof \Sh\Collection){
    header('Content-Type: application/json; charset=utf-8');
}


echo $response;
