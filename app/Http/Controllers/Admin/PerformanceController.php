<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\Performance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerformanceController extends Controller
{
    //
    protected $fields = [
        'uid' => "",
        'num' => ""
    ];

    // 团队长业绩分红奖用户列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', '');

            $p = Performance::from('user_performance_bonus as up')
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
        return view('admin.performance_bonus.index');

    }
    // 新增团队长业绩分红奖用户
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.performance_bonus.create',$data);
    }

    // 添加团队长业绩分红奖用户
    public function store(Request $request)
    {
//        dd($request->get('uid'));

        $ver = new Performance();
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }
//        $ver->uid = 1;
//        $ver->num = 2;
        $ver->save();

        AdminLog::addLog('新增一个团队长业绩分红奖用户');

        return redirect('/admin/performance_bonus/index');
    }
    //删除团队长业绩分红奖用户
    public function destroy($id)
    {

        if (Performance::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的删除新增团队长加速分红用户');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

    // 修改团队长业绩分红用户
    public function edit($id)
    {
        $ver =Performance::find((int)$id);
        if (!$ver) return redirect('/admin/performance_bonus/index')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $ver->$field);
        }

        $data['id'] = (int)$id;
        return view('admin.performance_bonus.edit', $data);
    }

    // 更新团队长业绩分红用户
    public function update(Request $request, $id)
    {

        $ver = Performance::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        $ver->save();

        AdminLog::addLog('修改了ID为' . $id . '的团队长加速分红奖用户');

        return redirect('/admin/performance_bonus/index');
    }
}
