<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2020/3/18
 * Time: 16:22
 */

namespace App\Http\Controllers\Admin;

use App\Models\EnergyLockTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnergyLockTransferController extends Controller
{

    // 锁仓能量转账订单
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = EnergyLockTransfer::from('energy_lock_transfer as elt')
                ->select('elt.*', 'u.new_account', 'u.nickname', 'uu.nickname as uu_nickname')
                ->join('user as u', 'u.id', 'elt.uid')
                ->join('user as uu', 'uu.id', 'elt.to_uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('u.nickname', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest()->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.energy_lock_transfer.index');

    }

}