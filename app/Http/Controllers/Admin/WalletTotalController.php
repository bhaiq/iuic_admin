<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/8/19
 * Time: 18:06
 */

namespace App\Http\Controllers\Admin;

use App\Models\WalletCollect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletTotalController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = WalletCollect::from('wallet_collect as wc')
                ->select('wc.*');

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest()->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.wallet_collect.index');

    }

}