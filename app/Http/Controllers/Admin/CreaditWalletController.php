<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\EcologyCreadits;
use App\Models\EcologyCreaditsLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;

class CreaditWalletController extends Controller
{
    //
    // 钱包列表
    public function index(Request $request)
    {

        $soso = $request->get('soso', '');

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $p = EcologyCreadits::from('ecology_creadits as a')
                ->select('a.*', 'u.mobile', 'u.new_account', 'aa.name as realname')
                ->leftJoin('user as u', 'u.id', 'a.uid')
                ->leftJoin('authentication as aa', 'aa.uid', 'a.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('aa.name', 'like', '%' . $soso . '%')
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

        return view('admin.creadit_wallet.index', ['soso' => $soso]);

    }

    // 钱包异步操作
    public function ajax(Request $request)
    {

        $id = $request->get('id');
        $a = EcologyCreadits::find($id);
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
                    AdminLog::addLog('给用户ID'.$a->uid.'的可用积分增加'.$request->get('num'), $a->uid);

                    // 用户余额增加
                    EcologyCreadits::where('id', $id)->increment('amount', $request->get('num'));

                    // 记录用户余额日志
                    EcologyCreaditsLog::addLog($a->uid, $request->get('num'), 1, 9, "后台操作", 1);

                }else{

                    // 判断余额是否充足
                    if($a->amount < $request->get('num')){
                        return returnJson(0, '用户积分余额不足');
                    }

                    // 记录管理日志
                    AdminLog::addLog('给用户ID'.$a->uid.'的可用积分减少'.$request->get('num'), $a->uid);

                    // 用户余额减少
                    EcologyCreadits::where('id', $id)->decrement('amount', $request->get('num'));

                    // 记录用户余额日志
                    EcologyCreaditsLog::addLog($a->uid, $request->get('num'), 2, 9, "后台操作", 1);

                }

                \DB::commit();

            } catch (\Exception $exception) {

                \DB::rollBack();

                \Log::info('用户改变积分余额失败', $request->all());

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
