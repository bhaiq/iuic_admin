<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/24
 * Time: 17:51
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\StarCommunity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StarCommunityController extends Controller
{

    protected $fields = [
        'name' => '',
        'price' => '',
        'star_bl' => '',
        // 'pledge_bl' => '',
    ];

    // 星级社群列表
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            // $p = StarCommunity::from('star_communities');
            $p = new StarCommunity;

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('id')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.star_community.index');
    }

    // 修改星级社群
    public function edit($id)
    {
        $b = StarCommunity::find((int)$id);
        if (!$b) return redirect('/admin/star_community/index');

        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $b->$field);
        }

        $data['id'] = (int)$id;
        $data['name'] = $b['name'];
        $data['price'] = $b['price'];
        $data['star_bl'] = $b['star_bl'];
        // $data['id'] = (int)$id;

        return view('admin.star_community.edit', $data);
    }

    // 更新星级社群
    public function update(Request $request, $id)
    {

        $b = StarCommunity::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $b->$field = $request->get($field);
        }
        // dd($b);
        $b->save();

        AdminLog::addLog('修改了ID为' . $id . '的星级社群信息');

        return redirect('/admin/star_community/index')->with('success', '修改成功');
    }

    //删除质押级别
    public function destroy($id)
    {

        if (PledgeLevel::where('id', $id)->delete()) {

            AdminLog::addLog('删除了ID为' . $id . '的质押级别');

            return returnJson(1, '删除成功');
        }

        return returnJson(0, '删除失败');
    }

}
