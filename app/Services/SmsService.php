<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/3/14
 * Time: 16:47
 */

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Mrgoon\AliSms\AliSms;

class SmsService
{
    private $cacheKey = 'TEL_%s_YZM';

    /**
     * 验证验证码
     * @param $mobile
     * @param $captcha
     * @return array
     */
    public function check($mobile, $captcha)
    {

        // 测试的时候验证
        /*if($captcha == '1234'){
            return [
                'code' => 1,
                'msg' => '验证成功'
            ];
        }*/

        $cacheKey = sprintf($this->cacheKey, $mobile);

        // 检查验证码有木有存在
        if(!Cache::has($cacheKey)){
            return [
                'code' => 0,
                'msg' => '验证码不存在'
            ];
        }

        if(Cache::get($cacheKey) != $captcha){
            return [
                'code' => 0,
                'msg' => '验证码不正确'
            ];
        }

        // 删除缓存
        Cache::forget($cacheKey);

        return [
            'code' => 1,
            'msg' => '验证成功'
        ];

    }

    /**
     * 发送验证码类型的短信
     * @param $mobile
     * @return array
     */
    public function send($mobile, $countryCode = '86')
    {

        $cacheKey = sprintf($this->cacheKey, $mobile);
        $captcha = rand(1000, 9999);

        $template = config('aliyunsms.template');

         // 阿里云发送短信
        $aliSms = new AliSms();
        // $response = $aliSms->sendSms($mobile, $template, ['yzm'=> $captcha]);
        $response = $aliSms->sendSms($mobile, $template, ['code'=> $captcha]);

        // \Log::info('cs', ['mobile' => $mobile,'template'=>$template]);
        \Log::info('阿里云返回的数据', ['data' => $response]);
        if($response->Code != 'OK'){
            return [
                'code' => 0,
                'msg' => '短信发送失败'
            ];
        }

        // 发送完成把验证码写进缓存
        Cache::put($cacheKey, $captcha, 300);

        return [
            'code' => 1,
            'msg' => '发送成功'
        ];

    }

}