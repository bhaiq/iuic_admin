<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountLog;
use App\Models\User;
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
            $remarks = $request->get('remark', 0);


//            $p = AccountLog::from('account_log as al')
//                ->select('al.uid','al.coin_id','al.remark', 'al.amount','al.created_at',
//                    'u.new_account as mobile', 'c.name as coin_name')
//                ->join('user as u', 'u.id', 'al.uid')
//                ->join('coin as c', 'c.id', 'al.coin_id')
////                ->leftJoin('authentication as a', 'a.uid', 'al.uid')
////                ->where('al.remark','like','%'.'分红'.'%');
//            $p = AccountLog::with('user')
//                ->with('coin')
//                ->with('authentication')
//                ->orderBy('created_at','desc')
//                ->where('remark','like','%'.'分红'.'%')
//                ->paginate($limit);
               $p = AccountLog::with('user')
                   ->with('coin')
                   ->with('authentication')
                   ->orderBy('created_at','desc')
//                   ->where('remark','like','%'.'分红'.'%')
                   ->where(function($query) use ($remarks){
                        if(!empty($remarks)){
                            $query->where('remark','like','%'.'IUIC社群月度分红奖'.'%');
                        }else{
                            $query->where('remark','like','%'.'分红'.'%');
                        }
                   })
                   ->where(function($query) use($soso){
                       if(!empty($soso)){
                           $uid = User::where('new_account',$soso)->value('id');
                           $query->where('uid',$uid);
                       }
                   })
                   ->paginate($limit);

            $data = [];
//            dd($p);

            // 筛选条件
//            if ($soso) {
//                $p->where(function ($query) use ($soso) {
//                    $query->where('u.new_account', 'like', '%' . $soso . '%')
//                        ->orwhere('c.name', 'like', '%' . $soso . '%')
//                        ->orwhere('a.name', 'like', '%' . $soso . '%')
//                        ->orwhere('al.remark', 'like', '%' . $soso . '%');
//                });
//            }
//            dd($p);
            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->lastPage()*$limit;
            $data['data'] = [];
//            $p->latest('al.created_at')->skip(($page - 1) * $limit)->take($limit);
//            $p->latest('al.created_at')->paginate($limit);
            foreach ($p as $k => $v){
                $data['data'][$k]['new_account'] = $v->user->new_account;
                if(empty($v->authentication->name)){
                    $data['data'][$k]['realname'] = "未实名";
                }else{
                    $data['data'][$k]['realname'] = $v->authentication->name;
                }
                $data['data'][$k]['coin_name'] = $v->coin->name;
                $data['data'][$k]['amount'] = $v->amount;
                $data['data'][$k]['type'] = $v->type;
                $data['data'][$k]['remark'] = $v->remark;
                $data['data'][$k]['created_at'] = $v->created_at->format('Y-m-d h:i:s');
            }



            return response()->json($data);
        }

        return view('admin.bonus_record.index');
    }
}
