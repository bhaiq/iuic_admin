<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/22
 * Time: 10:16
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\ExtraBonus;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExtraBonusController extends Controller
{

    protected $fields = [
        'tip' => 0,
        'users' => [],
    ];

    // 额外奖励列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = ExtraBonus::from('extra_bonus as eb');

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
            foreach ($data['data'] as $k => $v){

                $data['data'][$k]['users_str'] = '';
                if(is_array($v['users'])){

                    $uName = User::whereIn('id', $v['users'])->pluck('nickname');
                    if(!$uName->isEmpty()){

                        foreach ($uName->toArray() as $key => $val){

                            if($key != 0 && $key % 6 == 0){
                                $data['data'][$k]['users_str'] .= '<br>';
                            }

                            $data['data'][$k]['users_str'] .= '<span class="layui-btn layui-btn-xs layui-btn-normal">' . $val . '</span>';
                        }

                    }

                }

            }

            return response()->json($data);
        }

        return view('admin.extra_bonus.index');
    }

    // 新增额外奖励
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $data['user_arr'] = User::where('status', 1)->get()->toArray();
        return view('admin.extra_bonus.create', $data);
    }

    // 添加额外的奖励
    public function store(Request $request)
    {

        $ver = new ExtraBonus();
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        if($request->has('ids') && !empty($request->get('ids'))){

            if(is_array($request->get('ids'))){
                $ver->users = implode(',', $request->get('ids'));
            }

        }

        $ver->save();

        AdminLog::addLog('新增一条额外奖励');

        return redirect('/admin/extra_bonus/index');
    }

    // 修改额外的奖励
    public function edit($id)
    {
        $ver = ExtraBonus::find((int)$id);
        if (!$ver) return redirect('/admin/extra_bonus/index')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $ver->$field);
        }

        $data['id'] = (int)$id;
        $data['user_arr'] = User::where('status', 1)->get()->toArray();

        return view('admin.extra_bonus.edit', $data);
    }

    // 更新额外的奖励
    public function update(Request $request, $id)
    {

        $ver = ExtraBonus::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        if($request->has('ids') && !empty($request->get('ids'))){

            if(is_array($request->get('ids'))){
                $ver->users = implode(',', $request->get('ids'));
            }

        }

        $ver->save();

        AdminLog::addLog('修改了ID为' . $id . '的额外奖励');

        return redirect('/admin/extra_bonus/index');
    }

    //删除额外的奖励
    public function destroy($id)
    {

        if (ExtraBonus::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的额外奖励');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}