<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2020/3/18
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\EnergyAppointUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnergyAppointUserController extends Controller
{

    // 指定锁仓用户
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $p = EnergyAppointUser::from('energy_appoint_user as eat')
                ->select('eat.*', 'u.mobile', 'u.new_account', 'u.nickname', 'a.name as realname')
                ->join('user as u', 'u.id', 'eat.uid')
                ->leftJoin('authentication as a', 'a.uid', 'eat.uid');


            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('created_at')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.energy_appoint_user.index');

    }

    // 新增指定锁仓用户
    public function create(Request $request)
    {
        $data = ['new_account' => ''];
        return view('admin.energy_appoint_user.create', $data);
    }

    // 添加指定锁仓用户
    public function store(Request $request)
    {
        $sg = new EnergyAppointUser();
        $newAccount = $request->get('new_account', '');
        if(empty($newAccount)){
            return redirect('/admin/energy_appoint_user')->with('fail', '账号不能为空');
        }

        // 验证账号是否存在
        $user = User::where('new_account', $newAccount)->first();
        if(!$user){
            return redirect('/admin/energy_appoint_user')->with('fail', '用户不存在');
        }

        // 验证用户是否已经被指定锁仓
        if(EnergyAppointUser::where('uid', $user->id)->exists()){
            return redirect('/admin/energy_appoint_user')->with('fail', '该用户已被指定');
        }

        // 新增一个
        $sg->uid = $user->id;
        $sg->save();

        AdminLog::addLog('新增一个指定锁仓用户');

        return redirect('/admin/energy_appoint_user/index')->with('success', '添加成功');
    }

    //删除指定锁仓用户
    public function destroy($id)
    {

        $sg = EnergyAppointUser::find((int)$id);
        if(!$sg){
            return returnJson(0, '数据有误');
        }

        $sg->delete();

        AdminLog::addLog('删除ID为' . $id . '的指定锁仓用户');

        return returnJson(1, '删除成功');
    }

}