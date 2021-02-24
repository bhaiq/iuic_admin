<?php
//日全网新增业绩结算表
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcologyCreaditsDay extends Model
{

    protected $table = 'ecology_creadits_day';

    protected $guarded = [];

    //类型
    public function getSetStatusAttribute($value) {
        $arr = ['0'=>'未结算','1'=>'自动','2'=>'手动'];
        return ['msg'=>$arr[$value],'value'=>$value];
    }

}