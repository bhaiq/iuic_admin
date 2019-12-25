<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/15
 * Time: 17:56
 */

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\AccountLog;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{

    // 钱包列表
    public function index(Request $request)
    {

        $soso = $request->get('soso', '');

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $p = Account::from('account as a')
                ->select('a.*', 'u.mobile', 'u.new_account', 'c.name as coin_name', 'aa.name as realname')
                ->leftJoin('user as u', 'u.id', 'a.uid')
                ->leftJoin('coin as c', 'c.id', 'a.coin_id')
                ->leftJoin('authentication as aa', 'aa.uid', 'a.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('c.name', 'like', '%' . $soso . '%')
                        ->orwhere('aa.name', 'like', '%' . $soso . '%')
                        ->orwhere('u.new_account', 'like', '%' . $soso . '%');
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

            foreach ($data['data'] as $k => $v){

                if($v['amount_freeze'] < 0){
                    $data['data'][$k]['amount_freeze'] = '0.00000000';
                }

            }

            return response()->json($data);
        }

        return view('admin.wallet.index', ['soso' => $soso]);

    }

    // 钱包异步操作
    public function ajax(Request $request)
    {

        $id = $request->get('id');
        $a = Account::with('coin')->find($id);
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

                $coinType = ($a->type == 0) ? '币币' : '法币';

                // 用户增加或减少余额
                if($request->get('type') == 1){

                    // 记录管理日志
                    AdminLog::addLog('给用户ID'.$a->uid.'的'.$a->coin->name.$coinType.'资产增加'.$request->get('num'), $a->uid);

                    // 用户余额增加
                    Account::where('id', $id)->increment('amount', $request->get('num'));

                    // 记录用户余额日志
                    AccountLog::addLog($a->uid, $a->coin_id, $request->get('num'), 1, 1, $a->type, '系统增加');

                }else{

                    // 判断余额是否充足
                    if($a->amount < $request->get('num')){
                        return returnJson(0, '用户余额不足');
                    }

                    // 记录管理日志
                    AdminLog::addLog('给用户ID'.$a->uid.'的'.$a->coin->name.$coinType.'资产减少'.$request->get('num'), $a->uid);

                    // 用户余额减少
                    Account::where('id', $id)->decrement('amount', $request->get('num'));

                    // 记录用户余额日志
                    AccountLog::addLog($a->uid, $a->coin_id, $request->get('num'), 1, 0, $a->type, '系统减少');

                }

                \DB::commit();

            } catch (\Exception $exception) {

                \DB::rollBack();

                \Log::info('用户改变余额失败', $request->all());

                return returnJson(0, '操作异常');

            }

            return returnJson(1, '操作成功');

        }

        $data = [
            'id' => $id,
            'amount' => $a->amount,
            'amount_freeze' => $a->amount_freeze,
        ];

        return view('admin.wallet.ajax', $data);
    }

}