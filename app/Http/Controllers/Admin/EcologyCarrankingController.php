<?php
//生态2公共配置
namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\EcologyConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class EcologyCarrankingController extends Controller
{

    //车奖排行榜
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = User::from('user as u')
                ->when($soso, function ($query) use ($soso) {
                    return $query->where('u.new_account', 'like', "%{$soso}%");
                })
                ->orderBy('u.ecology_lv','desc')
                ->orderBy('u.ecology_lv_time','asc')
                ->orderBy('u.car_is_show','desc');

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();
            $level = EcologyConfig::all()->toArray();
            $level = array_flip($level);
            foreach ($data['data'] as $k => $v){
                $data['data'][$k]['carranking'] = $k+(($page-1)*$limit)+1;
                $data['data'][$k]['level_name'] = array_keys(array_column($level,'name'),$v['ecology_lv']);
            }

            return response()->json($data);
        }
        return view('admin.ecology_carranking.index');
    }

    // 更新 车奖排行榜显示状态
    public function setStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'car_is_show' => 'required|in:0,1',
        ], [
            'id.required' => '用户信息不能为空',
            'car_is_show.required' => '操作类型不能为空',
            'car_is_show.in' => '操作类型不正确',
        ]);

        $user = User::find($request->get('id'));
        if(!$user){
            return returnJson(0, '用户数据有误');
        }

        $user->car_is_show = $request->get('car_is_show');
        $user->car_is_show_time = date('Y-m-d H:i:s');
        $user->save();
        AdminLog::addLog('更改id'.$user['id'].'用户车奖排行榜显示状态(0隐藏或1显示)-'.$request->get('car_is_show'));

        return returnJson(1, '操作成功');

    }

}