<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/16
 * Time: 18:14
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\Coin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CoinController extends Controller
{

    protected $fields = [
        'name' => '',
        'is_legal' => '',
        'status' => '',
        'coin_types' => '',
    ];

    // 币种设置
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = Coin::from('coin as c');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('name', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            foreach ($data['data'] as $k => $v) {

                $data['data'][$k]['coin_info'] = '';

                if (is_array($v['coin_types'])) {

                    foreach ($v['coin_types'] as $key => $val) {

                        $data['data'][$k]['coin_info'] .= '币种类型:' . Coin::COIN_TYPES[$val['coin_type']] . '  地址:' . $val['value'] . '<br>';

                    }

                }

            }

            return response()->json($data);
        }

        return view('admin.coin.index');

    }

    //新增币种
    public function create(Request $request)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        $data['status_arr'] = Coin::STATUSES;
        $data['is_legal_arr'] = Coin::IS_LEGAL;
        $data['coin_types_arr'] = Coin::COIN_TYPES;

        return view('admin.coin.create', $data);
    }

    //添加币种
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_legal' => 'required',
            'status' => 'required',
            'coin_type_arr' => 'required',
            'value_arr' => 'required',
        ], [
            'name.required' => '名称不能为空',
            'is_legal.required' => '是否法币不能为空',
            'status.required' => '状态不能为空',
            'coin_type_arr.required' => '币种不能为空',
            'value_arr.required' => '合约值不能为空',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        // 判断币种信息是否为空
        if (!is_array($request->get('coin_type_arr')) || count($request->get('coin_type_arr')) <= 0) {
            return returnJson(0, '币种信息不能为空');
        }

        // 判断币种信息是否为空
        if (!is_array($request->get('value_arr')) || count($request->get('value_arr')) <= 0) {
            return returnJson(0, '币种信息合约值不能为空');
        }

        $coinTypeArr = $request->get('coin_type_arr');
        $valueArr = $request->get('value_arr');
        $keys = [];
        $coin_types = [];
        for ($i = 0; $i < count($coinTypeArr); $i++) {

            if(isset($coinTypeArr[$i]) && !empty(trim($coinTypeArr[$i])) && isset($valueArr[$i]) && !empty(trim($valueArr[$i]))){

                if(!in_array($coinTypeArr[$i], $keys)){

                    $coin_types[] = [
                        'coin_type' => $coinTypeArr[$i],
                        'value' => $valueArr[$i],
                    ];

                    $keys[] = $coinTypeArr[$i];

                }

            }

        }

        $cData = [
            'name' => $request->get('name'),
            'is_legal' => $request->get('is_legal'),
            'status' => $request->get('status'),
            'coin_types' => $coin_types,
            'created_at' => now()->toDateTimeString()
        ];

        Coin::create($cData);

        AdminLog::addLog('新增币种');

        return returnJson(1, '新增成功');

    }

    //修改币种
    public function edit($id)
    {
        $sg = Coin::find((int)$id);
        if (!$sg) return redirect('/admin/coin')->with('fail', '数据有误');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $sg->$field);
        }

        $data['status_arr'] = Coin::STATUSES;
        $data['is_legal_arr'] = Coin::IS_LEGAL;
        $data['coin_types_arr'] = Coin::COIN_TYPES;
        $data['id'] = $id;

        return view('admin.coin.edit', $data);

    }

    //更新币种
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_legal' => 'required',
            'status' => 'required',
            'coin_type_arr' => 'required',
            'value_arr' => 'required',
        ], [
            'name.required' => '名称不能为空',
            'is_legal.required' => '是否法币不能为空',
            'status.required' => '状态不能为空',
            'coin_type_arr.required' => '币种不能为空',
            'value_arr.required' => '合约值不能为空',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        // 判断数据是否正确
        $coin = Coin::find($id);
        if(!$coin){
            return returnJson(0, '数据有误');
        }

        // 判断币种信息是否为空
        if (!is_array($request->get('coin_type_arr')) || count($request->get('coin_type_arr')) <= 0) {
            return returnJson(0, '币种信息不能为空');
        }

        // 判断币种信息是否为空
        if (!is_array($request->get('value_arr')) || count($request->get('value_arr')) <= 0) {
            return returnJson(0, '币种信息合约值不能为空');
        }

        $coinTypeArr = $request->get('coin_type_arr');
        $valueArr = $request->get('value_arr');
        $keys = [];
        $coin_types = [];
        for ($i = 0; $i < count($coinTypeArr); $i++) {

            if(isset($coinTypeArr[$i]) && !empty(trim($coinTypeArr[$i])) && isset($valueArr[$i]) && !empty(trim($valueArr[$i]))){

                if(!in_array($coinTypeArr[$i], $keys)){

                    $coin_types[] = [
                        'coin_type' => $coinTypeArr[$i],
                        'value' => $valueArr[$i],
                    ];

                    $keys[] = $coinTypeArr[$i];

                }

            }

        }

        $coin->name = $request->get('name');
        $coin->is_legal = $request->get('is_legal');
        $coin->status = $request->get('status');
        $coin->coin_types = $coin_types;
        $coin->save();

        AdminLog::addLog('更新交易对');

        return returnJson(1, '编辑成功');
    }

    //删除币种
    public function destroy($id)
    {

        $c = Coin::find((int)$id);
        if (!$c) {
            return returnJson(0, '数据有误');
        }

        $c->delete();

        AdminLog::addLog('删除ID为' . $id . '的交易对');

        return returnJson(1, '删除成功');
    }
}