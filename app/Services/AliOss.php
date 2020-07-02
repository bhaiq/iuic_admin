<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/6
 * Time: 10:14
 */
namespace App\Services;

use JohnLui\AliyunOSS;

class AliOss
{

    public $ossClient;

    public function __construct($isInternal = false)
    {
        $serverAddress = $isInternal ? config('alioss.ossServerInternal') : config('alioss.ossServer');
        $this->ossClient = AliyunOSS::boot(
            '香港',
            '经典网络',
            $serverAddress,
            config('alioss.AccessKeyId'),
            config('alioss.AccessKeySecret')
        );

    }

    // 默认上传文件使用内网，免流量费
    public static function upload($ossKey, $filePath, $fileType,$isInternal = true)
    {
        $oss = new AliOss($isInternal);
        $oss->ossClient->setBucket(config('alioss.bucket'));
        $oss->ossClient->uploadFile($ossKey, $filePath, ['ContentType' => $fileType]);

    }

    public static function getFileUrl($ossKey)
    {
        $oss = new AliOss();
        $oss->ossClient->setBucket(config('alioss.bucket'));
        return $oss->ossClient->getPublicUrl($ossKey);
    }

}