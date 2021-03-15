<?php
//生态2积分余额表
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcologyCreadits extends Model
{

    protected $table = 'ecology_creadits';

    protected $guarded = [];

    //是否复投过
    public function getPuralAttribute()
    {
        //$this->amount
        $num = EcologyCreadits::where('uid',$this->uid)->count();
        if($num > 1){
            return "复投";
        }else{
            return "新增";
        }
    }

}