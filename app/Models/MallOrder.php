<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/10/10
 * Time: 15:09
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MallOrder extends Model
{

    protected $table = 'mall_order';

    protected $guarded = [];

    public function store()
    {
        return $this->hasOne(MallStore::class, 'id', 'store_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'uid');
    }

}