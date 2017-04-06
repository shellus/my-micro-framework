<?php namespace App\Controllers;

use App\Models\Article;
use App\Models\Navigations;
use App\Models\User;
use Sh\DB;
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
        $vars = [
            'articles' => Article::limit(10)->get(),
            'name' => User::find(Session::get('user_id')) -> name,
        ];
        return View::load('index') -> vars($vars) -> render();
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