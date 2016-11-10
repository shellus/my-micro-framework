<?php namespace App\Controller;

use App\Model\Navigations;
use App\Model\User;
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
        $user = new User([
            'name' => 'new user',
            'nick' => '新用户1'
        ]);
        $user->save();

        var_dump((string)$user);
        die();
    }

    public function new_()
    {
        $navigations = Navigations::get();
        return $navigations;
    }
}