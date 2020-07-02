<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2020/3/10
 * Time: 11:12
 */

namespace App\Http\Controllers\Admin;

use App\Models\ExOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RobotOrderController extends Controller
{

    // 机器人订单
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = ExOrder::from('ex_order as eo')
                ->select('eo.*', 'u.mobile', 'u.new_account', 'et.name as et_name', 'a.name as realname')
                ->join('user as u', 'u.id', 'eo.uid')
                ->join('ex_team as et', 'et.id', 'eo.team_id')
                ->leftJoin('authentication as a', 'a.uid', 'eo.uid')
                ->where('eo.uid', 4158);

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('a.name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest()->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.robot_order.index');

    }

}