<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/10/18
 * Time: 14:55
 */

namespace App\Http\Controllers\Admin;

use App\Models\AccountLog;
use App\Models\ExTip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RewardDataController extends Controller
{

    // 首页
    public function index(Request $request)
    {

        $data = [];

        // 单日手续费
        $data['today_tip'] = ExTip::where('type', 0)->whereDate('created_at', now()->toDateString())->sum('num');

        // 累计交易手续费
        $data['total_tip'] = ExTip::where('type', 0)->sum('num');

        // 单日分红手续费
        $data['today_bonus_tip'] = ExTip::where('type', 0)->whereDate('created_at', now()->toDateString())->sum('bonus_num');

        // 累计分红手续费
        $data['total_bonus_tip'] = ExTip::where('type', 0)->sum('bonus_num');

        // 单日燃烧费
        $data['today_burn'] = bcsub($data['today_tip'], $data['today_bonus_tip'], 8);

        // 累计燃烧费
        $data['total_burn'] = bcsub($data['total_tip'], $data['total_bonus_tip'], 8);

        // 单日矿机手续费
        $data['today_kuangji_tip'] = ExTip::where('type', 1)->whereDate('created_at', now()->toDateString())->sum('bonus_num');

        // 累计矿机手续费
        $data['total_kuangji_tip'] = ExTip::where('type', 1)->sum('bonus_num');

        // 矿位单日购买
        $data['today_kuangwei_num'] = AccountLog::where(['coin_id' => 2, 'scene' => 20, 'remark' => '购买矿位'])->whereDate('created_at', now()->toDateString())->sum('amount');

        // 矿位累计购买
        $data['total_kuangwei_num'] = AccountLog::where(['coin_id' => 2, 'scene' => 20, 'remark' => '购买矿位'])->sum('amount');

        // 交易节点奖
        $data['today_trade_jd_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 14, 'remark' => '实时节点奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_trade_jd_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 14, 'remark' => '实时节点奖'])->sum('amount');
        $data['today_kuangji_jd_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 14, 'remark' => '实时节点奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_kuangji_jd_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 14, 'remark' => '实时节点奖'])->sum('amount');

        // 小节点奖
        $data['today_trade_xjd_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 14, 'remark' => '小节点奖分红'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_trade_xjd_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 14, 'remark' => '小节点奖分红'])->sum('amount');
        $data['today_kuangji_xjd_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 14, 'remark' => '小节点奖分红'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_kuangji_xjd_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 14, 'remark' => '小节点奖分红'])->sum('amount');

        // 大节点奖
        $data['today_trade_djd_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 14, 'remark' => '大节点奖分红'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_trade_djd_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 14, 'remark' => '大节点奖分红'])->sum('amount');
        $data['today_kuangji_djd_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 14, 'remark' => '大节点奖分红'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_kuangji_djd_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 14, 'remark' => '大节点奖分红'])->sum('amount');

        // 超级节点奖
        $data['today_trade_cjjd_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 14, 'remark' => '超级节点奖分红'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_trade_cjjd_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 14, 'remark' => '超级节点奖分红'])->sum('amount');
        $data['today_kuangji_cjjd_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 14, 'remark' => '超级节点奖分红'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_kuangji_cjjd_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 14, 'remark' => '超级节点奖分红'])->sum('amount');

        // 管理奖
        $data['today_trade_guanli_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 15])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_trade_guanli_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 15])->sum('amount');
        $data['totay_kuangji_guanli_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 15])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_kuangji_guanli_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 15])->sum('amount');

        // 后台奖
        $data['today_trade_houtai_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 18, 'remark' => '后台奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_trade_houtai_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 18, 'remark' => '后台奖'])->sum('amount');
        $data['totay_kuangji_houtai_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 18, 'remark' => '后台奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_kuangji_houtai_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 18, 'remark' => '后台奖'])->sum('amount');

        // 市场奖
        $data['today_trade_shichang_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 18, 'remark' => '市场奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_trade_shichang_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 18, 'remark' => '市场奖'])->sum('amount');
        $data['totay_kuangji_shichang_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 18, 'remark' => '市场奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_kuangji_shichang_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 18, 'remark' => '市场奖'])->sum('amount');

        // 团队奖
        $data['today_trade_tuandui_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 18, 'remark' => '团队奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_trade_tuandui_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 18, 'remark' => '团队奖'])->sum('amount');
        $data['totay_kuangji_tuandui_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 18, 'remark' => '团队奖'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_kuangji_tuandui_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 18, 'remark' => '团队奖'])->sum('amount');

        // 合伙人奖励
        $data['today_trade_hhr_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 18, 'remark' => '合伙人分红'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_trade_hhr_reward'] = AccountLog::where(['coin_id' => 1, 'scene' => 18, 'remark' => '合伙人分红'])->sum('amount');
        $data['totay_kuangji_hhr_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 18, 'remark' => '合伙人分红'])->whereDate('created_at', now()->toDateString())->sum('amount');
        $data['total_kuangji_hhr_reward'] = AccountLog::where(['coin_id' => 2, 'scene' => 18, 'remark' => '合伙人分红'])->sum('amount');

        // 交易手续费当日结余
        $data['today_trade_jy'] = $data['today_tip'] - $data['today_trade_jd_reward'] -  $data['today_trade_xjd_reward'];
        $data['today_trade_jy'] = $data['today_trade_jy'] - $data['today_trade_djd_reward'] - $data['today_trade_cjjd_reward'] - $data['today_trade_guanli_reward'];
        $data['today_trade_jy'] = $data['today_trade_jy'] - $data['today_trade_houtai_reward'] - $data['today_trade_shichang_reward'];
        $data['today_trade_jy'] = $data['today_trade_jy'] -  $data['today_trade_tuandui_reward'] - $data['today_trade_hhr_reward'];
        $data['today_trade_jy'] = bcmul($data['today_trade_jy'], 1, 8);

        // 交易手续费累计结余
        $data['total_trade_jy'] = $data['total_tip'] - $data['total_trade_jd_reward'] - $data['total_trade_xjd_reward'];
        $data['total_trade_jy'] = $data['total_trade_jy'] - $data['total_trade_djd_reward'] - $data['total_trade_cjjd_reward'];
        $data['total_trade_jy'] = $data['total_trade_jy'] - $data['total_trade_guanli_reward'] - $data['total_trade_houtai_reward'];
        $data['total_trade_jy'] = $data['total_trade_jy'] - $data['total_trade_shichang_reward'] - $data['total_trade_tuandui_reward'];
        $data['total_trade_jy'] = $data['total_trade_jy'] - $data['total_trade_hhr_reward'];
        $data['total_trade_jy'] = bcmul($data['total_trade_jy'], 1, 8);

        // 矿机手续费当日结余
        $data['today_kuangji_jy'] = $data['today_kuangji_tip'] - $data['today_kuangji_jd_reward'] - $data['today_kuangji_xjd_reward'];
        $data['today_kuangji_jy'] = $data['today_kuangji_jy'] - $data['today_kuangji_djd_reward'] - $data['today_kuangji_cjjd_reward'];
        $data['today_kuangji_jy'] = $data['today_kuangji_jy'] - $data['totay_kuangji_guanli_reward'] - $data['totay_kuangji_houtai_reward'];
        $data['today_kuangji_jy'] = $data['today_kuangji_jy'] - $data['totay_kuangji_shichang_reward'] - $data['totay_kuangji_tuandui_reward'];
        $data['today_kuangji_jy'] = $data['today_kuangji_jy'] - $data['totay_kuangji_hhr_reward'] ;
        $data['today_kuangji_jy'] = bcmul($data['today_kuangji_jy'], 1, 8);

        // 矿机手续费累计结余
        $data['total_kuangji_jy'] = $data['total_kuangji_tip'] - $data['total_kuangji_jd_reward'] - $data['total_kuangji_xjd_reward'];
        $data['total_kuangji_jy'] = $data['total_kuangji_jy'] - $data['total_kuangji_djd_reward'] - $data['total_kuangji_cjjd_reward'];
        $data['total_kuangji_jy'] = $data['total_kuangji_jy'] - $data['total_kuangji_guanli_reward'] - $data['total_kuangji_houtai_reward'];
        $data['total_kuangji_jy'] = $data['total_kuangji_jy'] - $data['total_kuangji_shichang_reward'] - $data['total_kuangji_tuandui_reward'];
        $data['total_kuangji_jy'] = $data['total_kuangji_jy'] - $data['total_kuangji_hhr_reward'];
        $data['total_kuangji_jy'] = bcmul($data['total_kuangji_jy'], 1, 8);

        return view('admin.reward_data.index', $data);

    }

}