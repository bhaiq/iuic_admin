<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/9/19
 * Time: 10:48
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\Redis;

class UserPartner extends Model
{

    protected $table = 'user_partner';

    protected $guarded = [];

}