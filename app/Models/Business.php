<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/20
 * Time: 10:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{

    protected $table = 'auth_business';

    protected $guarded = [];

    const COIN_TYPE = ['币币', '法币'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'uid');
    }

}