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
            $start = ($page - 1) * $limit;
//            $p = AccountLog::from('account_log as al')
//                ->select('al.*', 'u.new_account as mobile', 'c.name as coin_name', 'a.name as realname')
//                ->join('user as u', 'u.id', 'al.uid')
//                ->join('coin as c', 'c.id', 'al.coin_id')
//                ->leftJoin('authentication as a', 'a.uid', 'al.uid')
//                ->where('al.remark','like','%'.'分红'.'%');
//            $p = AccountLog::with('user')
//                ->with('coin')
//                ->where('remark','like','%'.'分红'.'%');

            $sql = "select al.*,u.new_account as mobile, c.name as coin_name, a.name as realname 
                    from account_log as al 
                    left join user as u on u.id = al.uid
                    left join coin as c on c.id = al.coin_id
                    left join authentication as a on a.uid = al.uid
                    where al.remark like '分红'%";

            $countSql = "select 1 
                    from account_log as al 
                    left join user as u on u.id = al.uid
                    left join coin as c on c.id = al.coin_id
                    left join authentication as a on a.uid = al.uid
                    where al.remark like '分红'%";

            // 筛选条件
            if ($soso) {
//                $p->where(function ($query) use ($soso) {
//                    $query->where('u.new_account', 'like', '%' . $soso . '%')
//                        ->orwhere('c.name', 'like', '%' . $soso . '%')
//                        ->orwhere('a.name', 'like', '%' . $soso . '%');
//                });
                $sql .= " and (u.new_account like  $soso% or c.name like $soso% or a.name like $soso%) and al.id >  $start";
                $countSql .= " and (u.new_account like  $soso% or c.name like $soso% or a.name like $soso%)";
            }
//            dd($p);
            $data['code'] = 0;
            $data['msg'] = '查询成功';
//            $data['count'] = $p->count();
            $data['count'] = DB::query($countSql);

            $sql .= " order by al.created_at desc limit $limit";
//            $p->orderBy('created_at','desc')->skip(($page - 1) * $limit);
//            $p->orderBy('created_at','desc')->paginate($limit);
            $data['data'] = DB::query($sql);

            return response()->json($data);
        }

        return view('admin.bonus_record.index');
    }
}
