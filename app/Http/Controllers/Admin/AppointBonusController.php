<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/4
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\AppointBonus;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointBonusController extends Controller
{

    protected $fields = [
        'type' => 1,
        'node_type' => 0,
    ];

    private $nodes = [
        '普通节点', '小节点', '大节点', '超级节点'
    ];

    // 指定节点列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = AppointBonus::from('appoint_bonus as ab')
                ->select('ab.*', 'u.mobile as u_mobile', 'u.new_account', 'a.name as realname')
                ->join('user as u', 'u.id', 'ab.uid')
                ->leftJoin('authentication as a', 'a.uid', 'ab.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('u.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.appoint_bonus.index');
    }

    // 新增指定节点
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $data['account'] = '';
        $data['nodes'] = $this->nodes;

        return view('admin.appoint_bonus.create', $data);
    }

    // 添加指定节点
    public function store(Request $request)
    {

        $b = new AppointBonus();
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }

        $account = $request->get('account');

        $user = User::where('mobile', $account)->first();
        if(!$user){
            return redirect('/admin/appoint_bonus/index')->with('fail', '用户账号有误');
        }

        // 验证当前用户是否已经指定了节点
        if(AppointBonus::where(['uid' => $user->id, 'type' => 1])->exists()){
            return redirect('/admin/appoint_bonus/index')->with('fail', '当前用户已经被指定了节点奖');
        }

        $b->uid = $user->id;
        $b->save();

        AdminLog::addLog('新增指定节点');

        return redirect('/admin/appoint_bonus/index')->with('success', '新增成功');
    }

    //删除指定节点
    public function destroy($id)
    {

        if (AppointBonus::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的指定节点');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}