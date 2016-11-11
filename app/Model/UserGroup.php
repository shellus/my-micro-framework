<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/11
 * Time: 9:54
 */

namespace App\Model;


use Sh\ORM;

class UserGroup extends ORM
{
    static $table = 'user_groups';

    public function users(){
        return $this -> hasMany(User::class, 'group_id', 'id');
    }

}