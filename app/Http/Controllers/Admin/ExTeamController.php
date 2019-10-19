<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/16
 * Time: 16:57
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\Coin;
use App\Models\ExTeam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ExTeamController extends Controller
{

    protected $fields = [
        'name' => '',
        'coin_id_goods' => '',
        'coin_id_legal' => '',
        'status' => 0,
    ];

    // 交易对
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = ExTeam::from('ex_team as et')
                ->select('et.*', 'c.name as jyb_name', 'cc.name as fb_name')
                ->join('coin as c', 'c.id', 'et.coin_id_goods')
                ->join('coin as cc', 'cc.id', 'et.coin_id_legal');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.ex_team.index');

    }

    //新增交易对
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $data['jy_coins'] = Coin::noLegal()->get()->toArray();
        $data['fb_coins'] = Coin::legal()->get()->toArray();
        $data['status_arr'] = ['正常交易', '维护中', '关闭'];

        return view('admin.ex_team.create', $data);
    }

    //添加交易对
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'coin_id_goods' => 'required',
            'coin_id_legal' => 'required',
            'status' => 'required',
        ], [
            'name.required' => '名称不能为空',
            'coin_id_goods.required' => '交易币不能为空',
            'coin_id_legal.required' => '法币不能为空',
            'status.required' => '状态不能为空',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        // 判断目前有木有此交易对
        if(ExTeam::where(['coin_id_goods' => $request->get('coin_id_goods'), 'coin_id_legal' => $request->get('coin_id_legal')])->exists()){
            return returnJson(0, '该交易对已经存在');
        }

        $exData = [
            'name' => $request->get('name'),
            'coin_id_goods' => $request->get('coin_id_goods'),
            'coin_id_legal' => $request->get('coin_id_legal'),
            'status' => $request->get('status'),
        ];
        ExTeam::create($exData);

        AdminLog::addLog('新增交易对');

        return returnJson(1, '新增成功');

    }

    //修改交易对
    public function edit($id)
    {
        $sg = ExTeam::find((int)$id);
        if (!$sg) return redirect('/admin/ex_team')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $sg->$field);
        }

        $data['id'] = (int)$id;
        $data['jy_coins'] = Coin::noLegal()->get()->toArray();
        $data['fb_coins'] = Coin::legal()->get()->toArray();
        $data['status_arr'] = ['正常交易', '维护中', '关闭'];

        return view('admin.ex_team.edit', $data);

    }

    //更新交易对
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'coin_id_goods' => 'required',
            'coin_id_legal' => 'required',
            'status' => 'required',
        ], [
            'name.required' => '名称不能为空',
            'coin_id_goods.required' => '交易币不能为空',
            'coin_id_legal.required' => '法币不能为空',
            'status.required' => '状态不能为空',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        // 判断数据是否有问题
        $ex = ExTeam::where('id', $id)->first();
        if(!$ex){
            return returnJson(0, '数据有误');
        }

        // 判断目前有木有此交易对
        if(ExTeam::where('id', '!=', $id)->where(['coin_id_goods' => $request->get('coin_id_goods'), 'coin_id_legal' => $request->get('coin_id_legal')])->exists()){
            return returnJson(0, '该交易对已经存在');
        }

        $ex->name = $request->get('name');
        $ex->coin_id_goods = $request->get('coin_id_goods');
        $ex->coin_id_legal = $request->get('coin_id_legal');
        $ex->status = $request->get('status');
        $ex->save();

        AdminLog::addLog('更新交易对');

        return returnJson(1, '编辑成功');
    }

    //删除交易对
    public function destroy($id)
    {

        $sg = ExTeam::find((int)$id);
        if(!$sg){
            return returnJson(0, '数据有误');
        }

        $sg->delete();

        AdminLog::addLog('删除ID为' . $id . '的交易对');

        return returnJson(1, '删除成功');
    }

}