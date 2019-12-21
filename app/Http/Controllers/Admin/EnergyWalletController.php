<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/21
 * Time: 10:47
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\EnergyLog;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EnergyWalletController extends Controller
{

    // 钱包列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', '');

            $p = UserWallet::from('user_wallet as uw')
                ->select('uw.*', 'u.mobile', 'aa.name as realname')
                ->leftJoin('user as u', 'u.id', 'uw.uid')
                ->leftJoin('authentication as aa', 'aa.uid', 'uw.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('aa.name', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            if($limit == 9999){
                $p->latest('id');
            }else{
                $p->latest('id')->skip(($page - 1) * $limit)->take($limit);
            }

            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.energy_wallet.index');

    }

    // 钱包异步操作
    public function ajax(Request $request)
    {

        $uid = $request->get('id');
        $a = UserWallet::where('uid', $uid)->first();
        if(!$a){
            return returnJson(0, '数据有误');
        }

        if($request->isMethod('POST')){

            $validator = Validator::make($request->all(), [
                'type' => 'required|in:1,2',
                'num' => 'required|numeric',
            ], [
                'type.required' => '类型不能为空',
                'type.in' => '类型格式不正确',
                'num.required' => '数量不能为空',
                'num.numeric' => '数量格式不正确',
            ]);

            if ($validator->fails()) {
                return returnJson(0, $validator->errors()->first());
            }

            \DB::beginTransaction();
            try {

                // 用户增加或减少余额
                if($request->get('type') == 1){

                    // 记录管理日志
                    AdminLog::addLog('给用户ID'.$a->uid.'的能量资产增加'.$request->get('num'), $a->uid);

                    // 用户余额增加
                    UserWallet::addEnergyNum($a->uid, $request->get('num'));

                    // 记录用户余额日志
                    EnergyLog::addLog($a->uid, 1, 0, 0, '系统增加', '+', $request->get('num'), 3);

                }else{

                    // 判断余额是否充足
                    if($a->energy_num < $request->get('num')){
                        return returnJson(0, '用户余额不足');
                    }

                    // 记录管理日志
                    AdminLog::addLog('给用户ID'.$a->uid.'的能量资产减少'.$request->get('num'), $a->uid);

                    // 用户余额增加
                    UserWallet::reduceEnergyNum($a->uid, $request->get('num'));

                    // 记录用户余额日志
                    EnergyLog::addLog($a->uid, 1, 0, 0, '系统减少', '-', $request->get('num'), 3);

                }

                \DB::commit();

            } catch (\Exception $exception) {

                \DB::rollBack();

                \Log::info('用户改变能量余额失败', $request->all());

                return returnJson(0, '操作异常');

            }

            return returnJson(1, '操作成功');

        }

        $data = [
            'uid' => $uid,
            'amount' => $a->energy_num,
            'amount_freeze' => $a->energy_frozen_num,
        ];

        return view('admin.energy_wallet.ajax', $data);
    }

}