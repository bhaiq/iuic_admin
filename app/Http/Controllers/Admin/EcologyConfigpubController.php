<?php
//生态2公共配置
namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EcologyConfigPub;
use App\Models\EcologyCarLogs;

class EcologyConfigpubController extends Controller
{
    // 配置列表
    public function index()
    {
        $arr1 = EcologyConfigPub::find(1)->toArray();
        // dd($arr1);
        $data = [];

        if(is_array($arr1)){
            foreach ($arr1 as $k => $v){
                $data[$k] = $v;
            }
        }

        // dump($data);
        return view('admin.ecology_configpub.index', $data);

    }

    // 更新配置
    public function update(Request $request)
    {
        if($request->has('car_surplus_sub')){
            $car_surplus_change = $request->get('car_surplus_change');//数量
            $car_surplus_addcut = $request->get('car_surplus_addcut');//+-

            \DB::beginTransaction();
            try {
                //+-车奖
                if ($car_surplus_addcut == "+") {
                    //+
                    EcologyConfigPub::where('id',1)->increment('car_surplus',$car_surplus_change);
                }else{
                    //-
                    EcologyConfigPub::where('id',1)->decrement('car_surplus',$car_surplus_change);
                }

                //车奖记录
                EcologyCarLogs::addLog('系统操作',$car_surplus_addcut,$car_surplus_change,'2');

                \DB::commit();
            } catch (\Exception $exception) {
                \DB::rollBack();
                \Log::info('加减累计车奖异常');

                return returnJson(0, '操作失败');
            }

            AdminLog::addLog('累计车奖'.$car_surplus_addcut.$car_surplus_change);
            return returnJson(1, '操作成功');
        }else{
            
            $arr1 = EcologyConfigPub::find(1)->toArray();
            \Log::info('修改前数据', $arr1);

            $data = [];
            if(is_array($arr1)){
                foreach ($arr1 as $k => $v){

                    if($request->has($k)){
                        $data[$k] = $request->get($k);
                    }

                }
                EcologyConfigPub::where('id',1)->update($data);

            }

            \Log::info('修改后数据', $arr1);

            AdminLog::addLog('修改了生态2公共配置');

            \Log::info('修改了生态2公共配置', $request->all());
        }

        return returnJson(1, '操作成功');
    }

}