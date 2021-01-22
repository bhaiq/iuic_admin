<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/16
 * Time: 14:03
 */

namespace App\Http\Controllers\Admin;

use App\Models\AccountLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletLogController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

//            $p = AccountLog::from('account_log as al')
//                ->select('al.*', 'u.new_account as mobile', 'c.name as coin_name', 'a.name as realname')
//                ->join('user as u', 'u.id', 'al.uid')
//                ->join('coin as c', 'c.id', 'al.coin_id')
//                ->leftJoin('authentication as a', 'a.uid', 'al.uid');
//
//            // 筛选条件
//            if ($soso) {
//                $p->where(function ($query) use ($soso) {
//                    $query->where('u.new_account', 'like', '%' . $soso . '%')
//                        ->orwhere('c.name', 'like', '%' . $soso . '%')
//                        ->orwhere('a.name', 'like', '%' . $soso . '%')
//                        ->orwhere('al.remark', 'like', '%' . $soso . '%');
//                });
//            }
//
//            $data['code'] = 0;
//            $data['msg'] = '查询成功';
//            $data['count'] = $p->count();
//
//            $p->latest('al.created_at')->skip(($page - 1) * $limit)->take($limit);
//            $data['data'] = $p->get()->toArray();
//
//            return response()->json($data);
            $p = AccountLog::with('user')
                ->with('coin')
                ->with('authentication')
                ->orderBy('created_at','desc')
//                   ->where('remark','like','%'.'分红'.'%')
                ->where(function($query) use($soso){
                    if(!empty($soso)){
                        $uid = User::where('new_account',$soso)->value('id');
                        $query->where('uid',$uid);
                    }
                })
                ->paginate($limit);
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

        return view('admin.wallet_log.index');
    }

}