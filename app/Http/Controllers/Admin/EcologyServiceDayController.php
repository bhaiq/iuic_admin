<?php

namespace App\Http\Controllers\Admin;

use App\Models\EcologyServiceDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EcologyServiceDayController extends Controller
{
    //
    protected $fields = [
        'day_time' => '',
        'total_cny' => '',
        'total_point' => '',
        'total_cny_actual' => '',
        'set_status' => 0,
        'set_time' => '',
    ];

    //日全网新增手续费列表
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $p = EcologyServiceDay::from('ecology_service_day');

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->orderBy('id','desc');

            if($limit != 9999){
                $p->skip(($page - 1) * $limit)->take($limit);
            }

            $data['data'] = $p->get()->toArray();
            foreach ($data['data'] as $k => $v){
                $data['data'][$k]['set_status_value'] = $v['set_status']['value'];
                $data['data'][$k]['set_status_msg'] = $v['set_status']['msg'];

            }

            return response()->json($data);
        }
        return view('admin.ecology_service_day.index');
    }


}
