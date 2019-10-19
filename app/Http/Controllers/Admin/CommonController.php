<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/3/26
 * Time: 15:50
 */

namespace App\Http\Controllers\Admin;

use App\Services\AliOss;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

}