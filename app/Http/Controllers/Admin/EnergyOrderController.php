<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/19
 * Time: 17:56
 */

namespace App\Http\Controllers\Admin;

use App\Models\EnergyOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnergyOrderController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = EnergyOrder::from('energy_order as eo')
                ->select('eo.*', 'u.mobile')
                ->join('user as u', 'u.id', 'eo.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('goods_name', 'like', '%' . $soso . '%')
                        ->orwhere('to_name', 'like', '%' . $soso . '%')
                        ->orwhere('to_mobile', 'like', '%' . $soso . '%')
                        ->orwhere('to_address', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.energy_order.index');

    }

}