<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/10
 * Time: 11:08
 */

namespace App\Model;


use Sh\ORM;

class Groupuser extends ORM
{
    static $table = 'group_user';
    static $r = array(
        'user' => 'User'
    );
}