<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/24
 * Time: 11:12
 */

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRelationController extends Controller
{

    //推荐关系查询
    public function index(Request $request)
    {

        if($request->isMethod('POST')){

            $pid = $request->get('pid');

            $data = User::with(['user_info', 'user_auth'])->where('pid', $pid)->get()->toArray();

            foreach ($data as $k => $v){

                if(isset($v['user_info']) && isset($v['user_info']['level'])){

                    $levelName = UserInfo::LEVEL_NAME[$v['user_info']['level']];
                    $isBonus = $v['user_info']['is_bonus'] == 1 ? '节点' : '非节点';
                    $isAdmin = $v['user_info']['is_admin'] == 1 ? '管理' : '非管理';

                }else{

                    $levelName = '无';
                    $isBonus = '非节点';
                    $isAdmin = '非管理';

                }

                if(isset($v['user_auth']) && isset($v['user_auth']['name'])){
                    $data[$k]['nickname'] = $v['user_auth']['name'];
                }

                $data[$k]['num'] = User::where('pid', $v['id'])->count();
                $data[$k]['level_name'] = $levelName;
                $data[$k]['is_bonus'] = $isBonus;
                $data[$k]['is_admin'] = $isAdmin;

            }

            return returnJson(1, '查询成功', $data);

        }

        $soso = $request->get('soso');

        if($soso){
            $data = User::with(['user_info', 'user_auth'])->where('mobile', $soso)->get();
        }else{
            $data = User::with(['user_info', 'user_auth'])->where('pid',0)->get();
        }

        foreach ($data as $k => $v){

            if(isset($v['user_info']) && isset($v['user_info']['level'])){
                $levelName = UserInfo::LEVEL_NAME[$v['user_info']['level']];
                $isBonus = $v['user_info']['is_bonus'] == 1 ? '节点' : '非节点';
                $isAdmin = $v['user_info']['is_admin'] == 1 ? '管理' : '非管理';
            }else{
                $levelName = '无';
                $isBonus = '非节点';
                $isAdmin = '非管理';
            }

            if(isset($v['user_auth']) && isset($v['user_auth']['name'])){
                $data[$k]['nickname'] = $v['user_auth']['name'];
            }

            $data[$k]['num'] = User::where('pid', $v['id'])->count();
            $data[$k]['level_name'] = $levelName;
            $data[$k]['is_bonus'] = $isBonus;
            $data[$k]['is_admin'] = $isAdmin;

        }

        return view('admin.user_relation.index', ['data' => $data, 'soso' => $soso]);

    }

}