<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/3/20
 * Time: 9:11
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class AuthAdmin
{

    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->user()->id === 1 || Auth::guard('admin')->user()->id === 3) {
            return $next($request);
        }else{
            if (Auth::guard('admin')->user()->status === 0 && Auth::guard('admin')->check()) {
                Auth::guard('admin')->logout();
                return redirect()->guest("/admin/login")->withErrors('账号被冻结，请联系管理员！');
            }
        }

        $previousUrl = URL::previous();
        $routeName = starts_with(Route::currentRouteName(), 'admin.') ? Route::currentRouteName() : 'admin.' . Route::currentRouteName();

        // 首页不需要权限
        // if($routeName == 'admin.index.index'){
        //     return $next($request);
        // }

        if (!Gate::forUser(auth('admin')->user())->check($routeName)) {
            if ($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => -1,
                    'code'   => 403,
                    'msg'    => '您没有权限执行此操作',
                ]);
            } else {
                return response()->view('admin.errors.403', compact('previousUrl'));
            }
        }

        return $next($request);
    }

}