<?php
//车奖记录表
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcologyCarLogs extends Model
{

    protected $table = 'ecology_car_logs';

    protected $guarded = [];

    /*
	    uid    		用户ID
		dy_table  	对应表
		dy_id  		对应表ID
		exp  		日志说明
		sign  		增减 + -
		num  		数量
		type 		日志类型 1积分充值 2系统操作(后台)
		dy_uid 		对应用户ID
	*/
    public static function addLog($exp,$sign,$num,$type,$uid=null,$dy_table=null,$dy_id=null,$dy_uid=null)
    {
        $data = [
            'uid' => $uid,
            'dy_table' => $dy_table,
            'dy_id' => $dy_id,
            'exp' => $exp,
            'sign' => $sign,
            'num' => $num,
            'type' => $type,
            'dy_uid' => $dy_uid,
        ];

        EcologyCarLogs::create($data);

        \Log::info('增加一条车奖记录', $data);

        return true;

    }
}