<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/11
 * Time: 18:02
 */

namespace App\Controller;


use App\Model\User;
use Sh\Controller;
use Sh\Request;

class Auth extends Controller
{
    public function getRegister()
    {
        return view('register');
    }

    public function postRegister()
    {

        $data = Request::only(['email', 'name', 'password']);
        $user = new User($data);

        try {
            $user->save();
        } catch (\Exception $e) {
            return $this->fail('注册失败');
        }
        return $this->success('注册成功');
    }
}