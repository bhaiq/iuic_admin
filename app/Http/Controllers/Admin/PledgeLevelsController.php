<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/24
 * Time: 17:51
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\PledgeLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PledgeLevelsController extends Controller
{

    protected $fields = [
        'num' => '',
        'pledge_bl' => '',
    ];

    // 质押级别列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $p = PledgeLevel::from('pledge_levels as ab');

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('num')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.pledge_levels.index');
    }

    // 新增指定节点
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.pledge_levels.create', $data);
    }

    // 添加指定节点
    public function store(Request $request)
    {

        $b = new PledgeLevel();
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }

        $b->save();

        AdminLog::addLog('新增质押级别');

        return redirect('/admin/pledge_levels/index')->with('success', '新增成功');
    }

    // 修改质押级别
    public function edit($id)
    {
        $b = PledgeLevel::find((int)$id);
        if (!$b) return redirect('/admin/pledge_levels/index');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $b->$field);
        }

        $data['id'] = (int)$id;

        return view('admin.pledge_levels.edit', $data);
    }

    // 更新质押级别
    public function update(Request $request, $id)
    {

        $b = PledgeLevel::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }
        $b->save();

        AdminLog::addLog('修改了ID为' . $id . '的质押级别');

        return redirect('/admin/pledge_levels/index')->with('success', '修改成功');
    }

    //删除质押级别
    public function destroy($id)
    {

        if (PledgeLevel::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的质押级别');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}