<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2020/1/20
 * Time: 10:28
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateSeniorAdmin;
use App\Models\Account;
use App\Models\AccountLog;
use App\Models\SeniorAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeniorAdminController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = SeniorAdmin::from('senior_admin as sa')
                ->select('sa.*', 'u.mobile', 'u.new_account', 'a.name as realname')
                ->join('user as u', 'u.id', 'sa.uid')
                ->leftJoin('authentication as a', 'a.uid', 'sa.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.new_account', 'like', '%' . $soso . '%')
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

        return view('admin.senior_admin.index');

    }

    // 用户提现订单更新
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

        $sa = SeniorAdmin::where('id', $request->get('id'))->where('status', 0)->first();
        if(!$sa){
            return returnJson(0, '数据有误');
        }

        \DB::beginTransaction();
        try {

            if($request->get('status') == 1){

                // 用户冻结余额减少
                Account::reduceFrozen($sa->uid, 2, $sa->num, Account::TYPE_LC);

                // 增加用户余额变化日志
                AccountLog::addLog($sa->uid, 2, $sa->num, 23, 0, Account::TYPE_LC, '申请高级管理奖');

                // 订单状态变化
                $sa->status = 1;
                $sa->save();

                // 用户状态改变
                User::where('id', $sa->uid)->update(['is_senior_admin' => 1]);

                dispatch(new UpdateSeniorAdmin($sa->uid));

            }else{

                // 用户冻结余额减少
                Account::reduceFrozen($sa->uid, 2, $sa->num, Account::TYPE_LC);

                // 用户普账户余额增加
                Account::addAmount($sa->uid, 2, $sa->num, Account::TYPE_LC);

                // 订单状态变化
                SeniorAdmin::where('id', $sa->id)->delete();

                // 用户状态改变
                User::where('id', $sa->uid)->update(['is_senior_admin' => 9]);

            }

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            \Log::info('更新用户申请高级管理奖', $request->all());

            return returnJson(0, '操作异常');

        }

        return returnJson(1, '操作成功');

    }

}