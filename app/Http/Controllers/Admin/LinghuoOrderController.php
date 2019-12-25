<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/3
 * Time: 16:18
 */

namespace App\Http\Controllers\Admin;

use App\Models\UserWalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinghuoOrderController extends Controller
{

    // 灵活矿位列表
    public function index(Request $request)
    {

        $soso = $request->get('soso', '');

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $p = UserWalletLog::from('user_wallet_logs as uwl')
                ->select('uwl.*', 'u.mobile as mobile', 'u.new_account', 'a.name as realname')
                ->join('user as u', 'u.id', 'uwl.uid')
                ->leftJoin('authentication as a', 'a.uid', 'uwl.uid')
                ->where('exp', '购买灵活矿机');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('u.new_account', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('uwl.created_at')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.linghuo_order.index', ['soso' => $soso]);
    }

}