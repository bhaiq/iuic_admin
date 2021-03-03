<?php
//日全网新增业绩
namespace App\Http\Controllers\Admin;

use URL;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\EcologyCreaditsDay;
use App\Models\EcologyCreaditsDayFushu;

use App\Services\EcologySettlement;
// use App\Jobs\EcologySettlementQueue;

class EcologyCreaditsDayController extends Controller
{


    protected $fields = [
        'day_time' => '',
        'total_cny' => '',
        'total_point' => '',
        'total_cny_actual' => '',
        'set_status' => 0,
        'set_time' => '',
    ];

    //日全网新增业绩列表
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $p = EcologyCreaditsDay::from('ecology_creadits_day');

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
        return view('admin.ecology_creadits_day.index');
    }

    // 修改页
    public function edit($id)
    {
        $b = EcologyCreaditsDay::find((int)$id);
        if (!$b) return redirect('/admin/ecology_creadits_day/index');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $b->$field);
        }

        $data['id'] = (int)$id;
       
        return view('admin.ecology_creadits_day.edit', $data);
    }

    // 手动结算操作
    public function update(Request $request, $id)
    {

        $id = $request->post('id');//
        $total_cny_actual = $request->post('total_cny_actual');//实际结算数
        $set_status = $request->post('set_status');//结算方式

        $res = EcologyCreaditsDay::find((int)$id);
        // dd($res['set_status']['value']);
        if (!$res) {
            return redirect(URL::previous())->with('fail', '信息有误');
        }
        if ($res['set_status']['value'] != 0) {
            return redirect(URL::previous())->with('fail', '请勿重复结算');
        }

        $dqtime = date('Y-m-d H:i:s');//当前时间
        $EcologyCreaditsDay = new EcologyCreaditsDay();

        $ecdData = [
            'total_cny_actual' => $total_cny_actual,
            'set_status' => $set_status,
            'set_time' => $dqtime,
        ];

        $EcologySettlement = new EcologySettlement;

        \DB::beginTransaction();
        try {
            //修改结算表信息
            $EcologyCreaditsDay->where("id",$id)->update($ecdData);
            /////待处理/////
            //结算
            $settlement = $EcologySettlement->settlement($id,$total_cny_actual,$res,$dqtime);
            if($settlement['code'] == 0){
                return redirect(URL::previous())->with('fail', '结算失败:'.$settlement['msg']);
            }
            
            // 加入队列处理
            // dispatch(new EcologySettlementQueue($id,$total_cny_actual,$res,$dqtime));
            /////待处理/////
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
            return redirect(URL::previous())->with('fail', '修改失败');
        }
        AdminLog::addLog('手动结算日期【'.$res['day_time'].'】(id:'.$res['id'].')日全网新增业绩');

        return redirect('/admin/ecology_creadits_day/index')->with('success', '修改成功');

    }

}