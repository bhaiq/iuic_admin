<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/16
 * Time: 14:03
 */

namespace App\Http\Controllers\Admin;

use App\Models\AccountLog;
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

            $p = AccountLog::from('account_log as al')
                ->select('al.*', 'u.mobile', 'c.name as coin_name', 'a.name as realname')
                ->join('user as u', 'u.id', 'al.uid')
                ->join('coin as c', 'c.id', 'al.coin_id')
                ->leftJoin('authentication as a', 'a.uid', 'al.uid');

            // 筛选条件
            if ($soso) {
                $p->where(function ($query) use ($soso) {
                    $query->where('u.mobile', 'like', '%' . $soso . '%')
                        ->orwhere('c.name', 'like', '%' . $soso . '%')
                        ->orwhere('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('al.remark', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('al.created_at')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.wallet_log.index');
    }

}