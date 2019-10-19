<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/10/17
 * Time: 11:46
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\KuangjiPosition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KuangWeiController extends Controller
{

    protected $fields = [
        'name' => '',
        'price' => 0,
        'status' => 1,
    ];

    // 矿位列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = KuangjiPosition::from('kuangji_position as kp');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.kuangwei.index');
    }

    // 新增矿位
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.kuangwei.create', $data);
    }

    // 添加矿位
    public function store(Request $request)
    {

        $b = new KuangjiPosition();
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }

        $b->save();

        AdminLog::addLog('新增矿位');

        return redirect('/admin/kuangwei/index')->with('success', '新增成功');
    }

    // 修改矿位
    public function edit($id)
    {
        $b = KuangjiPosition::find((int)$id);
        if (!$b) return redirect('/admin/kuangwei/index');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $b->$field);
        }

        $data['id'] = (int)$id;

        return view('admin.kuangwei.edit', $data);
    }

    // 更新矿位
    public function update(Request $request, $id)
    {

        $b = KuangjiPosition::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }
        $b->save();

        AdminLog::addLog('修改了ID为' . $id . '的矿位');

        return redirect('/admin/kuangwei/index')->with('success', '修改成功');
    }

    //删除矿机
    public function destroy($id)
    {

        if (KuangjiPosition::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的矿位');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}