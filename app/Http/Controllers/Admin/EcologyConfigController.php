<?php
//生态2等级配置
namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EcologyConfig;

class EcologyConfigController extends Controller
{

    protected $fields = [
        'name' => '',
        'branch_num' => 3,
        'branch_level' => 1,
        'rate_bonus' => 0,
        'remarks' => '',
    ];

    // 等级配置列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = EcologyConfig::from('ecology_config as k');

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

        return view('admin.ecology.index');
    }

    // 新增等级配置页
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $EcologyConfig = new EcologyConfig();
        $data['levels'] = $EcologyConfig
            ->select('id','name')
            ->get();
            // dd($data);

        return view('admin.ecology.create', $data);
    }

    // 添加等级配置操作
    public function store(Request $request)
    {

        $b = new EcologyConfig();
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }

        $b->save();

        AdminLog::addLog('新增生态2等级');

        return redirect('/admin/ecology/index')->with('success', '新增成功');
    }

    // 修改页
    public function edit($id)
    {
        $b = EcologyConfig::find((int)$id);
        if (!$b) return redirect('/admin/ecology/index');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $b->$field);
        }

        $data['id'] = (int)$id;

        $EcologyConfig = new EcologyConfig();
        $data['levels'] = $EcologyConfig
            ->select('id','name')
            ->get();

        return view('admin.ecology.edit', $data);
    }

    // 更新操作
    public function update(Request $request, $id)
    {

        $b = EcologyConfig::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }
        $b->save();

        AdminLog::addLog('修改了ID为' . $id . '的生态2等级');

        return redirect('/admin/ecology/index')->with('success', '修改成功');
    }

    //删除操作
    public function destroy($id)
    {

        if (EcologyConfig::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的生态2等级');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}