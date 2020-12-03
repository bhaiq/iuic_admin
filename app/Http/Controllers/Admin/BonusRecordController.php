<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BonusRecordController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = AccountLog::from('account_log as al')
                ->select('al.uid','al.coin_id','al.remark', 'al.amount','al.created_at',
                    'u.new_account as mobile', 'c.name as coin_name', 'a.name as realname')
                ->leftjoin('user as u', 'u.id', 'al.uid')
                ->leftjoin('coin as c', 'c.id', 'al.coin_id')
                ->leftJoin('authentication as a', 'a.uid', 'al.uid')
                ->where('al.remark','like','%'.'分红'.'%');

            // 筛选条件
            if ($soso) {
                $p->where(function ($query) use ($soso) {
                    $query->where('u.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('c.name', 'like', '%' . $soso . '%')
                        ->orwhere('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('al.remark', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('al.created_at')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.bonus_record.index');
    }
}
