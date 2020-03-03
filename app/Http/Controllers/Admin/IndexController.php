<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\AccountLog;
use App\Models\Coin;
use App\Models\CoinExtract;
use App\Models\ExOrder;
use App\Models\ExTip;
use App\Models\KuangjiLinghuo;
use App\Models\ReleaseOrder;
use App\Models\ShopOrder;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserWallet;
use App\Models\UserWalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    // 首页
    public function index(Request $request)
    {

        $data = [];

        // 单日交易挖矿释放
        $data['today_trade_release'] = UserWalletLog::where('exp', '交易释放')->whereDate('created_at', now()->toDateString())->sum('num');

        // 累计交易挖矿释放
        $data['total_trade_release'] = UserWalletLog::where('exp', '交易释放')->sum('num');

        // 单日算力挖矿释放
        $data['today_kuangji_release'] = UserWalletLog::where(function ($q){
            $q->where('exp', '矿机释放')->orwhere('exp', '灵活矿机释放');
        })->whereDate('created_at', now()->toDateString())->sum('num');

        // 累计算力挖矿释放
        $data['total_kuangji_release'] = UserWalletLog::where('exp', '矿机释放')->orwhere('exp', '灵活矿机释放')->sum('num');

        // 当日释放
//        $data['today_release'] = bcadd($data['today_trade_release'], $data['today_kuangji_release'], 8);
//        dd($data, now()->toDateTimeString(), UserWalletLog::where('exp', '矿机释放')->whereDate('created_at', now()->toDateString())->toSql());
        // 累计释放
//        $data['total_release'] = bcadd($data['total_trade_release'], $data['total_kuangji_release'], 8);

        // 注册用户
        $data['zc_user'] = User::count();

        // 高级用户
        $data['gj_user'] = UserInfo::where('level', 2)->count();

        // 普通用户
        $data['pt_user'] = UserInfo::where('level', 1)->count();

        // 矿池总数
        $data['total_ore_pool'] = UserInfo::sum('buy_total');

        // 购买赠送矿池数
        $data['buy_ore_pool'] = ReleaseOrder::where('type', 0)->sum('total_num');

        // 推荐赠送矿池数
        $data['recommend_ore_pool'] = bcsub($data['total_ore_pool'], $data['buy_ore_pool']);

        // 单日USDT提现手续费
        $data['today_tixian_tip'] = CoinExtract::where(['status' => 1, 'coin_id' => 1])->whereDate('created_at', now()->toDateString())->sum('charge');

        // 累计USDT提现手续费
        $data['total_tixian_tip'] = CoinExtract::where(['status' => 1, 'coin_id' => 1])->sum('charge');

        // 用户USDT钱包
        $data['usdt_bb_num'] = Account::where('type', 0)->where('coin_id', 1)->sum(\DB::raw('amount + amount_freeze'));
        $data['usdt_fb_num'] = Account::where('type', 1)->where('coin_id', 1)->sum(\DB::raw('amount + amount_freeze'));

        // 用户卖盘USDT数量
        $data['usdt_sell_num'] = ExOrder::where(['status' => 0, 'type' => 0])->sum('amount_deal');

        // 用户买盘IUIC数量
        $data['usdt_buy_num'] = ExOrder::where(['status' => 0, 'type' => 1])->sum('amount_deal');

        // 用户IUIC钱包
        $data['iuic_bb_num'] = Account::where('type', 0)->where('coin_id', 2)->sum(\DB::raw('amount + amount_freeze'));
        $data['iuic_fb_num'] = Account::where('type', 1)->where('coin_id', 2)->sum(\DB::raw('amount + amount_freeze'));

        // 用户卖盘IUIC数量
        $data['iuic_sell_num'] = ExOrder::where(['status' => 0, 'type' => 0])->sum(\DB::raw('(amount - amount_lost)'));

        // 用户买盘IUIC数量
        $data['iuic_buy_num'] = ExOrder::where(['status' => 0, 'type' => 1])->sum(\DB::raw('(amount - amount_lost)'));

        // 获取灵活矿机总数
        $data['linghuo_total_num'] = KuangjiLinghuo::sum('num');

        // 获取能量矿池总数
        $data['energy_frozen_total_num'] = UserWallet::sum('energy_frozen_num');

        return view('admin.index', $data);

    }

    // 获取当日结余
    private function getTodayJieyu($data){
        return bcmul($data['today_bonus_tip'] - $data['jiedian_today'] - $data['guanli_today'] - $data['tuandui_today'] - $data['houtai_today'] - $data['shichang_today'] - $data['partner_today'], 1, 8);
    }

    // 获取累计结余
    private function getTotalJieyu($data){

        $total = ExTip::sum('bonus_num');
        return bcmul($total - $data['jiedian_total'] - $data['guanli_total'] - $data['tuandui_total'] - $data['houtai_total'] - $data['shichang_total'] - $data['partner_total'], 1, 8);
    }

    // 获取当日释放、管理奖和节点奖
    private function getReleaseBonus()
    {

        $result = [
            'jiedian_today' => AccountLog::where('scene', 14)->whereDate('created_at', now()->toDateString())->sum('amount'),
            'jiedian_total' => AccountLog::where('scene', 14)->sum('amount'),
            'guanli_today' => AccountLog::where('scene', 15)->whereDate('created_at', now()->toDateString())->sum('amount'),
            'guanli_total' => AccountLog::where('scene', 15)->sum('amount'),
        ];

        return $result;

    }

    // 获取额外的奖励
    private function getExtraBonus()
    {

        $result['tuandui_today'] = AccountLog::where(['scene' => 18, 'remark' => '团队奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $result['houtai_today'] = AccountLog::where(['scene' => 18, 'remark' => '后台奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $result['shichang_today'] = AccountLog::where(['scene' => 18, 'remark' => '市场奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $result['partner_today'] = AccountLog::where(['scene' => 18, 'remark' => '合伙人分红'])->whereDate('created_at', now()->toDateString())->sum('amount');

        $result['tuandui_total'] = AccountLog::where(['scene' => 18, 'remark' => '团队奖'])->sum('amount');
        $result['houtai_total'] = AccountLog::where(['scene' => 18, 'remark' => '后台奖'])->sum('amount');
        $result['shichang_total'] = AccountLog::where(['scene' => 18, 'remark' => '市场奖'])->sum('amount');
        $result['partner_total'] = AccountLog::where(['scene' => 18, 'remark' => '合伙人分红'])->sum('amount');

        return $result;

    }

}
