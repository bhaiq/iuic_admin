<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/9/20
 * Time: 16:44
 */

namespace App\Http\Controllers\Admin;

use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommunityController extends Controller
{

    // 社区列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', '');

            $p = Community::from('community as c')
                ->select('c.*', 'u.mobile as u_mobile', 'u.new_account', 'u.nickname', 'a.name as realname')
                ->join('user as u', 'u.id', 'c.uid')
                ->leftJoin('authentication as a', 'a.uid', 'c.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.nickname', 'like', '%' . $soso . '%')
                        ->orwhere('c.address', 'like', '%' . $soso . '%')
                        ->orwhere('u.new_account', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('c.id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.community.index');

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

        $up = Community::where('id', $request->get('id'))->where('status', 0)->first();
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
                User::where('id', $up->uid)->update(['is_community' => 1]);


            }else{

                // 用户状态改变
                User::where('id', $up->uid)->update(['is_community' => 9]);

                // 订单状态改变
                $up->delete();

            }

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            \Log::info('处理社区申请异常', $request->all());

            return returnJson(0, '操作异常');

        }

        return returnJson(1, '操作成功');

    }

}