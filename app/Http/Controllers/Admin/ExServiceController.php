<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExTip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExServiceController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('admin.ex_service.index');
    }

    public function ajax(Request $request)
    {


        $soso = $request->get('soso', 0);
        $createdAt = $request->get('time', '');

//
        $data = [
            'self_num' => 0,
            'team_num' => 0,
            'total_num' => 0,
        ];

        if ($createdAt) {

            $time1 = substr($createdAt, 0, 10) . ' 00:00:00';
            $time2 = substr($createdAt, 13, 10) . ' 23:59:59';

            $selfNum = ExTip::where('created_at', '>=', $time1)->where('created_at', '<=', $time2)->sum('num');

            // 获取手下的用户信息
//            $lowerUids = User::where('pid_path', 'like', '%,' . $user->id . ',%')->pluck('id')->toArray();

            // 获取手下的业绩信息
//            $teamNum = SplitLog::whereIn('uid', $lowerUids)->where('created_at', '>=', $time1)->where('created_at', '<=', $time2)->sum('num');

            $data['self_num'] = bcmul($selfNum, 1, 4);
//            $data['team_num'] = bcmul($teamNum, 1, 4);
//            $data['total_num'] = bcadd($data['self_num'], $data['team_num'], 4);

        }else{

            $data['self_num'] = 0;
//            $data['team_num'] = bcmul(User::getTeamAchievement($user->id), 1, 4);
//            $data['total_num'] = bcadd($data['self_num'], $data['team_num'], 4);

        }


        return returnJson(1, '查询成功', $data);

    }
}
