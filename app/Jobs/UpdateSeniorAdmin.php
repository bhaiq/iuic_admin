<?php

namespace App\Jobs;

use App\Models\SeniorAdmin;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateSeniorAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        \Log::info('=====  开始更新用户高级管理奖  =====');

        $this->toUpdate($this->uid);

        \Log::info('=====  结束更新用户高级管理奖  =====');

    }

    private function toUpdate($uid)
    {

        \Log::info('进来的数据更新高级管理奖的数据', ['uid' => $uid]);

        // 获取用户信息
        $user = User::find($uid);
        if(!$user){
            \Log::info('用户信息有误，结束');
            return false;
        }

        // 获取用户高级管理奖信息
        $sa = SeniorAdmin::where(['uid' => $uid, 'status' => 1])->first();
        if(!$sa){
            \Log::info('用户没有管理奖信息，跳过');
            return $this->toUpdate($user->pid);
        }

        // 判断用户级别是否是3星
        if($sa->type >= 3){
            \Log::info('已经到达最高级，跳过');
            return $this->toUpdate($user->pid);
        }

        // 获取用户同级别的数量
        $sameLevelCount = SeniorAdmin::getUserLineCount($uid, $sa->type);

        if($sa->type == 1 && $sameLevelCount < 2){
            \Log::info('推荐的1星用户不够，跳过', ['count' => $sameLevelCount]);
            return $this->toUpdate($user->pid);
        }

        if($sa->type == 2 && $sameLevelCount < 3){
            \Log::info('推荐的2星用户不够，跳过', ['count' => $sameLevelCount]);
            return $this->toUpdate($user->pid);
        }

        // 用户级别升一级
        SeniorAdmin::where('uid', $uid)->increment('type');

        return $this->toUpdate($uid);

    }

}
