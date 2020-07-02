<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/9/7
 * Time: 16:57
 */

namespace App\Http\Controllers\Admin;

use App\Models\ShopTotal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BdTotalController extends Controller
{

    // 报单统计
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = ShopTotal::from('shop_total');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('cur_date', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('created_at')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.bd_total.index');
    }

}