<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TranfController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);
            $p = AccountLog::with('user')
                ->with('coin')
                ->with('authentication')
                ->orderBy('created_at','desc')
                ->whereIn('scence',['35','36'])
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
            foreach ($p as $k => $v){
                $data['data'][$k]['new_account'] = $v->user->mobile;
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

        return view('admin.tranf_log.index');
    }

}
