<?php namespace App\Controller;

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
        return View::load('index')->set('name', 'abc')->render();
    }

    public function test()
    {
        $user = new User([
            'name' => 'new user',
            'nick' => '新用户1'
        ]);
        $user->save();

        var_dump($user->values());
        die();
    }
}