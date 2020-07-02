<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/17
 * Time: 14:20
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\Agreement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgreementController extends Controller
{

    protected $fields = [
        'agreements' => ""
    ];

    // 公告列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = new Agreement;

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

        return view('admin.agreement.index');
    }

    // 修改公告
    public function edit($id)
    {
        $ver = Agreement::find((int)$id);
        if (!$ver) return redirect('/admin/agreement/index')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $ver->$field);
        }

        $data['id'] = (int)$id;
        // $data['agreement'] = $;
        // dd($data);
        return view('admin.agreement.edit', $data);
    }

    // 更新公告
    public function update(Request $request, $id)
    {

        $ver = Agreement::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        $ver->save();

        AdminLog::addLog('修改了免责协议');

        return redirect('/admin/agreement/index');
    }

}
