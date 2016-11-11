<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/10
 * Time: 10:30
 */

namespace App\Model;


use Sh\ORM;

class User extends ORM
{
    static $table = 'users';
    static $r = array(
        'group' => UserGroup::class,
    );


    public function group(){
        return $this -> belongsTo(UserGroup::class, 'group_id');
    }
}