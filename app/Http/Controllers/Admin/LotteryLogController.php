<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/13
 * Time: 16:08
 */

namespace App\Http\Controllers\Admin;

use App\Models\LotteryLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LotteryLogController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = LotteryLog::from('lottery_log as ll')
                ->select('ll.*', 'u.new_account as mobile', 'a.name as realname', 'lg.name as goods_name')
                ->join('user as u', 'u.id', 'll.uid')
                ->join('lottery_goods as lg', 'lg.id', 'll.goods_id')
                ->leftJoin('authentication as a', 'a.uid', 'll.uid');

            // 筛选条件
            if ($soso) {
                $p->where(function ($query) use ($soso) {
                    $query->where('u.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('lg.name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('ll.created_at')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.lottery_log.index');
    }

}