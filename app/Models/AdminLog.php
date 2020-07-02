<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/12
 * Time: 15:03
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{

    protected $table = 'admin_logs';

    protected $guarded = [];

    public function admin()
    {
        return $this->hasOne(AdminUser::class, 'id', 'admin_id');
    }

    // 添加管理员日志
    public static function addLog($log, $uid = null) {
        if(auth()->user()){
            $data = [
                'admin_id' => auth()->user()->id,
                'uid' => $uid,
                'log' => $log,
                'method' => request()->method(),
                'ip' => request()->ip(),
                'agent' => request()->header('user-agent'),
                'created_at' => now()->toDateTimeString()
            ];
            self::insert($data);
        }

    }

    public static function addLoginLog($log, $uid)
    {

        $data = [
            'admin_id' => $uid,
            'log' => $log,
            'method' => request()->method(),
            'ip' => request()->ip(),
            'agent' => request()->header('user-agent'),
            'created_at' => now()->toDateTimeString()
        ];
        self::insert($data);
    }

}