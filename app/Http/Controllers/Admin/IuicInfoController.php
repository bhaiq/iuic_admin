<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\AdminLog;
use App\Models\BuyBack;
use App\Models\ExTip;
use App\Models\IuicInfo;
use App\Models\UserInfo;
use App\Models\UserWalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IuicInfoController extends Controller
{
    //
    protected $fields = [
        'exp' => '',
        'is_close' => '',
        'value' => '',
        // 'pledge_bl' => '',
    ];

    // 星级社群列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            // $p = StarCommunity::from('star_communities');
            $p = new IuicInfo();

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();
            //IUIC总量
            $data['data'][0]['true_value'] = number_format("210000000");
            //IUIC剩余总量(2.1亿 - IUIC剩余矿池 - 流通IUIC)
            $iuic_kuagchi = UserInfo::sum(\DB::raw('(buy_total - release_total)'));
            $iuic_liutong = Account::where('coin_id',2)->sum(\DB::raw('(amount + amount_freeze)'));
            $shengy = 210000000 - $iuic_kuagchi - $iuic_liutong;
            $data['data'][1]['true_value'] = number_format($shengy,4);
            //流通IUIC数量
            $data['data'][2]['true_value'] = number_format($iuic_liutong,4);
            //IUIC矿池数量
            $data['data'][3]['true_value'] = number_format($iuic_kuagchi,4);
            //IUIC矿池每天产出数量
            $today_release = UserWalletLog::where(function ($q){
                $q->where('exp', '交易释放')->orwhere('exp', '灵活矿机释放')->orwhere('exp', '矿池静态释放');
            })->whereDate('created_at', now()->toDateString())->sum('num');
            $data['data'][4]['true_value'] = number_format($today_release,4);
            //交易买卖手续费累计手续费
            $all_service = ExTip::where('type',0)->sum('num');
            $data['data'][5]['true_value'] = number_format($all_service,4);
            //交易买卖手续费分红总数
            $fenhong_service = ExTip::where('type',0)->sum('bonus_num');
            $data['data'][6]['true_value'] = number_format($fenhong_service,4);
            //交易买卖手续费回购销毁IUIC总数
            $all_back = BuyBack::where('id','>',0)->sum('num');
            $data['data'][7]['true_value'] = number_format($all_back,4);
            return response()->json($data);
        }

        return view('admin.iuic_info.index');
    }

    // 修改星级社群
    public function edit($id)
    {
        $b = IuicInfo::find((int)$id);
        if (!$b) return redirect('/admin/iuic_info/index');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $b->$field);
        }

        $data['id'] = (int)$id;
        $data['exp'] = $b['exp'];
        $data['is_close'] = $b['is_close'];
        $data['value'] = $b['value'];
        // $data['id'] = (int)$id;
        $data['is_closed'] = [
            '关闭', '开启'
        ];
        return view('admin.iuic_info.edit', $data);
    }

    // 更新星级社群
    public function update(Request $request, $id)
    {

        $b = IuicInfo::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }
        // dd($b);
        $b->save();

        AdminLog::addLog('修改了ID为' . $id . 'IUIC矿池信息');

        return redirect('/admin/iuic_info/index')->with('success', '修改成功');
    }


}
