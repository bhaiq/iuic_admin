<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/15
 * Time: 17:07
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    protected $table = 'account';

    protected $guarded = [];

    const TYPE_CC = 0;
    const TYPE_LC = 1;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'uid');
    }

    public function coin()
    {
        return $this->hasOne(Coin::class, 'id', 'coin_id');
    }

    // 用户账户余额递减
    public static function reduceAmount($uid, $coinId, $num, $type = Account::TYPE_LC)
    {

        Account::where(['uid' => $uid, 'coin_id' => $coinId, 'type' => $type])->decrement('amount', $num);

        \Log::info('ID为' . $uid . '用户ID为' . $coinId . '的币种数量减少' . $num, ['type' => $type]);

        return true;

    }

    // 用户账户余额递增
    public static function addAmount($uid, $coinId, $num, $type = Account::TYPE_LC)
    {

        Account::where(['uid' => $uid, 'coin_id' => $coinId, 'type' => $type])->increment('amount', $num);

        \Log::info('ID为' . $uid . '用户ID为' . $coinId . '的币种数量增加' . $num, ['type' => $type]);

        return true;

    }

    // 用户账户余额增加冻结
    public static function addFrozen($uid, $coinId, $num, $type = Account::TYPE_LC)
    {

        Account::where(['uid' => $uid, 'coin_id' => $coinId, 'type' => $type])->increment('amount_freeze', $num);

        \Log::info('ID为' . $uid . '用户ID为' . $coinId . '的币种冻结数量增加' . $num, ['type' => $type]);

        return true;

    }

    // 用户账户余额减少冻结
    public static function reduceFrozen($uid, $coinId, $num, $type = Account::TYPE_LC)
    {

        Account::where(['uid' => $uid, 'coin_id' => $coinId, 'type' => $type])->decrement('amount_freeze', $num);

        \Log::info('ID为' . $uid . '用户ID为' . $coinId . '的币种冻结数量减少' . $num, ['type' => $type]);

        return true;

    }

}