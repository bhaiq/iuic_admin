<?php

// 返回数据
function returnJson($code = '', $msg = '', $data = [])
{
    $returnArr['code'] = $code;
    $returnArr['msg'] = $msg;
    $returnArr['data'] = $data;
    return response()->json($returnArr);
}

// Curl请求
function sendCurl($url, $data = [])
{

    $curl = curl_init();  // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $res = curl_exec($curl);

    if (curl_errno($curl)) {
        return [
            'code' => 0,
            'msg' => '请求出错'
        ];
    }
    curl_close($curl);

    return json_decode($res, true);

}

// 取随机字符串
function getRandCode($num = 40)
{
    $array = array('A', 'B', 'C', 'D', 'E', 'F', 'a', 'b', 'c', 'd', 'e', 'f', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $tmpstr = '';
    $max = count($array);
    for ($i = 1; $i <= $num; $i++) {
        $key = rand(0, $max - 1);
        $tmpstr .= $array[$key];
    }
    return $tmpstr;
}

// 密码加密
function password($string)
{
    return sha1(md5($string) . env('APP_KEY'));
}