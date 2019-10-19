<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/15
 * Time: 17:07
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{

    protected $table = 'authentication';

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'uid');
    }


}