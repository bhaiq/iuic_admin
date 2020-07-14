<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2020/3/10
 * Time: 11:26
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RobotConfigController extends Controller
{

    // 配置列表
    public function index()
    {

        $url1 = '/www/wwwroot/iuic.too86.com/config/robot.php';
//        $url1 = '/www/wwwroot/iuic.9dg.com/config/robot.php';
        $str1 = file_get_contents($url1);
        $arr1 = eval(substr($str1, strpos($str1, 'return')));


        $data = [];

        if(is_array($arr1)){
            foreach ($arr1 as $k => $v){
                $data[$k] = $v;
            }
        }

        return view('admin.robot_config.index', $data);

    }

    // 更新配置
    public function update(Request $request)
    {

        $url1 = '/www/wwwroot/iuic.too86.com/config/robot.php';
//        $url1 = '/www/wwwroot/iuic.9dg.com/config/robot.php';

        $str1 = file_get_contents($url1);

        $arr1 = eval(substr($str1, strpos($str1, 'return')));


        \Log::info('修改前数据', [$arr1]);

        if(is_array($arr1)){
            foreach ($arr1 as $k => $v){

                if($request->has($k)){
                    $arr1[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr1,true).";";
            file_put_contents($url1, $text);

        }

        \Log::info('修改后数据', [$arr1]);

        AdminLog::addLog('修改了机器人配置');

        \Log::info('修改了配置信息', $request->all());

        return returnJson(1, '操作成功');
    }

}