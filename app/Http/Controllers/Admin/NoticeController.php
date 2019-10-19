<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/17
 * Time: 14:20
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{

    protected $fields = [
        'type' => 0,
        'title' => '',
        'content' => '',
    ];

    // 公告列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = Article::where('type', 0);

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('title', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.notice.index');
    }

    // 新增公告
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.notice.create', $data);
    }

    // 添加公告
    public function store(Request $request)
    {

        $ver = new Article();
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        $ver->save();

        AdminLog::addLog('新增一条公告');

        return redirect('/admin/notice/index');
    }

    // 修改公告
    public function edit($id)
    {
        $ver = Article::find((int)$id);
        if (!$ver) return redirect('/admin/notice/index')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $ver->$field);
        }

        $data['id'] = (int)$id;
        return view('admin.notice.edit', $data);
    }

    // 更新公告
    public function update(Request $request, $id)
    {

        $ver = Article::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        $ver->save();

        AdminLog::addLog('修改了ID为' . $id . '的公告');

        return redirect('/admin/notice/index');
    }

    //删除公告
    public function destroy($id)
    {

        if (Article::where('id', $id)->where('type', 0)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的公告');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}