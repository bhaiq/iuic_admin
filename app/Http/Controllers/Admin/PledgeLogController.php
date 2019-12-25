<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/24
 * Time: 18:09
 */

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\AccountLog;
use App\Models\AdminLog;
use App\Models\PledgeLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PledgeLogController extends Controller
{

    // 质押记录
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = PledgeLog::from('pledge_log as pl')
                ->select('pl.*', 'u.mobile', 'u.new_account', 'a.name as realname')
                ->join('user as u', 'u.id', 'pl.uid')
                ->leftJoin('authentication as a', 'a.uid', 'pl.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.mobile', 'like', '%' . $soso . '%')
                        ->orwhere('a.name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.pledge_log.index');

    }

    // 用户取出订单更新
    public function ajax(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:1,9',
        ], [
            'id.required' => '用户信息不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态数据不正确',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        $ce = PledgeLog::where('id', $request->get('id'))->where('status', 0)->first();
        if(!$ce){
            return returnJson(0, '数据有误');
        }

        // 验证质押余额
        $user = User::find($ce->uid);
        if(!$user || $user->pledge_num < $ce->num){
            return returnJson(0, '用户数据有误');
        }

        \DB::beginTransaction();
        try {

            if($request->get('status') == 1){

                // 用户质押余额减少
                User::where('id', $ce->uid)->decrement('pledge_num', $ce->num);

                // 用户余额增加
                Account::addAmount($ce->uid, 2, $ce->num, Account::TYPE_LC);

                // 增加用户余额变化日志
                AccountLog::addLog($ce->uid, 2, $ce->num, 23, 1, Account::TYPE_LC, '质押取出');

                // 订单状态变化
                $ce->status = 1;
                $ce->save();

                AdminLog::addLog('通过用户的质押取出申请', $ce->uid);

            }else{

                // 订单状态变化
                $ce->status = 2;
                $ce->save();

                AdminLog::addLog('拒绝用户的质押取出申请', $ce->uid);

            }

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            \Log::info('更新用户质押状态出现异常', $request->all());

            return returnJson(0, '操作异常');

        }

        return returnJson(1, '操作成功');

    }

}