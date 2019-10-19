<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/12
 * Time: 15:01
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLogController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);
            $createdAt = $request->get('time', '');

            $p = AdminLog::with('admin');

            // 筛选条件
            if ($soso) {
                $p->where(function ($query) use ($soso) {
                    $query->where('log', 'like', '%' . $soso . '%')->orwhere('ip', 'like', '%' . $soso . '%');
                });
            }

            if ($createdAt) {
                $time1 = substr($createdAt, 0, 10) . ' 00:00:00';
                $time2 = substr($createdAt, 13, 10) . ' 23:59:59';

                $p->where('created_at', '>=', $time1)->where('created_at', '<=', $time2);
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('created_at')->skip(($page - 1) * $limit)->take($limit);
            $data['data'] = $p->get()->toArray();

            foreach ($data['data'] as $k => $v) {
                $data['data'][$k]['name'] = $v['admin']['name'];
                unset($data['data'][$k]['admin']);
            }

            return response()->json($data);
        }

        return view('admin.admin_log.index');
    }

}