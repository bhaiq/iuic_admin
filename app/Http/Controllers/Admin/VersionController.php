<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/19
 * Time: 10:16
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\Version;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VersionController extends Controller
{

    protected $fields = [
        'url' => '',
        'current_version' => '',
        'is_force' => 0,
        'type' => 0,
        'remark' => '',
    ];

    // 版本列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = Version::from('version as v');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('current_version', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.version.index');
    }

    // 新增版本
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.version.create', $data);
    }

    // 添加版本
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'url' => 'required',
            'current_version' => 'required',
            'is_force' => 'required',
            'type' => 'required',
        ], [
            'url.required' => '安装包地址不能为空',
            'current_version.required' => '版本号不能为空',
            'is_force.required' => '是否强制不能为空',
            'type.required' => '系统类型不能为空',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/version/index', $validator->errors()->first());
        }

        $ver = new Version();

        $ver->url = $request->get('url');
        $ver->current_version = $request->get('current_version');
        $ver->is_force = $request->get('is_force');
        $ver->type = $request->get('type');

        $ver->save();

        AdminLog::addLog('新增版本');

        return redirect('/admin/version/index')->with('success', '新增成功');
    }

    // 修改轮播图
    public function edit($id)
    {
        $ver = Version::find((int)$id);
        if (!$ver) return redirect('/admin/version/index');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $ver->$field);
        }

        $data['id'] = (int)$id;

        return view('admin.version.edit', $data);
    }

    // 更新轮播图
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'url' => 'required',
            'current_version' => 'required',
            'is_force' => 'required',
            'type' => 'required',
        ], [
            'url.required' => '安装包地址不能为空',
            'current_version.required' => '版本号不能为空',
            'is_force.required' => '是否强制不能为空',
            'type.required' => '系统类型不能为空',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/version/index', $validator->errors()->first());
        }

        $ver = Version::find($id);
        if(!$ver){
            return redirect('/admin/version/index')->with('fail', '数据有误');
        }

        $ver->url = $request->get('url');
        $ver->current_version = $request->get('current_version');
        $ver->is_force = $request->get('is_force');
        $ver->type = $request->get('type');

        $ver->save();

        AdminLog::addLog('修改了ID为' . $id . '的版本');

        return redirect('/admin/version/index')->with('success', '修改成功');
    }

    //删除轮播图
    public function destroy($id)
    {

        if (Version::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的版本');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}