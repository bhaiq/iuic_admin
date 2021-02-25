<?php
//生态2积分余额日志表
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcologyCreaditsLog extends Model
{

    protected $table = 'ecology_creadits_log';

    protected $guarded = [];

    //日志类型
    public function getScenceAttribute($value) {
        $arr = [
        	'1'=>'购买积分',
        	'2'=>'积分划转',
        	'3'=>'生态2分享奖',
        	'4'=>'生态2团队长奖',
        	'5'=>'生态2合伙人奖',
        	'6'=>'生态2手续费团队长奖',
        	'7'=>'生态2手续费奖',
        	'8'=>'生态2手续费合伙人奖',
        ];
        return ['msg'=>$arr[$value],'value'=>$value];
    }

    //符号 +-
    public function getTypeAttribute($value) {
        $arr = [
        	'1'=>'+',
        	'2'=>'-',
        ];
        return ['msg'=>$arr[$value],'value'=>$value];
    }

    //资产
    public function getCoinTypeAttribute($value) {
        $arr = [
        	'1'=>'可用积分',
        	'2'=>'冻结积分',
        ];
        return ['msg'=>$arr[$value],'value'=>$value];
    }

    /*
	 * uid    用户id
     * amount 操作数量
     * type   1加2减
     * scence 场景
     * remark 备注
     * coin_type 1可用2冻结
	*/
    public static function addlog($uid,$amount,$type,$scence,$remark,$coin_type){
        $data = [
            'uid' => $uid,
            'amount' => $amount,
            'type' => $type,
            'scence' => $scence,
            'remark' => $remark,
            'coin_type' => $coin_type,
        ];

        EcologyCreaditsLog::create($data);

        \Log::info('增加一条积分变动记录', $data);

        return true;

    }

}