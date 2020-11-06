<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/9/19
 * Time: 15:28
 */

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Models\AccountLog;
use App\Models\User;
use App\Models\UserPartner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminLog;

class PartnerController extends Controller
{
     protected $fields = [
        'uid' => "",
        'count' => '',
        'num' => '',
        'coin_id'=>'',
        'status'=>'',
    ];

    // 合伙人列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', '');

            $p = UserPartner::from('user_partner as up')
                ->select('up.*', 'u.mobile', 'u.new_account', 'u.nickname', 'a.name as realname')
                ->join('user as u', 'u.id', 'up.uid')
                ->leftJoin('authentication as a', 'a.uid', 'up.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.nickname', 'like', '%' . $soso . '%')
                        ->orwhere('u.new_account', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('up.id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.partner.index');

    }

    // 合伙人审核
    public function ajax(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:1,9',
        ], [
            'id.required' => '订单信息不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态数据不正确',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        $up = UserPartner::where('id', $request->get('id'))->where('status', 0)->first();
        if(!$up){
            return returnJson(0, '数据有误');
        }

        \DB::beginTransaction();
        try {

            if($request->get('status') == 1){

                // 订单状态改变
                $up->status = 1;
                $up->save();

                // 用户状态改变
                User::where('id', $up->uid)->update(['is_partner' => 1]);

                // 用户冻结余额减少
                Account::reduceFrozen($up->uid, $up->coin_id, $up->num);

                // 用户增加余额日志
                AccountLog::addLog($up->uid, $up->coin_id, $up->num, 18, 0, 1, '申请合伙人');

            }else{

                // 用户状态改变
                User::where('id', $up->uid)->update(['is_partner' => 0]);

                // 用户可用余额增加
                Account::addAmount($up->uid, $up->coin_id, $up->num);

                // 用户冻结余额减少
                Account::reduceFrozen($up->uid, $up->coin_id, $up->num);

                // 订单状态改变
                $up->delete();

            }

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            \Log::info('更改用户申请合伙人状态异常', $request->all());

            return returnJson(0, '操作异常');

        }

        return returnJson(1, '操作成功');

    }
    
     // 新增合伙人
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.partner.create', $data);
    }

    // 添加合伙人
    public function store(Request $request)
    {

        $ver = new UserPartner();
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        $ver->save();

        AdminLog::addLog('新增一个合伙人');

        return redirect('/admin/partner/index');
    }
    //删除合伙人
    public function destroy($id)
    {

        if (UserPartner::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的公告');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }
    
    // 修改公告
    public function edit($id)
    {
        $ver =UserPartner::find((int)$id);
        if (!$ver) return redirect('/admin/partner/index')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $ver->$field);
        }

        $data['id'] = (int)$id;
        return view('admin.partner.edit', $data);
    }

    // 更新公告
    public function update(Request $request, $id)
    {

        $ver = UserPartner::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $ver->$field = $request->get($field);
        }

        $ver->save();

        AdminLog::addLog('修改了ID为' . $id . '的合伙人');

        return redirect('/admin/partner/index');
    }

}