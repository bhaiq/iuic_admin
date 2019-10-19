<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\AccountLog;
use App\Models\Coin;
use App\Models\CoinExtract;
use App\Models\ExOrder;
use App\Models\ExTip;
use App\Models\ReleaseOrder;
use App\Models\ShopOrder;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    // 首页
    public function index(Request $request)
    {

        $data = [];

        // 注册用户
        $data['zc_user'] = User::count();

        // 高级用户
        $data['gj_user'] = UserInfo::where('level', 2)->count();

        // 普通用户
        $data['pt_user'] = UserInfo::where('level', 1)->count();

        // 矿池总数
        $data['total_ore_pool'] = UserInfo::sum('buy_total');

        // 购买赠送矿池数
        $data['buy_ore_pool'] = ShopOrder::sum('ore_pool');

        // 推荐赠送矿池数
        $data['recommend_ore_pool'] = bcsub($data['total_ore_pool'], $data['buy_ore_pool']);

        // 单日释放
        $data['dr_release'] = ReleaseOrder::whereDate('release_time', now()->toDateString())->sum('today_num');

        // 累计释放
        $data['lj_release'] = ReleaseOrder::sum('release_num');

        // 单日手续费
        $data['today_tip'] = ExTip::whereDate('created_at', now()->toDateString())->sum('num');

        // 单日分红手续费
        $data['today_bonus_tip'] = ExTip::whereDate('created_at', now()->toDateString())->sum('bonus_num');

        // 单日燃烧费
        $data['today_burn'] = bcsub($data['today_tip'], $data['today_bonus_tip'], 8);

        // 累计交易手续费
        $data['total_tip'] = ExTip::sum('num');

        // 累计分红手续费
        $data['total_bonus_tip'] = ExTip::sum('bonus_num');

        // 累计燃烧费
        $data['total_burn'] = bcsub($data['total_tip'], $data['total_bonus_tip'], 8);

        // 获取当日释放、管理奖和节点奖
        $data = array_merge($data, $this->getReleaseBonus());

        // 获取额外奖励
        $data = array_merge($data, $this->getExtraBonus());

        // 当日结余
        $data['jieyu_today'] = $this->getTodayJieyu($data);

        // 累计结余
        $data['jieyu_total'] = $this->getTotalJieyu($data);

        // USDT当日提现手续费累计
        $data['today_tb_tip'] = 0;

        // USDT提现手续费累计
        $data['total_tb_tip'] = 0;

        // 获取USDT的币种ID
        $coin = Coin::where('name', 'USDT')->first();
        if($coin){
            $data['today_tb_tip'] = CoinExtract::where(['status' => 1, 'coin_id' => $coin->id])->whereDate('created_at', now()->toDateString())->sum('charge');
            $data['total_tb_tip'] = CoinExtract::where('status', 1)->sum('charge');
        }

        // 用户可用USDT总量
        $data['user_usdt_num'] = Account::where('coin_id', $coin->id)->sum('amount');

        // 用户冻结USDT总量
        $data['user_frozen_usdt_num'] = Account::where('coin_id', $coin->id)->sum('amount_freeze');
        $data['user_frozen_usdt_num'] = $data['user_frozen_usdt_num'] > 0 ? $data['user_frozen_usdt_num'] : 0;

        // 用户IUIC钱包
        $data['iuic_bb_num'] = Account::where('type', 0)->where('coin_id', 2)->sum(\DB::raw('amount + amount_freeze'));
        $data['iuic_fb_num'] = Account::where('type', 1)->where('coin_id', 2)->sum(\DB::raw('amount + amount_freeze'));

        // 用户卖盘数量
        $data['iuic_sell_num'] = ExOrder::where(['status' => 0, 'type' => 0])->sum(\DB::raw('(amount - amount_lost)'));

        // 用户买盘数量
        $data['iuic_buy_num'] = ExOrder::where(['status' => 0, 'type' => 1])->sum(\DB::raw('(amount - amount_lost)'));

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
