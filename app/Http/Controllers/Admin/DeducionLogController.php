<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\BuyBack;
use App\Models\DeducionLog;
use App\Models\Account;
use App\Models\AccountLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeducionLogController extends Controller
{
    //
    protected $fields = [
        'num' => '',
        // 'pledge_bl' => '',
    ];

    //交易手续费抵扣记录
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            // $p = StarCommunity::from('star_communities');
            $p = new DeducionLog();

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();
            return response()->json($data);
        }

        return view('admin.deducion_logs.index');
    }

    //添加交易手续费抵扣记录
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.deducion_logs.create', $data);
    }

    // 添加交易手续费记录
    public function store(Request $request)
    {
        \Log::info('数据',['num'=>$request]);
        $ver = new DeducionLog();
        $ver->num = $request->get('num');
        $ver->save();
        AdminLog::addLog('添加交易手续费记录');

        return redirect('/admin/deducion_logs/index');
    }

   
}
