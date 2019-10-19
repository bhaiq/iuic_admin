<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/17
 * Time: 11:19
 */

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\AccountLog;
use App\Models\CoinExtract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CoinExtractController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = CoinExtract::from('coin_extract as ce')
                ->select('ce.*', 'u.mobile', 'c.name as coin_name', 'a.name as realname')
                ->join('user as u', 'u.id', 'ce.uid')
                ->join('coin as c', 'c.id', 'ce.coin_id')
                ->leftJoin('authentication as a', 'a.uid', 'ce.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('c.name', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%')
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

        return view('admin.coin_extract.index');

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

        $ce = CoinExtract::where('id', $request->get('id'))->where('status', 0)->first();
        if(!$ce){
            return returnJson(0, '数据有误');
        }

        \DB::beginTransaction();
        try {

            if($request->get('status') == 1){

                // 用户冻结余额减少
                Account::reduceFrozen($ce->uid, $ce->coin_id, $ce->coin_num, Account::TYPE_CC);

                // 增加用户余额变化日志
                AccountLog::addLog($ce->uid, $ce->coin_id, $ce->coin_num, 2, 0, Account::TYPE_CC, '提币');

                // 订单状态变化
                $ce->status = 1;
                $ce->save();

            }else{

                // 用户冻结余额减少
                Account::reduceFrozen($ce->uid, $ce->coin_id, $ce->coin_num, Account::TYPE_CC);

                // 用户普账户余额增加
                Account::addAmount($ce->uid, $ce->coin_id, $ce->coin_num, Account::TYPE_CC);

                // 订单状态变化
                $ce->status = 9;
                $ce->save();

            }

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            \Log::info('更新用户提现状态', $request->all());

            return returnJson(0, '操作异常');

        }

        return returnJson(1, '操作成功');

    }

}