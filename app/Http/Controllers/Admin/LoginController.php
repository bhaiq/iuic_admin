<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/5/7
 * Time: 18:26
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // 重定义跳转页面
    public function redirectTo()
    {
        return 'admin/';
    }

    // 重定义认证驱动
    protected function guard()
    {
        return auth()->guard('admin');
    }

    // 重定义登录页面
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // 退出登录页面
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->forget($this->guard()->getName());

        $request->session()->regenerate();

        return redirect('/admin/login');
    }

    // 登录验证
    public function login(Request $request) {

        if ($this->guard()->attempt(['email' =>$request->get("username"), 'password' => $request->password])) {
            return $this->sendLoginResponse($request);
        }

        if ($this->guard()->attempt(['name' =>$request->get("username"), 'password' => $request->password])) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

}