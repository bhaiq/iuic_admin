<?php

namespace App\Http\Controllers\Admin;

use App\Models\SpeedBounus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpeedBonusController extends Controller
{
    //
    protected $fields = [
        'uid' => "",
        'count' => '',
        'num' => '',
        'coin_id'=>'',
        'status'=>'',
    ];

    // 合伙人列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', '');

            $p = SpeedBounus::from('user_speed_bonus as up')
                ->select('up.*', 'u.mobile', 'u.new_account', 'u.nickname', 'a.name as realname')
                ->join('user as u', 'u.id', 'up.uid')
                ->leftJoin('authentication as a', 'a.uid', 'up.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.nickname', 'like', '%' . $soso . '%')
                        ->orwhere('u.new_account', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('up.id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }
        return view('admin.speed_bonus.index');

    }
}
