<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/20
 * Time: 14:33
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\Business;
use App\Models\Coin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{

    // 配置列表
    public function index()
    {

        $url1 = '/www/wwwroot/iuic.too86.com/config/extract.php';
        $url2 = '/www/wwwroot/iuic.too86.com/config/release.php';
        $url3 = '/www/wwwroot/iuic.too86.com/config/shop.php';
        $url4 = '/www/wwwroot/iuic.too86.com/config/trade.php';
        $url5 = '/www/wwwroot/iuic.too86.com/config/business.php';
        $url7 = '/www/wwwroot/iuic.too86.com/config/user_partner.php';
        $url8 = '/www/wwwroot/iuic.too86.com/config/kuangji.php';
        $url9 = '/www/wwwroot/iuic.too86.com/config/node.php';
        $url11 = '/www/wwwroot/iuic.too86.com/config/energy.php';
        $url12 = '/www/wwwroot/iuic.too86.com/config/recommend.php';

        $str1 = file_get_contents($url1);
        $str2 = file_get_contents($url2);
        $str3 = file_get_contents($url3);
        $str4 = file_get_contents($url4);
        $str5 = file_get_contents($url5);
        $str7 = file_get_contents($url7);
        $str8 = file_get_contents($url8);
        $str9 = file_get_contents($url9);
        $str11 = file_get_contents($url11);
        $str12 = file_get_contents($url12);

        $arr1 = eval(substr($str1, strpos($str1, 'return')));
        $arr2 = eval(substr($str2, strpos($str2, 'return')));
        $arr3 = eval(substr($str3, strpos($str3, 'return')));
        $arr4 = eval(substr($str4, strpos($str4, 'return')));
        $arr5 = eval(substr($str5, strpos($str5, 'return')));
        $arr7 = eval(substr($str7, strpos($str7, 'return')));
        $arr8 = eval(substr($str8, strpos($str8, 'return')));
        $arr9 = eval(substr($str9, strpos($str9, 'return')));
        $arr11 = eval(substr($str11, strpos($str11, 'return')));
        $arr12 = eval(substr($str12, strpos($str12, 'return')));

        $arr6 = config('reward');
        $arr10 = config('admin_mall');

        $data = [];

        if(is_array($arr1)){
            foreach ($arr1 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr2)){
            foreach ($arr2 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr3)){
            foreach ($arr3 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr4)){
            foreach ($arr4 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr5)){
            foreach ($arr5 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr6)){
            foreach ($arr6 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr7)){
            foreach ($arr7 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr8)){
            foreach ($arr8 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr9)){
            foreach ($arr9 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr10)){
            foreach ($arr10 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr11)){
            foreach ($arr11 as $k => $v){
                $data[$k] = $v;
            }
        }

        if(is_array($arr12)){
            foreach ($arr12 as $k => $v){
                $data[$k] = $v;
            }
        }

        $data['coin_arr'] = Coin::get()->toArray();
        $data['coin_type_arr'] = Business::COIN_TYPE;

        return view('admin.config.index', $data);

    }

    // 更新配置
    public function update(Request $request)
    {

        $url1 = '/www/wwwroot/iuic.too86.com/config/extract.php';
        $url2 = '/www/wwwroot/iuic.too86.com/config/release.php';
        $url3 = '/www/wwwroot/iuic.too86.com/config/shop.php';
        $url4 = '/www/wwwroot/iuic.too86.com/config/trade.php';
        $url5 = '/www/wwwroot/iuic.too86.com/config/business.php';
        $url7 = '/www/wwwroot/iuic.too86.com/config/user_partner.php';
        $url8 = '/www/wwwroot/iuic.too86.com/config/kuangji.php';
        $url9 = '/www/wwwroot/iuic.too86.com/config/node.php';
        $url11 = '/www/wwwroot/iuic.too86.com/config/energy.php';
        $url12 = '/www/wwwroot/iuic.too86.com/config/recommend.php';

        $str1 = file_get_contents($url1);
        $str2 = file_get_contents($url2);
        $str3 = file_get_contents($url3);
        $str4 = file_get_contents($url4);
        $str5 = file_get_contents($url5);
        $str7 = file_get_contents($url7);
        $str8 = file_get_contents($url8);
        $str9 = file_get_contents($url9);
        $str11 = file_get_contents($url11);
        $str12 = file_get_contents($url12);

        $arr1 = eval(substr($str1, strpos($str1, 'return')));
        $arr2 = eval(substr($str2, strpos($str2, 'return')));
        $arr3 = eval(substr($str3, strpos($str3, 'return')));
        $arr4 = eval(substr($str4, strpos($str4, 'return')));
        $arr5 = eval(substr($str5, strpos($str5, 'return')));
        $arr7 = eval(substr($str7, strpos($str7, 'return')));
        $arr8 = eval(substr($str8, strpos($str8, 'return')));
        $arr9 = eval(substr($str9, strpos($str9, 'return')));
        $arr11 = eval(substr($str11, strpos($str11, 'return')));
        $arr12 = eval(substr($str12, strpos($str12, 'return')));

        $arr6 = config('reward');
        $arr10 = config('admin_mall');

        \Log::info('修改前数据', [$arr1, $arr2, $arr3, $arr4, $arr5, $arr6, $arr7, $arr8, $arr9, $arr10, $arr11, $arr12]);

        if(is_array($arr1)){
            foreach ($arr1 as $k => $v){

                if($request->has($k)){
                    $arr1[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr1,true).";";
            file_put_contents($url1, $text);

        }

        if(is_array($arr2)){
            foreach ($arr2 as $k => $v){

                if($request->has($k)){
                    $arr2[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr2,true).";";
            file_put_contents($url2, $text);

        }

        if(is_array($arr3)){
            foreach ($arr3 as $k => $v){

                if($request->has($k)){
                    $arr3[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr3,true).";";
            file_put_contents($url3, $text);

        }

        if(is_array($arr4)){
            foreach ($arr4 as $k => $v){

                if($request->has($k)){
                    $arr4[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr4,true).";";
            file_put_contents($url4, $text);

        }

        if(is_array($arr5)){
            foreach ($arr5 as $k => $v){

                if($request->has($k)){
                    $arr5[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr5,true).";";
            file_put_contents($url5, $text);

        }

        if(is_array($arr6)){
            foreach ($arr6 as $k => $v){

                if($request->has($k)){
                    $arr6[$k] = $request->get($k);
                }

            }

            $url6 = config_path('reward').".php";//路径
            $text = "<?php return ".var_export($arr6,true).";";
            file_put_contents($url6, $text);

        }

        if(is_array($arr7)){
            foreach ($arr7 as $k => $v){

                if($request->has($k)){
                    $arr7[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr7,true).";";
            file_put_contents($url7, $text);

        }

        if(is_array($arr8)){
            foreach ($arr8 as $k => $v){

                if($request->has($k)){
                    $arr8[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr8,true).";";
            file_put_contents($url8, $text);

        }

        if(is_array($arr9)){
            foreach ($arr9 as $k => $v){

                if($request->has($k)){
                    $arr9[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr9,true).";";
            file_put_contents($url9, $text);

        }

        if(is_array($arr10)){
            foreach ($arr10 as $k => $v){

                if($request->has($k)){
                    $arr10[$k] = $request->get($k);
                }

            }

            $url10 = config_path('admin_mall').".php";//路径
            $text = "<?php return ".var_export($arr10,true).";";
            file_put_contents($url10, $text);

        }

        if(is_array($arr11)){
            foreach ($arr11 as $k => $v){

                if($request->has($k)){
                    $arr11[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr11,true).";";
            file_put_contents($url11, $text);

        }

        if(is_array($arr12)){
            foreach ($arr12 as $k => $v){

                if($request->has($k)){
                    $arr12[$k] = $request->get($k);
                }

            }

            $text = "<?php return ".var_export($arr12,true).";";
            file_put_contents($url12, $text);

        }

        \Log::info('修改后数据', [$arr1, $arr2, $arr3, $arr4, $arr5, $arr6, $arr7, $arr8, $arr9, $arr10, $arr11, $arr12]);

        AdminLog::addLog('修改了配置');

        \Log::info('修改了配置信息', $request->all());

        return returnJson(1, '操作成功');
    }

}