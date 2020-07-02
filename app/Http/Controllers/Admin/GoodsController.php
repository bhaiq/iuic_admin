<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/16
 * Time: 14:35
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\ShopGood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{

    protected $fields = [
        'goods_name' => '',
        'goods_img' => '',
        'goods_info' => '',
        'goods_price' => 1,
        'coin_type' => '',
        'ore_pool' => '',
        'buy_count' => 1,
        'goods_details' => '',
      	'bonus_coefficient' => '',
      	'is_show'=>'',
    ];

    // 商品列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = ShopGood::from('shop_goods as sg');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('goods_name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.goods.index');

    }

    //新增商品
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $data['coins'] = ['USDT'];

        return view('admin.goods.create', $data);
    }

    //添加商品
    public function store(Request $request)
    {
        $sg = new ShopGood();
        foreach (array_keys($this->fields) as $field) {
            $sg->$field = $request->get($field);
        }

        $sg->save();

        AdminLog::addLog('新增商城商品');

        return redirect('/admin/goods/index')->with('success', '添加成功');
    }

    //修改商品
    public function edit($id)
    {
        $sg = ShopGood::find((int)$id);
        if (!$sg) return redirect('/admin/goods')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $sg->$field);
        }

        $data['id'] = (int)$id;
        $data['coins'] = ['USDT'];

        return view('admin.goods.edit', $data);

    }

    //更新商品
    public function update(Request $request, $id)
    {

        $sg = ShopGood::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $sg->$field = $request->get($field);
        }

        $sg->save();

        AdminLog::addLog('编辑ID为' . $id . '的商品信息');

        return redirect('/admin/goods/index')->with('success', '编辑成功');
    }

    //删除商品
    public function destroy($id)
    {

        $sg = ShopGood::find((int)$id);
        if(!$sg){
            return returnJson(0, '数据有误');
        }

        $sg->delete();

        AdminLog::addLog('删除ID为' . $id . '的商品');

        return returnJson(1, '删除成功');
    }

}