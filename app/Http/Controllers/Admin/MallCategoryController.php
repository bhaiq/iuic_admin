<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/10/10
 * Time: 9:53
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\MallCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MallCategoryController extends Controller
{

    protected $fields = [
        'name' => '',
    ];

    // 分类列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = MallCategory::from('mall_category as mc');

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

        return view('admin.mall_category.index');

    }

    //新增分类
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.mall_category.create', $data);
    }

    //添加分类
    public function store(Request $request)
    {
        $sg = new MallCategory();
        foreach (array_keys($this->fields) as $field) {
            $sg->$field = $request->get($field);
        }

        $sg->save();

        AdminLog::addLog('新增新商城分类');

        return redirect('/admin/mall_category/index')->with('success', '添加成功');
    }

    //修改分类
    public function edit($id)
    {
        $sg = MallCategory::find((int)$id);
        if (!$sg) return redirect('/admin/mall_category')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $sg->$field);
        }

        $data['id'] = (int)$id;

        return view('admin.mall_category.edit', $data);

    }

    //更新分类
    public function update(Request $request, $id)
    {

        $sg = MallCategory::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $sg->$field = $request->get($field);
        }

        $sg->save();

        AdminLog::addLog('编辑ID为' . $id . '的新商城分类信息');

        return redirect('/admin/mall_category/index')->with('success', '编辑成功');
    }

    //删除分类
    public function destroy($id)
    {

        $sg = MallCategory::find((int)$id);
        if(!$sg){
            return returnJson(0, '数据有误');
        }

        $sg->delete();

        AdminLog::addLog('删除ID为' . $id . '的新商城分类信息');

        return returnJson(1, '删除成功');
    }

}