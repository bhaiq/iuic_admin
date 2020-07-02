<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/31
 * Time: 10:52
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoldCoin extends Model
{

    protected $table = 'hold_coin';

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'uid');
    }

}