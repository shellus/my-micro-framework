<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/10
 * Time: 10:14
 */

function view($view, $vars = [])
{
    return \Sh\View::load($view) -> vars($vars)->render();
}

function config($key)
{
    return \Sh\Config::get($key);
}

function dump($var)
{
    var_dump($var);
}
function dd($var){
    dump($var);
    die();
}