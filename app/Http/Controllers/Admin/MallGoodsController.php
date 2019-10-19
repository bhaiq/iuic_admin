<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/10/10
 * Time: 11:26
 */

namespace App\Http\Controllers\Admin;

use App\Models\MallGood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MallGoodsController extends Controller
{

    // 商品列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', '');

            $p = MallGood::from('mall_goods as mg')
                ->select('mg.*', 'ms.name as store_name', 'mc.name as category_name')
                ->join('mall_store as ms', 'ms.id', 'mg.store_id')
                ->join('mall_category as mc', 'mc.id', 'mg.category_id')
                ->where('mg.status', '!=', 9);

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('ms.name', 'like', '%' . $soso . '%')
                        ->orwhere('mc.name', 'like', '%' . $soso . '%')
                        ->orwhere('mg.goods_name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('mg.id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.mall_goods.index');

    }

    // 商品编辑
    public function ajax(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:9',
        ], [
            'id.required' => '订单信息不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态数据不正确',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        $up = MallGood::where('id', $request->get('id'))->where('status', '!=', 9)->first();
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

            \Log::info('更新商品状态', $request->all());

            return returnJson(0, '操作异常');

        }

        return returnJson(1, '操作成功');

    }

    // 修改矿池
    public function pool(Request $request)
    {

        $id = $request->get('id');
        $mg = MallGood::find($id);
        if(!$mg){
            return returnJson(0, '数据有误');
        }

        if($request->isMethod('POST')){

            $validator = Validator::make($request->all(), [
                'num' => 'required|numeric',
            ], [
                'num.required' => '数量不能为空',
                'num.numeric' => '数量格式不正确',
            ]);

            if ($validator->fails()) {
                return returnJson(0, $validator->errors()->first());
            }

            \DB::beginTransaction();
            try {

                $mg->ore_pool = $request->get('num');
                $mg->save();

                \DB::commit();

            } catch (\Exception $exception) {

                \DB::rollBack();

                \Log::info('用户改变商品赠送矿池失败', $request->all());

                return returnJson(0, '操作异常');

            }

            return returnJson(1, '操作成功');

        }

        $data = [
            'id' => $id,
            'num' => $mg->ore_pool,
        ];

        return view('admin.mall_goods.pool', $data);

    }

}