<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/15
 * Time: 16:09
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{

    protected $table = 'user_info';

    protected $guarded = [];

    const LEVEL_NAME = [
        0 => '无',
        1 => '普通',
        2 => '高级',
    ];

}