<?php namespace App\Controller;

use App\Model\Navigations;
use App\Model\User;
use App\Model\UserGroup;
use Sh\ORM;
use Sh\Session;
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
        return View::load('index') -> set('name', User::find(Session::get('user_id')) -> name) -> render();
    }

    public function test()
    {

        dump(ORM::$db -> table('navigations') -> insert([
            'name' => '新链接',
            'href' => 'http://www.baidu.com',
            'icon' => '',
        ]));
        dump(ORM::$db -> table('navigations') -> column('id') -> where([['name','=','新链接']]) -> select());

    }

    public function new_()
    {
        $navigations = Navigations::get();
        return $navigations;
    }
}