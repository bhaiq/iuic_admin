<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/15
 * Time: 17:06
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{

    protected $table = 'coin';

    protected $guarded = [];

    const COIN_TYPES = ['未确定', 'ERC20', 'omini', 'cosmos'];
    const STATUSES = ['正常', '维护中', '关闭'];
    const IS_LEGAL = ['否', '是'];

    public function scopeLegal($query)
    {
        return $query->where('is_legal', 1);
    }

    public function scopeNoLegal($query)
    {
        return $query->where('is_legal', 0);
    }

    public function getCoinTypesAttribute($value)
    {
        return array_values(json_decode($value, true) ?: []);
    }

    public function setCoinTypesAttribute($value)
    {
        $this->attributes['coin_types'] = json_encode(array_values($value));
    }

}