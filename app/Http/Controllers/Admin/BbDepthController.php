<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/8/17
 * Time: 14:51
 */

namespace App\Http\Controllers\Admin;

use App\Models\ExOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BbDepthController extends Controller
{

    // 币币深度
    public function index(Request $request)
    {

        $type = $request->get('type', 0);

        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $p = ExOrder::from('ex_order as eo')
                ->select('price', DB::raw('sum(amount_lost) as amount_total'))
                ->where('team_id', 1)
                ->where('type', $type)
                ->where('status', 0)
                ->groupBy('price');

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->get()->count();

            $p->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.bb_depth.index', ['type' => $type]);
    }

}