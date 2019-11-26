<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/3/26
 * Time: 15:50
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use App\Services\AliOss;
use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{

    public function upload(Request $request)
    {

        $request->validate([
            'type' => 'required',
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        if(!$file->isValid()){
            return returnJson(0, '数据有误');
        }

        switch ($request->get('type')) {

            case 'image':

                $fileName = 'files/' . date('YmdHis').rand(100000, 999999) . '.' . $file->getClientOriginalExtension();
//                return $fileName;
                AliOss::upload($fileName, $file->getRealPath(), $file->getClientMimeType(), false);

                $url = AliOss::getFileUrl($fileName);

                return returnJson(1, '上传成功', ['url' => $url]);

                break;

            default:

                return returnJson(0, '类型有误');
                break;

        }

    }

    // 后台发送短信
    public function send(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => '用户账号不能为空',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        // 验证用户名是否存在
        $au = AdminUser::where('name', $request->get('name'))->orwhere('email', $request->get('name'))->first();
        if(!$au){
            return returnJson(0, '账号不存在');
        }

        // 验证用户手机是否存在
        if(empty($au->mobile)){
            return returnJson(0, '该账户未绑定手机');
        }

        $sms = new SmsService();
        $res = $sms->send($au->mobile);
        if ($res['code'] != 1) {
            return returnJson(0, $res['msg']);
        }

        return returnJson(1, '发送成功');

    }

}