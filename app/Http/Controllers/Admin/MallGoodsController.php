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
            'status' => 'required|in:1,2,9',
        ], [
            'id.required' => '订单信息不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态数据不正确',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        if ($request->get('status') == 1 || $request->get('status') == 2){

            $up = MallGood::where('id', $request->get('id'))->where('is_affirm', 0)->first();

        }else{

            $up = MallGood::where('id', $request->get('id'))->where('is_affirm', 1)->where('status', '!=', 9)->first();
        }

        if(!$up){
            return returnJson(0, '数据有误');
        }

        \DB::beginTransaction();
        try {

            // 订单状态改变
            if($request->get('status') == 1){
                $up->is_affirm = 1;
            }

            if($request->get('status') == 2){
                $up->is_affirm = 9;
            }

            if($request->get('status') == 9){
                $up->status = 9;
            }

            $up->save();

            \DB::commit();

        } catch (\Exception $exception) {

            \DB::rollBack();

            \Log::info('更新商品状态', $request->all());

            return returnJson(0, '操作异常');

        }

        return returnJson(1, '操作成功');

    }

    // 修改商品信息
    public function edit(Request $request)
    {

        $id = $request->get('id');
        $mg = MallGood::find($id);
        if(!$mg){
            return returnJson(0, '数据有误');
        }

        if($request->isMethod('POST')){

            $validator = Validator::make($request->all(), [
                'goods_price' => 'required|numeric',
                'goods_cost' => 'required|numeric',
                'ore_pool' => 'required|numeric',
            ], [
                'goods_price.required' => '售价不能为空',
                'goods_price.numeric' => '售价格式不正确',
                'goods_cost.required' => '成本价不能为空',
                'goods_cost.numeric' => '成本价格式不正确',
                'ore_pool.required' => '赠送的矿池不能为空',
                'ore_pool.numeric' => '赠送的矿池格式不正确',
            ]);

            if ($validator->fails()) {
                return returnJson(0, $validator->errors()->first());
            }

            if($request->get('goods_cost') > $request->get('goods_price')){
                return returnJson(0, '成本价不能大于售价');
            }

            \DB::beginTransaction();
            try {

                $mg->goods_price = $request->get('goods_price');
                $mg->goods_cost = $request->get('goods_cost');
                $mg->ore_pool = $request->get('ore_pool');
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
            'goods_price' => $mg->goods_price,
            'goods_cost' => $mg->goods_cost,
            'ore_pool' => $mg->ore_pool,

        ];

        return view('admin.mall_goods.edit', $data);

    }

}