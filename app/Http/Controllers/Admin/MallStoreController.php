<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/10/10
 * Time: 10:44
 */

namespace App\Http\Controllers\Admin;

use App\Models\MallStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MallStoreController extends Controller
{

    // 店铺列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = MallStore::from('mall_store as ms')
                ->select('ms.*', 'u.mobile as u_mobile', 'a.name as realname')
                ->join('user as u', 'u.id', 'ms.uid')
                ->leftJoin('authentication as a', 'a.uid', 'ms.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('ms.name', 'like', '%' . $soso . '%')
                        ->orwhere('ms.mobile', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%')
                        ->orwhere('a.name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();

            foreach ($data['data'] as $k => $v){

                $newAddress = '';
                $i = 0;

                $arr = explode(',', $v['address']);
                foreach ($arr as $val) {
                    if ($i > 0) {
                        $newAddress .= $val;
                    }
                    $i++;
                }

                $data['data'][$k]['address'] = $newAddress . $v['address_info'];

            }

            return response()->json($data);
        }

        return view('admin.mall_store.index');
    }

    // 店铺状态更新
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

        $up = MallStore::where('id', $request->get('id'))->where('status', 0)->first();
        if(!$up){
            return returnJson(0, '数据有误');
        }

        \DB::beginTransaction();
        try {

            // 订单状态改变
            $up->status = $request->get('status');
            $up->save();

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            \Log::info('更改店铺状态出现问题', $request->all());

            return returnJson(0, '操作异常');

        }

        return returnJson(1, '操作成功');

    }
}