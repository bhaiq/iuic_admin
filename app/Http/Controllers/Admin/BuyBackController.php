<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\BuyBack;
use App\Models\Account;
use App\Models\AccountLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyBackController extends Controller
{
    //
    protected $fields = [
        'num' => '',
        // 'pledge_bl' => '',
    ];

    // 星级社群列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            // $p = StarCommunity::from('star_communities');
            $p = new BuyBack();

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();
            return response()->json($data);
        }

        return view('admin.buy_back.index');
    }

    // 新增公告
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.buy_back.create', $data);
    }

    // 添加回购记录
    public function store(Request $request)
    {
        \Log::info('数据',['num'=>$request]);
        $ver = new BuyBack();
        // foreach (array_keys($this->fields) as $field) {
        //     $ver->$field = $request->get($field);
        // }
        $ver->num = $request->get('num');
        $ver->uid = $request->get('uid');
        $ver->save();
        //减去uid的法币iuic
        Account::where('uid', $request->get('uid'))->where('coin_id',2)->where('type',1)->decrement('amount',$request->get('num'));
        // 记录用户余额日志(uid,coin_id,num,sence(情景),0减,1法币,描述)
        AccountLog::addLog($request->get('uid'),2,$request->get('num'), 200, 0, 1, '回购销毁');
        AdminLog::addLog('新增一条回购销毁记录');

        return redirect('/admin/buy_back/index');
    }

    // 修改星级社群
    public function edit($id)
    {
        $b = BuyBack::find((int)$id);
        if (!$b) return redirect('/admin/buy_back/index');

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
        return view('admin.buy_back.edit', $data);
    }

    // 更新星级社群
    public function update(Request $request, $id)
    {

        $b = BuyBack::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }
        // dd($b);
        $b->save();

        AdminLog::addLog('修改了ID为' . $id . '回购信息');

        return redirect('/admin/buy_back/index')->with('success', '修改成功');
    }
}
