<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/17
 * Time: 15:23
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{

    protected $table = 'banner';

    protected $guarded = [];

    const TYPES = [
        '单图片',
        '跳转内部',
        '跳转外部'
    ];

    const JUMP_TYPE = [
        '跳转分享页面'
    ];

}