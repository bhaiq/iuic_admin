<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/10/17
 * Time: 14:09
 */

namespace App\Http\Controllers\Admin;

use App\Models\KuangjiOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KuangjiOrderController extends Controller
{

    // 矿机订单列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = KuangjiOrder::from('kuangji_order as ko')
                ->select('ko.*', 'u.mobile as u_mobile', 'u.new_account', 'a.name as realname', 'k.name as kj_name')
                ->join('user as u', 'u.id', 'ko.uid')
                ->join('kuangji as k', 'k.id', 'ko.kuangji_id')
                ->leftJoin('authentication as a', 'a.uid', 'ko.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('u.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('k.name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('ko.id')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.kuangji_order.index');
    }

}