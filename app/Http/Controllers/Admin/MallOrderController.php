<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/10/10
 * Time: 15:06
 */

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\AccountLog;
use App\Models\Community;
use App\Models\MallIncome;
use App\Models\MallOrder;
use App\Models\ReleaseOrder;
use App\Models\UserBonus;
use App\Models\UserInfo;
use App\Models\UserPartner;
use App\Models\UserWalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MallOrderController extends Controller
{

    // 店铺列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = MallOrder::from('mall_order as mo')
                ->select('mo.*', 'u.mobile as u_mobile', 'a.name as realname', 'ms.name as store_name')
                ->join('user as u', 'u.id', 'mo.uid')
                ->join('mall_store as ms', 'ms.id', 'mo.store_id')
                ->leftJoin('authentication as a', 'a.uid', 'mo.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('ms.mobile', 'like', '%' . $soso . '%')
                        ->orwhere('mo.order_sn', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%')
                        ->orwhere('ms.name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();

            foreach ($data['data'] as $k => $v){

                $newAddress = '';
                $i = 0;

                $arr = explode(',', $v['to_address']);
                foreach ($arr as $val) {
                    if ($i > 0) {
                        $newAddress .= $val;
                    }
                    $i++;
                }

                $data['data'][$k]['address'] = $newAddress . $v['to_address_info'];

            }

            return response()->json($data);
        }

        return view('admin.mall_order.index');
    }

    // 订单编辑
    public function ajax(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:1',
        ], [
            'id.required' => '订单信息不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态数据不正确',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        $up = MallOrder::with(['store', 'user'])->where('id', $request->get('id'))->where('status', 2)->first();
        if(!$up || empty($up->store) || empty($up->user)){
            return returnJson(0, '数据有误');
        }

        $miData['order_id'] = $request->get('id');

        \DB::beginTransaction();
        try {

            $miData['store_id'] = $up->store_id;

            // 订单状态改变
            $up->js_status = 1;
            $up->save();

            // 计算订单能得到的usdt
            $totalNum = bcmul($up->goods_price, $up->num, 8);

            // 计算本次商家得到的USDT
            $sj_num = bcmul($totalNum, config('admin_mall.admin_mall_store_income_bl', 0.4), 8);
            $miData['sj_num'] = $sj_num;

            // 计算平台得到的USDT
            $pt_num = bcmul($totalNum, config('admin_mall.admin_mall_platform_income_bl', 0.6), 8);

            // 商家USDT增加
            Account::addAmount($up->store->uid, 1, $sj_num, Account::TYPE_LC);

            // 余额日志增加
            AccountLog::addLog($up->store->uid, 1, $sj_num, 19, 1, 1, '店铺收益');

            // 计算本次消费者推荐人得到的USDT
            $xfzNum = bcmul($pt_num, config('admin_mall.admin_mall_xfz_recommend_bl', 0.05), 8);
            $miData['pid_num'] = $xfzNum;

            if($up->user->pid > 0){

                // 消费者推荐人的账户增加
                Account::addAmount($up->user->pid, 1, $xfzNum, Account::TYPE_LC);

                // 余额日志增加
                AccountLog::addLog($up->user->pid, 1, $xfzNum, 19, 1, Account::TYPE_LC, '推荐收益');

            }

            // 计算本次合伙人的分红
            $hhrNum = bcmul($pt_num, config('admin_mall.admin_mall_hhr_bl', 0.1), 8);
            $miData['hhr_num'] = $hhrNum;

            // 合伙人数量
            $userCount = UserPartner::where('status', 1)->sum('count');

            // 计算单个合伙人应该得到的数量
            $oneHhrNum = bcdiv($hhrNum, $userCount, 8);
            $upRes = UserPartner::where('status', 1)->get();
            foreach ($upRes as $v){

                $newNum = bcmul($oneHhrNum, $v->count, 8);

                // 用户余额表更新
                Account::addAmount($v->uid, 1, $newNum, Account::TYPE_LC);

                // 用户余额日志表更新
                AccountLog::addLog($v->uid, 1, $newNum, 18, 1, Account::TYPE_LC, '合伙人分红');

            }

            // 计算本次管理员的分红
            $glyNum = bcmul($pt_num, config('admin_mall.admin_mall_admin_bl', 0.1), 8);
            $miData['gly_num'] = $glyNum;

            // 管理员数量
            $adminCount = UserBonus::where('type', '=', 2)->count();

            if($adminCount > 0){

                // 计算单个管理员应该得到的数量
                $oneGlyNum = bcdiv($glyNum, $adminCount, 8);

                $ubRes = UserBonus::where('type', '=', 2)->get();
                foreach ($ubRes as $v){

                    // 用户余额表更新
                    Account::addAmount($v->uid, 1, $oneGlyNum, Account::TYPE_LC);

                    // 用户余额日志表更新
                    AccountLog::addLog($v->uid, 1, $oneGlyNum, 18, 1, Account::TYPE_LC, '实时管理奖');

                }

            }

            // 计算本次收货社区的分红
            $sqNum = bcmul($pt_num, config('admin_mall.admin_mall_community_bl', 0.05), 8);
            $miData['sq_num'] = $sqNum;

            // 获取社区信息
            $comRes = Community::where('address', $up->to_address)->first();
            if($comRes){

                // 用户余额表更新
                Account::addAmount($comRes->uid, 1, $sqNum, Account::TYPE_LC);

                // 用户余额日志表更新
                AccountLog::addLog($comRes->uid, 1, $sqNum, 19, 1, Account::TYPE_LC, '社区分红');

            }

            // 计算订单能得到的矿池IUIC
            $totalKCNum = bcmul($up->ore_pool, $up->num, 8);
            $miData['sq_num'] = $sqNum;

            // 判断用户矿池是否存在
            $ui = UserInfo::where('uid', $up->uid)->first();
            if($ui){
                UserInfo::where('uid', $up->uid)->increment('buy_total', $totalKCNum);
            }else{

                $uiData = [
                    'uid' => $up->uid,
                    'pid' => $up->user->pid,
                    'pid_path' => $up->user->pid_path,
                    'level' => 0,
                    'buy_total' => $totalKCNum,
                    'buy_count' => 0,
                ];
                UserInfo::create($uiData);

            }

            // 用户报单表新增
            $reoData = [
                'uid' => $up->uid,
                'total_num' => $totalKCNum,
                'today_max' => bcmul(0.01, $totalKCNum, 2),
                'release_time' => now()->subDay()->toDateTimeString(),
                'created_at' => now()->toDateTimeString(),
            ];
            ReleaseOrder::create($reoData);

            // 增加用户矿池余额记录
            UserWalletLog::addLog($up->uid, 'mall_order', $up->id, '购买商品', '+', $totalKCNum, 2, 1);

            // 结算收益表新增
            MallIncome::create($miData);

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            \Log::info('结算收益出现异常', $request->all());

            return returnJson(0, '操作异常');

        }

        return returnJson(1, '操作成功');

    }

}