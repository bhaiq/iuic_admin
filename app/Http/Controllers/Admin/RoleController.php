<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;

class RoleController extends Controller
{
    protected $fields = [
        'name' => '',
        'description' => '',
        'permissions' => [],
    ];

    //角色列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 0);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = Role::from('admin_roles');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('name', 'like', '%' . $soso . '%')->orwhere('description', 'like', '%' . $soso . '%');
                });
            }


            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);

        }
        return view('admin.role.index');
    }

    //添加角色
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $arr = Permission::all()->toArray();
        foreach ($arr as $v) {
            $data['permissionAll'][$v['cid']][] = $v;
        }
        return view('admin.role.create', $data);
    }

    //增加角色
    public function store(Request $request)
    {
        $role = new Role();
        foreach (array_keys($this->fields) as $field) {
            $role->$field = $request->input($field);
        }
        unset($role->permissions);
        $role->save();
        if (is_array($request->input('permissions'))) {
            $role->permissions()->sync($request->input('permissions', []));
        }

        return redirect('/admin/role')->with('success', '添加成功');
    }

    //修改角色
    public function edit($id)
    {
        $role = Role::find((int)$id);
        if (!$role) return redirect('/admin/role')->with('fail', "数据有误");
        $permissions = [];
        if ($role->permissions) {
            foreach ($role->permissions as $v) {
                $permissions[] = $v->id;
            }
        }
        $role->permissions = $permissions;
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $role->$field);
        }
        $arr = Permission::all()->toArray();
        foreach ($arr as $v) {
            $data['permissionAll'][$v['cid']][] = $v;
        }
        $data['id'] = (int)$id;
        return view('admin.role.edit', $data);
    }

    //更新角色
    public function update(Request $request, $id)
    {
        $role = Role::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $role->$field = $request->input($field);
        }
        unset($role->permissions);
        $role->save();

        $role->permissions()->sync($request->input('permissions', []));

        return redirect('/admin/role')->with('success', '修改成功');
    }

    //删除角色
    public function destroy($id)
    {

        $role = Role::find((int)$id);
        foreach ($role->users as $v) {
            $role->users()->detach($v);
        }

        foreach ($role->permissions as $v) {
            $role->permissions()->detach($v);
        }

        if ($role) {
            $role->delete();
        } else {
            return returnJson(0, '删除失败');
        }

        return returnJson(1, '删除成功');
    }
}
