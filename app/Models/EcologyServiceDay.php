<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcologyServiceDay extends Model
{
    //
    protected $table = 'ecology_service_day';

    protected $guarded = [];

    //类型
    public function getSetStatusAttribute($value) {
        $arr = ['0'=>'未结算','1'=>'自动','2'=>'手动'];
        return ['msg'=>$arr[$value],'value'=>$value];
    }
}
