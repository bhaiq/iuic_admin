<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/3
 * Time: 16:09
 */

namespace App\Http\Controllers\Admin;

use App\Models\KuangjiLinghuo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KuangjiLinghuoController extends Controller
{

    // 灵活矿位列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = KuangjiLinghuo::from('kuangji_linghuo as kl')
                ->select('kl.*', 'u.mobile as mobile', 'a.name as realname')
                ->join('user as u', 'u.id', 'kl.uid')
                ->leftJoin('authentication as a', 'a.uid', 'kl.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            $p->latest('kl.id')->skip(($page - 1) * $limit)->take($limit);

            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.kuangji_linghuo.index');
    }


}