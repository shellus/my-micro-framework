<?php namespace App\Controller;

use App\Model\Navigations;
use App\Model\User;
use App\Model\UserGroup;
use Sh\View;

/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/9
 * Time: 17:32
 */
class Index
{
    public function index()
    {
        $navigations = Navigations::get();
        return View::load('index') -> set('name', '123') -> set('navigations', $navigations)->render();
    }

    public function test()
    {
        var_dump(User::find(2));
        die();
    }

    public function new_()
    {
        $navigations = Navigations::get();
        return $navigations;
    }
}