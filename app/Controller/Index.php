<?php namespace App\Controller;

use App\Model\Navigations;
use App\Model\User;
use App\Model\UserGroup;
use Sh\ORM;
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

        dump(ORM::$db -> table('navigations') -> insert([
            'name' => '新链接',
            'href' => 'http://www.baidu.com',
            'icon' => '',
        ]));

        dump(ORM::$db -> table('navigations') -> where([['name','=','新链接']]) -> select());

        dump(ORM::$db -> table('navigations') ->where([['name','=','新链接']]) -> update(['name' => '新链接_new']) );

        dump(ORM::$db -> table('navigations') -> where([['name','=','新链接_new']]) -> delete());

        dump(Navigations::get());
    }

    public function new_()
    {
        $navigations = Navigations::get();
        return $navigations;
    }
}