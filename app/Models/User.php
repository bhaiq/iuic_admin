<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'user';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function (User $model) {
            $model->update([
                'invite_code' => strtoupper(base_convert(substr(time() * 1.3, 0, 6) + $model->id, 10, 36)),
            ]);
            $coins = Coin::all()->pluck('coin_type', 'id')->toArray();

            $account = [];
            foreach ($coins as $coin => $coin_type) {
                $account[] = ['uid' => $model->id, 'coin_id' => $coin, 'created_at' => now()->toDateTimeString(), 'type' => 0];
                $account[] = ['uid' => $model->id, 'coin_id' => $coin, 'created_at' => now()->toDateTimeString(), 'type' => 1];
            }

            Account::insert($account);

        });
    }

    public function user_info()
    {
        return $this->hasOne(UserInfo::class, 'uid', 'id');
    }

    public function user_auth()
    {
        return $this->hasOne(Authentication::class, 'uid', 'id');
    }

}