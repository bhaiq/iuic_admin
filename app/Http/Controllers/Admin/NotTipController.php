<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/24
 * Time: 10:34
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\NotTip;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotTipController extends Controller
{

    protected $fields = [
        'uid' => '',
    ];

    // 免手续费
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = NotTip::from('not_tip as nt')
                ->select('nt.*', 'u.mobile', 'a.name as realname')
                ->join('user as u', 'u.id', 'nt.uid')
                ->leftJoin('authentication as a', 'a.uid', 'u.id');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.mobile', 'like', '%' . $soso . '%')
                        ->orwhere('a.name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('nt.id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.not_tip.index');
    }

    // 新增免手续费
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $notTips = NotTip::pluck('uid')->toArray();

        $data['users'] = User::whereNotIn('id', $notTips)->get()->toArray();

        return view('admin.not_tip.create', $data);
    }

    // 添加免手续费
    public function store(Request $request)
    {

        $ver = new NotTip();
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        $ver->save();

        AdminLog::addLog('新增一个免手续费用户信息');

        return redirect('/admin/not_tip/index');
    }

    // 修改免手续费用户
    public function edit($id)
    {
        $ver = NotTip::find((int)$id);
        if (!$ver) return redirect('/admin/not_tip/index')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $ver->$field);
        }

        $data['id'] = (int)$id;

        $notTips = NotTip::where('uid', '!=', $ver->uid)->pluck('uid')->toArray();
        $data['users'] = User::whereNotIn('id', $notTips)->get()->toArray();

        return view('admin.not_tip.edit', $data);
    }

    // 更新资讯
    public function update(Request $request, $id)
    {

        $ver = NotTip::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        $ver->save();

        AdminLog::addLog('修改了ID为' . $id . '的免手续费用户信息');

        return redirect('/admin/not_tip/index');
    }

    //删除资讯
    public function destroy($id)
    {

        if (NotTip::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的免收费用户信息');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}