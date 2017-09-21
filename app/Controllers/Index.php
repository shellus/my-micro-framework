<?php namespace App\Controllers;

use App\Models\Article;
use App\Models\Item;
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
        $p = Item::orderBy("id DESC")->paginate();
        $vars = [
            'models' => $p->items(),
            'links' => $p->links(),
        ];
        return View::load('item')->vars($vars)->render();
    }

    public function test()
    {

        dump(ORM::$db->table('navigations')->insert([
            'name' => '新链接',
            'href' => 'http://www.baidu.com',
            'icon' => '',
        ]));
        dump(ORM::$db->table('navigations')->column('id')->where([['name', '=', '新链接']])->select());

    }

    public function new_()
    {
        $navigations = Navigations::get();
        return $navigations;
    }
}