<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    protected $fields = [
        'name'        => '',
        'label'       => '',
        'description' => '',
        'cid'         => 0,
        'icon'        => '',
    ];

	//权限列表
    public function index(Request $request, $cid = 0)
    {
        $cid = $request->get('cid', 0);

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = Permission::where('cid', $cid);

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('name', 'like', '%' . $soso . '%')->orwhere('description', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();
            $data['cid'] = $cid;

            $p->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.permission.index', ['cid' => $cid]);
    }

    //新增权限
    public function create(Request $request)
    {
        $cid = $request->get('cid', 0);

        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $data['cid'] = $cid;

        return view('admin.permission.create', $data);
    }

    //添加权限
    public function store(Request $request)
    {
        $permission = new Permission();
        foreach (array_keys($this->fields) as $field) {
            $permission->$field = $request->get($field, $this->fields[$field]);
        }
        $permission->save();

        return redirect('/admin/permission?cid=' . $permission->cid)->with('success', '添加成功');
    }
    
    //修改权限
    public function edit($id)
    {
        $permission = Permission::find((int)$id);
        if (!$permission) return redirect('/admin/permission')->with('fail', "数据有误");
        $data = ['id' => (int)$id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $permission->$field);
        }

        return view('admin.permission.edit', $data);
    }

    //更新权限
    public function update(Request $request, $id)
    {
        $permission = Permission::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $permission->$field = $request->get($field, $this->fields[$field]);
        }
        $permission->save();

        return redirect('admin/permission?cid=' . $permission->cid)->with('success', '修改成功');
    }

	//删除权限
    public function destroy($id)
    {
        $child = Permission::where('cid', $id)->first();
        if ($child) {
            return returnJson(0, '请先将该权限的子权限删除后再做删除操作');
        }

        $tag = Permission::find((int)$id);
        foreach ($tag->roles as $v) {
            $tag->roles()->detach($v->id);
        }
        if ($tag) {
            $tag->delete();
        } else {
            return returnJson('删除失败');
        }

        return returnJson(1, '删除成功');
    }
}
