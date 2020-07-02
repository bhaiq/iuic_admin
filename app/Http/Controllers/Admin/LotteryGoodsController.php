<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/13
 * Time: 15:24
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\LotteryGoods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LotteryGoodsController extends Controller
{

    protected $fields = [
        'name' => '',
        'img' => '',
        'zj_bl' => '',
        'is_xc' => 0,
        'info' => '',
        'is_display' => 1,
    ];

    // 商品列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = LotteryGoods::from('lottery_goods as lg');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->oldest('id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.lottery_goods.index');

    }

    //修改商品
    public function edit($id)
    {
        $sg = LotteryGoods::find((int)$id);
        if (!$sg) return redirect('/admin/lottery_goods')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $sg->$field);
        }

        $data['id'] = (int)$id;

        return view('admin.lottery_goods.edit', $data);

    }

    //更新商品
    public function update(Request $request, $id)
    {

        $sg = LotteryGoods::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $sg->$field = $request->get($field);
        }

        $sg->save();

        AdminLog::addLog('编辑ID为' . $id . '的抽奖商品信息');

        return redirect('/admin/lottery_goods/index')->with('success', '编辑成功');
    }

}