<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/3/22
 * Time: 9:46
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\AdminUser;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $fields = [
        'name' => '',
        'email' => '',
        'roles' => []
    ];

    // 管理员列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = AdminUser::from('admin_users as au');

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

        return view('admin.admin.index');

    }

    //新增管理
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $data['rolesAll'] = Role::all()->toArray();

        return view('admin.admin.create', $data);
    }

    //添加管理员
    public function store(Request $request)
    {

        $user = new AdminUser();
        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }
        $user->password = bcrypt($request->get('password'));
        unset($user->roles);
        $user->save();

        if (is_array($request->get('role'))) {
            $user->giveRoleTo($request->get('role'));
        }

        AdminLog::addLog('新增管理员');

        return redirect('/admin/admin/index')->with('success', '添加成功');
    }

    //修改管理员
    public function edit($id)
    {
        $user = AdminUser::find((int)$id);
        if (!$user) return redirect('/admin/admin');
        $roles = [];
        if ($user->roles) {
            foreach ($user->roles as $v) {
                $roles[] = $v->id;
            }
        }
        $user->roles = $roles;
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $user->$field);
        }
        $data['rolesAll'] = Role::all()->toArray();

        $data['id'] = (int)$id;

        return view('admin.admin.edit', $data);

    }

    //更新管理员
    public function update(Request $request, $id)
    {

        $user = AdminUser::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }
        unset($user->roles);

        if (!empty($request->get('password'))) {
            $user->password = bcrypt($request->get('password'));

        }

        $user->save();

        $user->giveRoleTo($request->get('role', []));

        AdminLog::addLog('编辑ID为' . $id . '的管理员信息');

        return redirect('/admin/admin/index')->with('success', '编辑成功');
    }

    //删除管理员
    public function destroy($id)
    {

        $tag = AdminUser::find((int)$id);
        foreach ($tag->roles as $v) {
            $tag->roles()->detach($v);
        }
        if ($tag && $tag->id != 1) {
            $tag->delete();
        } else {
            return returnJson(0, '删除失败');
        }

        AdminLog::addLog('删除ID为' . $id . '的管理员');

        return returnJson(1, '删除成功');
    }


}