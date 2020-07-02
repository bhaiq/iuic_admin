<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/17
 * Time: 15:10
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{

    protected $fields = [
        'title' => '',
        'img_url' => '',
        'top' => 0,
        'type' => 0,
        'jump_type' => 0,
        'jump_url' => '',
    ];

    // 轮播图列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = Banner::from('banner as b');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('title', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            foreach ($data['data'] as $k => $v){

                $data['data'][$k]['type_name'] = Banner::TYPES[$v['type']];
                $data['data'][$k]['jump_type_name'] = Banner::JUMP_TYPE[$v['jump_type']];

            }

            return response()->json($data);
        }

        return view('admin.banner.index');
    }

    // 新增轮播图
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $data['types'] = Banner::TYPES;
        $data['jump_types'] = Banner::JUMP_TYPE;

        return view('admin.banner.create', $data);
    }

    // 添加轮播图
    public function store(Request $request)
    {

        $b = new Banner();
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }

        $b->save();

        AdminLog::addLog('新增轮播图');

        return redirect('/admin/banner/index')->with('success', '新增成功');
    }

    // 修改轮播图
    public function edit($id)
    {
        $b = Banner::find((int)$id);
        if (!$b) return redirect('/admin/banner/index');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $b->$field);
        }

        $data['id'] = (int)$id;
        $data['types'] = Banner::TYPES;
        $data['jump_types'] = Banner::JUMP_TYPE;

        return view('admin.banner.edit', $data);
    }

    // 更新轮播图
    public function update(Request $request, $id)
    {

        $b = Banner::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }
        $b->save();

        AdminLog::addLog('修改了ID为' . $id . '的轮播图');

        return redirect('/admin/banner/index')->with('success', '修改成功');
    }

    //删除轮播图
    public function destroy($id)
    {

        if (Banner::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的轮播图');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}