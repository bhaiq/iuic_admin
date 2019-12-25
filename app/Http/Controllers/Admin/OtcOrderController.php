<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/8/3
 * Time: 10:09
 */

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\AccountLog;
use App\Models\OtcOrder;
use App\Models\OtcPublishBuy;
use App\Models\OtcPublishSell;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OtcOrderController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = OtcOrder::from('otc_order as o')
                ->select('o.*', 'u_s.new_account as sell_mobile', 'u_b.new_account as buy_mobile', 'c.name as coin_name', 'u_a.mobile as appeal_mobile', 'a_s.name as sell_name', 'a_b.name as buy_name')
                ->join('user as u_s', 'u_s.id', 'o.seller_id')
                ->join('user as u_b', 'u_b.id', 'o.buyer_id')
                ->join('coin as c', 'c.id', 'o.coin_id')
                ->leftJoin('user as u_a', 'u_a.id', 'o.appeal_uid')
                ->leftJoin('authentication as a_s', 'a_s.uid', 'o.seller_id')
                ->leftJoin('authentication as a_b', 'a_b.uid', 'o.buyer_id');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u_s.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('u_b.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('a_s.name', 'like', '%' . $soso . '%')
                        ->orwhere('a_b.name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest()->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.otc_order.index');

    }

    public function ajax(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required|in:1,2',
        ], [
            'id.required' => '订单信息不能为空',
            'type.required' => '操作类型不能为空',
            'type.in' => '操作类型不正确',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        $o = OtcOrder::find($request->get('id'));
        if(!$o){
            return returnJson(0, '订单信息有误');
        }

        if($o->status != 0){
            return returnJson(0, '订单状态有误');
        }

        // 当放币给买家的时候
        if($request->get('type') == 1){

            \DB::beginTransaction();
            try {

                // 订单状态改变
                $o->status = 1;
                $o->appeal_uid = 0;
                $o->is_pay_coin = 1;
                $o->save();

                // 买家用户余额增加
                Account::addAmount($o->buyer_id, $o->coin_id, $o->amount);

                // 买家余额日志增加
                AccountLog::addLog($o->buyer_id, $o->coin_id, $o->amount, 10, 1, 1, '法币买入');

                // 卖家冻结余额减少
                Account::reduceFrozen($o->seller_id, $o->coin_id, $o->amount);

                // 卖家余额日志增加
                AccountLog::addLog($o->seller_id, $o->coin_id, $o->amount, 9, 0, 1, '法币划出');

                \DB::commit();

            } catch (\Exception $exception) {

                \DB::rollBack();

                \Log::info('给买家放币的时候出现异常', $request->all());

                return returnJson(0, '操作异常');

            }

        }

        // 当放币给卖家的时候
        if($request->get('type') == 2){

            \DB::beginTransaction();
            try {

                // 订单状态改变
                $o->appeal_uid = 0;
                $o->status = 2;
                $o->save();

                // 判断订单是买单还是卖单
                if($o->type == 0){

                    $ops = OtcPublishSell::find($o->sell_id);
                    if($ops){
                        OtcPublishSell::where('id', $o->sell_id)->increment('amount_lost', $o->amount);
                    }

                    $ops->is_over = 0;
                    $ops->save();

                }else{

                    $ops = OtcPublishBuy::find($o->buy_id);
                    if($ops){
                        OtcPublishBuy::where('id', $o->buy_id)->increment('amount_lost', $o->amount);
                    }

                    $ops->is_over = 0;
                    $ops->save();

                }

                \DB::commit();

            } catch (\Exception $exception) {

                \DB::rollBack();

                \Log::info('给卖家放币的时候出现异常', $request->all());

                return returnJson(0, '操作异常');

            }

        }

        return returnJson(1, '操作成功');

    }

}