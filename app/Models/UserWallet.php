<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/12/18
 * Time: 10:13
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{

    protected $table = 'user_wallet';

    protected $guarded = [];

    // 验证用户余额是否充足
    public static function checkWallet($uid, $num)
    {

        $uw = UserWallet::where('uid', $uid)->first();
        if(!$uw || $uw->energy_num < $num){
            return 0;
        }

        return 1;

    }

    // 能量资产增加
    public static function addEnergyNum($uid, $num)
    {
        UserWallet::where('uid', $uid)->increment('energy_num', $num);

        \Log::info('用户' . $uid . '的能量数量增加' . $num);

        return true;
    }

    // 能量资产减少
    public static function reduceEnergyNum($uid, $num)
    {
        UserWallet::where('uid', $uid)->decrement('energy_num', $num);

        \Log::info('用户' . $uid . '的能量数量减少' . $num);

        return true;
    }


}