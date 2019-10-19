<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/31
 * Time: 15:09
 */

namespace App\Http\Controllers\Admin;

use App\Models\InfoCollect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfoCollectController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = InfoCollect::from('info_collect as ic');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('cur_date', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            if($limit == 9999){
                $p->latest('created_at');
            }else{
                $p->latest('created_at')->skip(($page - 1) * $limit)->take($limit);
            }

            $data['data'] = $p->get()->toArray();


            return response()->json($data);
        }

        return view('admin.info_collect.index');
    }

}