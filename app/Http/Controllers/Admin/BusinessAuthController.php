<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/20
 * Time: 9:50
 */

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\AccountLog;
use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BusinessAuthController extends Controller
{

    // 商家认证列表
    public function index(Request $request)
    {

        $isAuth = $request->get('status', 0);

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', '');

            $p = Business::from('auth_business as a')
                ->select('a.*', 'u.mobile', 'u.nickname', 'c.name as coin_name')
                ->join('user as u', 'u.id', 'a.uid')
                ->join('coin as c', 'c.id', 'a.coin_id')
                ->where('a.status', $isAuth);

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.nickname', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('a.id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            foreach ($data['data'] as $k => $v){

                $data['data'][$k]['coin_type_name'] = Business::COIN_TYPE[$v['coin_type']];

            }

            return response()->json($data);
        }

        return view('admin.business_auth.index');

    }

    // 用户认证更新
    public function ajax(Request $request)
    {

        if($request->isMethod('GET')){

            $id = $request->get('id', 0);
            $b = Business::find($id);
            if(!$b){
                return returnJson(0, '数据有误');
            }

            $data = [
                'id' => $b->id,
                'amount' => $b->amount,
            ];

            return view('admin.business_auth.ajax', $data);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:1,2,3,4,5',
        ], [
            'uid.required' => '用户信息不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态数据不正确',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        $res = [
            'code' => 0,
            'msg' => '数据有误',
        ];

        switch ($request->get('status')){
            // 通过认证商家申请
            case 1:
                $res = $this->adoptAuthApply($request->get('id'));
                break;

            // 拒绝认证商家申请
            case 2:
                $res = $this->refuseAuthApply($request->get('id'));
                break;

            // 同意取消商家申请
            case 3:
                $amount = $request->get('amount', 0);
                $res = $this->adoptQuit($request->get('id'), $amount);
                break;

            // 拒绝取消商家申请
            case 5:
                $res = $this->opposeQuit($request->get('id'));
                break;



        }

        if($res['code'] != 1){
            return returnJson(0, $res['msg']);
        }


        return returnJson(1, '操作成功');

    }

    // 通过认证商家申请
    private function adoptAuthApply($id)
    {

        // 先判断用户是否是申请认证状态
        $a = Business::where('id', $id)->where('status', 0)->first();
        if(!$a){
            return [
                'code' => 0,
                'msg' => '数据有误'
            ];
        }

        \DB::beginTransaction();
        try {

            // 认证申请表更新
            $a->status = 1;
            $a->save();

            // 用户表更新
            User::where('id', $a->uid)->update(['is_business' => 1]);

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            return [
                'code' => 0,
                'msg' => '操作异常',
            ];

        }

        return [
            'code' => 1,
            'msg' => '操作成功',
        ];

    }

    // 拒绝用户认证商家申请
    private function refuseAuthApply($id)
    {

        // 先判断用户是否是申请认证状态
        $a = Business::where('id', $id)->where('status', 0)->first();
        if(!$a){
            return [
                'code' => 0,
                'msg' => '数据有误'
            ];
        }

        \DB::beginTransaction();
        try {

            // 用户余额更新
            Account::addAmount($a->uid, $a->coin_id, $a->amount, $a->coin_type);

            // 用户余额表更新
            AccountLog::addLog($a->uid, $a->coin_id, $a->amount, 16, 1, $a->coin_type, '认证商家未通过');

            // 用户表更新
            User::where('id', $a->uid)->update(['is_business' => 0]);

            // 认证申请表更新
            $a->delete();


            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            return [
                'code' => 0,
                'msg' => '操作异常',
            ];

        }

        return [
            'code' => 1,
            'msg' => '操作成功',
        ];

    }

    // 同意取消商家申请
    private function adoptQuit($id, $amount)
    {

        if($amount < 0){
            return [
                'code' => 0,
                'msg' => '数据有误'
            ];
        }

        // 先判断用户是否是申请认证状态
        $a = Business::where('id', $id)->whereIn('status', [1, 2])->first();
        if(!$a){
            return [
                'code' => 0,
                'msg' => '数据有误'
            ];
        }

        \DB::beginTransaction();
        try {

            // 用户余额表更新
            Account::addAmount($a->uid, $a->coin_id, $amount, $a->coin_type);

            // 用户余额日志更新
            AccountLog::addLog($a->uid, $a->coin_id, $amount, 17, 1, $a->coin_type, '取消商家认证');

            // 用户表更新
            User::where('id', $a->uid)->update(['is_business' => 0]);

            // 认证申请表更新
            $a->delete();

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            return [
                'code' => 0,
                'msg' => '操作异常',
            ];

        }

        return [
            'code' => 1,
            'msg' => '操作成功',
        ];

    }

    // 拒绝退出商家
    private function opposeQuit($id)
    {

        // 先判断用户是否是申请认证状态
        $a = Business::where('id', $id)->where('status', 2)->first();
        if(!$a){
            return [
                'code' => 0,
                'msg' => '数据有误'
            ];
        }

        \DB::beginTransaction();
        try {

            // 认证申请表更新
            $a->status = 1;
            $a->save();

            // 用户表更新
            User::where('id', $a->uid)->update(['is_business' => 1]);


            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            return [
                'code' => 0,
                'msg' => '操作异常',
            ];

        }

        return [
            'code' => 1,
            'msg' => '操作成功',
        ];

    }

}