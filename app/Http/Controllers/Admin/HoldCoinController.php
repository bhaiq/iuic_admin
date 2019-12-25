<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/31
 * Time: 10:51
 */

namespace App\Http\Controllers\Admin;

use App\Models\HoldCoin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HoldCoinController extends Controller
{

    // 持币统计列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = HoldCoin::select('price', \DB::raw('sum(amount) as total_num'))
                ->where('price', '>', 0)
                ->where('amount', '>', 0);

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('price', 'like', '%' . $soso . '%');
                });
            }

            $p->groupBy('price');

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->get()->count();

            if($limit != 9999){
                $p->skip(($page - 1) * $limit)->take($limit);
            }

            $data['data'] = $p->get()->toArray();

            // 获取流通总数
            $total = HoldCoin::sum('amount');

            foreach ($data['data'] as $k => $v){

                // 计算流通占比
                $data['data'][$k]['flow_bl'] = bcmul(bcdiv($v['total_num'], $total, 4), 100, 2);

                // 获取持币用户数
                $users = HoldCoin::where('price', $v['price'])->pluck('uid')->values()->toArray();

                $data['data'][$k]['user_count'] = count($users);

            }

            return response()->json($data);
        }

        return view('admin.hold_coin.index');
    }

    // 持币详细列表
    public function user(Request $request)
    {

        $soso = $request->get('soso', '');

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $field = $request->get('field', 'created_at');
            $sort = $request->get('sort', 'asc') ?? 'asc';

            $p = HoldCoin::from('hold_coin as hc')
                ->select('hc.*', 'u.mobile', 'u.new_account', 'a.name')
                ->join('user as u', 'u.id', 'hc.uid')
                ->leftJoin('authentication as a', 'a.uid', 'hc.uid')
                ->where('hc.price', '>', 0)
                ->where('hc.amount', '>', 0);

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('hc.price', 'like', '%' . $soso . '%')
                        ->orwhere('u.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('a.name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->orderBy($field, $sort)->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.hold_coin.user', ['soso' => $soso]);

    }

}