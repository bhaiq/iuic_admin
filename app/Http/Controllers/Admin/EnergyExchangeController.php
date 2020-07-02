<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/20
 * Time: 10:37
 */

namespace App\Http\Controllers\Admin;

use App\Models\EnergyExchange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnergyExchangeController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = EnergyExchange::from('energy_exchange as ee')
                ->select('ee.*', 'u.mobile', 'a.name as realname', 'c.name as coin_name')
                ->join('user as u', 'u.id', 'ee.uid')
                ->leftJoin('authentication as a', 'a.uid', 'ee.uid')
                ->leftJoin('coin as c', 'c.id', 'ee.coin_id');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%')
                        ->orwhere('c.name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.energy_exchange.index');

    }

}