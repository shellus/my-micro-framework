<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/11
 * Time: 18:02
 */

namespace App\Controllers;


use App\Model\User;
use Sh\Controller;
use Sh\Request;
use Sh\Session;

class Auth extends Controller
{
    public function getRegister()
    {
        return view('register');
    }

    public function postRegister()
    {

        if(User::where('email', '=', Request::get('email')) -> count() !== 0){
            return $this->fail('邮箱已存在');
        }
        if(User::where('name', '=', Request::get('name')) -> count() !== 0){
            return $this->fail('用户名已存在');
        }


        $data = Request::only(['email', 'name', 'password']);

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $user = new User($data);
        try {
            $user->save();
        } catch (\Exception $e) {
            return $this->fail('注册失败');
        }

        return $this->success('注册成功');
    }

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin()
    {
        if(User::where('email', '=', Request::get('email')) -> count() !== 1){
            return $this->fail('邮箱不存在');
        }
        $user = User::where('email', '=', Request::get('email')) -> get() -> first();

        if(password_verify(Request::get('password'), $user -> password))
        {
            Session::set('user_id', $user -> id);
            return $this->success('登录成功');
        }else
        {
            return $this->fail('密码错误');
        }
    }

}