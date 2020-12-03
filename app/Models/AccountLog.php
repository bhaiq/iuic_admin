<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/16
 * Time: 10:40
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model
{

    protected $table = 'account_log';

    protected $guarded = [];

    public static function addLog($uid, $coinId, $amount, $scene, $type, $coinType, $remark = '', $extend = '[]')
    {

        $data = [
            'uid' => $uid,
            'coin_id' => $coinId,
            'amount' => $amount,
            'scene' => $scene,
            'type' => $type,
            'coin_type' => $coinType,
            'remark' => $remark,
            'extend' => $extend
        ];

        AccountLog::create($data);

        \Log::info('增加一条用户币种余额日志', $data);

        return true;

    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','uid','id');
    }

    public function coin()
    {
        return $this->belongsTo('App\Models\Coin','coin_id','id');
    }

    public function authentication()
    {
        return $this->belongsTo('App\Models\Authentication','uid','uid');
    }

}