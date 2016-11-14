<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/14
 * Time: 14:42
 */

namespace Sh;


class Controller
{
    protected function success($msg){
        return $this -> message($msg, 'success');
    }
    protected function fail($msg){
        return $this -> message($msg, 'fail');
    }
    protected function message($msg, $type){
        return view($type, ['message' => $msg]);
    }
}