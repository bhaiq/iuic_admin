<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/16
 * Time: 10:59
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\Authentication;
use App\Models\ReleaseOrder;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserWalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{

    // 用户认证列表
    public function index(Request $request)
    {

        $isAuth = $request->get('is_auth', 2);

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', '');

            $p = Authentication::from('authentication as a')
                ->select('a.*', 'u.mobile', 'u.nickname', 'u.is_auth')
                ->join('user as u', 'u.id', 'a.uid')
                ->where('u.is_auth', $isAuth);

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.nickname', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('a.created_at')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.user_auth.index');

    }

    // 用户认证更新
    public function ajax(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'status' => 'required|in:1,2',
        ], [
            'uid.required' => '用户信息不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态数据不正确',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        $a = Authentication::with('user')->where('uid', $request->get('uid'))->first();
        if(!$a){
            return returnJson(0, '数据有误');
        }
        if(!isset($a->user) || $a->user->is_auth != 2){
            return returnJson(0, '该申请状态已经改变');
        }

        \DB::beginTransaction();
        try {

            if($request->get('status') == 1){

                // 认证状态改变
                User::where('id', $a->uid)->update(['is_auth' => 1]);

                // 赠送客户矿池
                $reward = config('reward.auth_reward', 100);
                
              	if(UserInfo::where('uid', $a->uid)->exists()){
                	UserInfo::where('uid', $a->uid)->increment('buy_total', $reward);
                }else{
                	$user = User::where('id', $a->uid)->first();
                    $ulData = [
                        'uid' => $user->id,
                        'pid' => $user->pid,
                        'pid_path' => $user->pid_path,
                        'level' => 0,
                        'buy_total' => $reward,
                        'buy_count' => 0,
                        'created_at' => now()->toDateTimeString(),
                    ];
                    UserInfo::create($ulData);
                }
              
                // 释放订单表增加
                $reoData = [
                    'uid' => $a->uid,
                    'total_num' => $reward,
                    'today_max' => bcmul($reward, 0.01, 2),
                    'release_time' => now()->subDay()->toDateTimeString(),
                    'created_at' => now()->toDateTimeString(),
                ];
                ReleaseOrder::create($reoData);

                // 上级奖励日志
                UserWalletLog::addLog($a->uid, 0, 0, '实名认证奖励', '+', $reward, 2, 1);

                // 管理员日志更新
                AdminLog::addLog('同意了用户ID为'.$a->uid.'的认证申请', $a->uid);

            }else{

                // 认证状态改变
                User::where('id', $a->uid)->update(['is_auth' => 0]);

                // 管理员日志更新
                AdminLog::addLog('拒绝了用户ID为'.$a->uid.'的认证申请', $a->uid);

                // 删除认证信息
                Authentication::where('uid', $a->uid)->delete();

            }

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            \Log::info('更改用户认证状态', $request->all());

            return returnJson(0, '操作异常');

        }

        return returnJson(1, '操作成功');

    }

}