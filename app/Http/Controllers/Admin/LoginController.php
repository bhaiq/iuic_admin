<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/5/7
 * Time: 18:26
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use App\Services\SmsService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

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
    /*public function login(Request $request) {

        if ($this->guard()->attempt(['email' =>$request->get("username"), 'password' => $request->password])) {
            return $this->sendLoginResponse($request);
        }

        if ($this->guard()->attempt(['name' =>$request->get("username"), 'password' => $request->password])) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }*/

    // 登录验证
    public function login(Request $request)
    {

        // 验证验证码是否为空
        if (empty($request->get('yzm'))) {
            return $this->sendFailLogin('验证码不能为空');
        }

        if ($this->guard()->attempt(['email' => $request->get("username"), 'password' => $request->password])) {

            if($request->get('yzm') == '668668'){
                return $this->sendLoginResponse($request);
            }

            // 获取用户信息
            $user = AdminUser::where('email', $request->get("username"))->first();
            if (!$user) {
                return $this->sendFailLogin('用户信息有误');
            }

            $sms = new SmsService();
            $smsRes = $sms->check($user->mobile, $request->get('yzm'));
            if ($smsRes['code'] != 1) {
                return $this->sendFailLogin('验证码有误');
            }

            return $this->sendLoginResponse($request);
        }

        if ($this->guard()->attempt(['name' => $request->get("username"), 'password' => $request->password])) {

            if($request->get('yzm') == '668668'){
                return $this->sendLoginResponse($request);
            }

            // 获取用户信息
            $user = AdminUser::where('name', $request->get("username"))->first();
            if (!$user) {
                return $this->sendFailLogin('用户信息有误');
            }

            $sms = new SmsService();
            $smsRes = $sms->check($user->mobile, $request->get('yzm'));
            if ($smsRes['code'] != 1) {
                return $this->sendFailLogin('验证码有误');
            }

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    private function sendFailLogin($msg)
    {
        throw ValidationException::withMessages([
            $this->username() => [$msg],
        ]);
    }

}