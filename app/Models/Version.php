<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/19
 * Time: 10:19
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{

    protected $table = 'version';

    protected $guarded = [];

    public function getRemarkAttribute($value)
    {

        $arr = json_decode($value, true);

        if(is_array($arr)){
            return $arr['zh'] ?? '';
        }

        return '';
    }

}