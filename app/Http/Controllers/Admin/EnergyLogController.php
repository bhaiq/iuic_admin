<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/31
 * Time: 11:14
 */

namespace App\Http\Controllers\Admin;

use App\Models\EnergyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnergyLogController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = EnergyLog::from('energy_logs as el')
                ->select('el.*', 'u.new_account as mobile', 'a.name as realname', 'uu.new_account as uu_mobile', 'uuaa.name as uu_realname')
                ->join('user as u', 'u.id', 'el.uid')
                ->leftJoin('authentication as a', 'a.uid', 'el.uid')
                ->leftJoin('user as uu', 'uu.id', 'el.dy_uid')
                ->leftJoin('authentication as uuaa', 'uu.id', 'el.dy_uid');

            // 筛选条件
            if ($soso) {
                $p->where(function ($query) use ($soso) {
                    $query->where('u.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('el.exp', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('el.created_at')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.energy_log.index');
    }

}