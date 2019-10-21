<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/10/21
 * Time: 10:33
 */

namespace App\Http\Controllers\Admin;

use App\Models\UserBonus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RewardListController extends Controller
{

    // 分红列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = UserBonus::from('user_bonus as ub')
                ->select('ub.*', 'u.mobile as u_mobile', 'a.name as realname')
                ->join('user as u', 'u.id', 'ub.uid')
                ->leftJoin('authentication as a', 'a.uid', 'ub.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.reward_list.index');
    }

}