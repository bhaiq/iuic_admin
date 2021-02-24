<?php
//积分划转
namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
// use App\Models\User;
use App\Models\EcologyCreaditTransfer;

class EcologyCreaditTransferController extends Controller
{

    //积分划转列表
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $sou_uid = $request->get('sou_uid');
            $sou_created = $request->get('sou_created');

            $p = EcologyCreaditTransfer::from('ecology_creadit_transfer as e')
                ->leftJoin('user as u', 'u.id', 'e.uid')
                ->leftJoin('authentication as a', 'a.uid', 'e.uid')
                ->select('e.*','u.new_account','u.mobile','a.name as realname')
                ->when($sou_uid, function ($query) use ($sou_uid) {
                    return $query->where('e.uid',$sou_uid);
                })
                ->when($sou_created, function ($query) use ($sou_created) {
                    $mintime = substr($sou_created, 0, 10) . ' 00:00:00';
                    $maxtime = substr($sou_created, 13, 10) . ' 23:59:59';
                    return $query->whereBetween('e.created_at', [$mintime,$maxtime]);
                });

                // ->when($soso, function ($query) use ($soso) {
                //     return $query->where('u.new_account', 'like', "%{$soso}%");
                // });

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->orderBy('e.id','desc');

            if($limit != 9999){
                $p->skip(($page - 1) * $limit)->take($limit);
            }

            $data['data'] = $p->get()->toArray();
            foreach ($data['data'] as $k => $v){
                $data['data'][$k]['charge_rate_msg'] = ($v['charge_rate']*100).'%';

            }


            return response()->json($data);
        }
        return view('admin.ecology_creadit_transfer.index');
    }

}