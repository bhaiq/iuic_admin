<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\CommunityDividend;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommunityDivController extends Controller
{
    //
    protected $fields = [
        'new_account' => '',
        'this_month' => '',
        'uid'=> '',
        'last_month'=> '',
        'true_num'=> '',
        'total'=> '',
    ];

    // 用户业绩列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = CommunityDividend::from('community_dividends as c')
                ->select('c.*', 'u.new_account')
                ->orderby('id','desc')
                ->leftJoin('user as u', 'u.id', 'c.uid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('u.new_account', 'like', '%' . $soso . '%');
                });
            }

            $data['code'] = 0;
            $data['msg'] = '查询成功';
            $data['count'] = $p->count();

            if($limit == 9999){
                $p->latest();
            }else{
                $p->latest()->skip(($page - 1) * $limit)->take($limit);
            }

            $data['data'] = $p->get()->toArray();

            return response()->json($data);
        }

        return view('admin.community_div.index');

    }
    //新增用户业绩
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        return view('admin.community_div.create', $data);
    }

    //添加用户业绩
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_account' => 'required',
            'this_month' => 'required||numeric',
        ], [
            'new_account.required' => '用户账号不能为空',
            'this_month.required' => '业绩不能为空',
            'this_month.numeric' => '业绩为数字',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }
        $com = new CommunityDividend();
        $user = User::where('new_account',$request->get('new_account'))->first();
        if(empty($user)){
            return returnJson(0, '数据错误');
        }
        $is_has = CommunityDividend::where('uid',$user->id)->first();
        if(!empty($is_has)){
            return returnJson(0, '该用户已存在业绩');
        }
        $com->uid = $user->id;
        $com->last_month = "0";
        $com->this_month = "0";
        $com->true_num = "0";
        $com->total = $request->get('this_month');
        $com->save();
        AdminLog::addLog('新增用户业绩');

        return returnJson(1, '新增成功');
    }

    // 业绩异步操作
    public function ajax(Request $request)
    {

        $id = $request->get('id');
        $a = CommunityDividend::find($id);
        if(!$a){
            return returnJson(0, '数据有误');
        }

        if($request->isMethod('POST')){

            $validator = Validator::make($request->all(), [
                'type' => 'required|in:1,2',
                'num' => 'required|numeric',
            ], [
                'type.required' => '类型不能为空',
                'type.in' => '类型格式不正确',
                'num.required' => '数量不能为空',
                'num.numeric' => '数量格式不正确',
            ]);

            if ($validator->fails()) {
                return returnJson(0, $validator->errors()->first());
            }

            \DB::beginTransaction();
            try {
                // 用户增加或减少业绩
                if($request->get('type') == 1){

                    // 记录管理日志
                    AdminLog::addLog('给用户ID'.$a->uid.'的业绩增加'.$request->get('num'), $a->uid);

                    // 用户业绩增加
                    CommunityDividend::where('id', $id)->increment('total', $request->get('num'));
//                    CommunityDividend::where('id', $id)->increment('this_month', $request->get('num'));
                    //业绩足够升星
                    $user = User::where('id',$a->uid)->first();
                    $ucomm_jl =  CommunityDividend::where('uid',$a->uid)->first();
                    if($ucomm_jl->total >= 100000){
                        Log::info('d1');
                        //升2星
                        if($user->star_community < 2){
                            Log::info('d2');
                            User::where('id',$a->uid)->update(['star_community'=>2]);
                        }
                    }else if($ucomm_jl->total >= 10000){
                        Log::info('d3');
                        if($user->star_community < 1){
                            Log::info('d4');
                            User::where('id',$a->uid)->update(['star_community'=>1]);
                        }
                    }
                }else{

                    // 判断业绩是否充足
                    if($a->total < $request->get('num')){
                        return returnJson(0, '用户业绩不足');
                    }

                    // 记录管理日志
                    AdminLog::addLog('给用户ID'.$a->uid.'的业绩减少'.$request->get('num'), $a->uid);

                    // 用户余额减少
                    CommunityDividend::where('id', $id)->decrement('total', $request->get('num'));
//                    CommunityDividend::where('id', $id)->increment('this_month', $request->get('num'));
                    //业绩不足够降星
                    $user = User::where('id',$a->uid)->first();
                    $ucomm_jl =  CommunityDividend::where('uid',$a->uid)->first();
                    if($ucomm_jl->total < 100000){
                        //升2星
                        if($user->star_community >= 2){
                            User::where('id',$a->uid)->update(['star_community'=>1]);
                        }
                    }else if($ucomm_jl->total > 10000){
                        if($user->star_community >= 1){
                            User::where('id',$a->uid)->update(['star_community'=>0]);
                        }
                    }

                }

                \DB::commit();

            } catch (\Exception $exception) {

                \DB::rollBack();

                \Log::info('用户改变业绩失败', $request->all());

                return returnJson(0, '操作异常');

            }

            return returnJson(1, '操作成功');

        }

        $data = [
            'id' => $id,
            'total' => $a->total,
        ];

        return view('admin.community_div.ajax', $data);
    }

}
