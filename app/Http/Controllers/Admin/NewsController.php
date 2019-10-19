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

class NewsController extends Controller
{

    protected $fields = [
        'type' => 1,
        'title' => '',
        'content' => '',
        'source' => ''
    ];

    // 资讯列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = Article::where('type', 1);

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

        return view('admin.news.index');
    }

    // 新增资讯
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.news.create', $data);
    }

    // 添加资讯
    public function store(Request $request)
    {

        $ver = new Article();
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        $ver->save();

        AdminLog::addLog('新增一条资讯');

        return redirect('/admin/news/index');
    }

    // 修改资讯
    public function edit($id)
    {
        $ver = Article::find((int)$id);
        if (!$ver) return redirect('/admin/news/index')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $ver->$field);
        }

        $data['id'] = (int)$id;
        return view('admin.news.edit', $data);
    }

    // 更新资讯
    public function update(Request $request, $id)
    {

        $ver = Article::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        $ver->save();

        AdminLog::addLog('修改了ID为' . $id . '的资讯');

        return redirect('/admin/news/index');
    }

    //删除资讯
    public function destroy($id)
    {

        if (Article::where('id', $id)->where('type', 1)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的资讯');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}