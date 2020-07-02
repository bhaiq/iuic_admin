<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019/7/15
 * Time: 14:36
 */

namespace App\Http\Controllers\Admin;

use App\Models\AdminLog;
use App\Models\ReleaseOrder;
use App\Models\ShopGood;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserWalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected $fields = [
        'nickname' => '',
        'mobile' => '',
        'password' => '',
        'transaction_password' => '',
        'invite_code' => '',
      	'star_community' => '',
        'energy_captain_award' => ''
    ];

    // 用户列表
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $soso = $request->get('soso', 0);

            $p = User::from('user as u')
                ->select('u.*', 'ui.level', 'ui.buy_total', 'ui.release_total', 'ui.is_bonus', 'ui.is_admin', 'uu.new_account as pid_mobile', 'a.name as realname')
                ->leftJoin('user_info as ui', 'ui.uid', 'u.id')
                ->leftJoin('authentication as a', 'a.uid', 'u.id')
                ->leftJoin('user as uu', 'uu.id', 'u.pid');

            if ($soso) {
                $p->where(function ($q) use ($soso) {
                    $q->where('a.name', 'like', '%' . $soso . '%')
                        ->orwhere('uu.new_account', 'like', '%' . $soso . '%')
                        ->orwhere('u.mobile', 'like', '%' . $soso . '%');
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

            foreach ($data['data'] as $k => $v){
                $data['data'][$k]['p_status'] = $this->getPidStatus($v['id']);
            }

            return response()->json($data);
        }

        return view('admin.user.index');

    }

    // 获取用户状态
    private function getPidStatus($uid)
    {

        // 判断用户有没有下级
        if(User::where('pid', $uid)->exists()){
            return 0;
        }

        // 判断用户有没有报单
        if(UserInfo::where('uid', $uid)->exists()){
            return 0;
        }

        return 1;

    }

    //新增用户
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('admin.user.create', $data);
    }

    //添加用户
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nickname' => 'required',
            'mobile' => 'required|regex:/^1[34578][0-9]{9}$/',
            'password' => ['required', 'regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,16}$/'],
            'transaction_password' => 'required|digits:6',
            'invite_code' => 'required',
        ], [
            'nickname.required' => '用户昵称不能为空',
            'mobile.required' => '手机号不能为空',
            'mobile.regex' => '手机号格式不正确',
            'password.required' => '密码不能为空',
            'password.regex' => '密码是6~16位数字和字母组合',
            'transaction_password.required' => '交易密码不能为空',
            'transaction_password.digits' => '交易密码是6位数字组合',
            'invite_code.required' => '邀请码不能为空',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        // 判断手机号是否重复
        if (User::where('mobile', $request->get('mobile'))->exists()) {
            return returnJson(0, '手机号已被注册');
        }

        // 判断邀请码是否正确
        $pidUser = User::where('invite_code', $request->get('invite_code'))->first();
        if (!$pidUser) {
            return returnJson(0, '邀请码不正确');
        }

        $user = new User();
        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }

        $user->new_account = $pidUser->mobile;
        $user->pid = $pidUser->id;
        $user->pid_path = $pidUser->pid_path . $pidUser->id . ',';
        $user->password = password($request->get('password'));
        $user->transaction_password = password($request->get('transaction_password'));

        $user->save();

        AdminLog::addLog('新增用户');

        return returnJson(1, '新增成功');
    }

    //修改用户
    public function edit($id)
    {
        $user = User::find((int)$id);
        if (!$user) return redirect('/admin/user')->with('fail', '数据有误');


        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $user->$field);
        }

        $data['id'] = (int)$id;
        $data['level_id'] = 0;
        $data['levels'] = [
            '无', '普通会员', '高级会员'
        ];
		$data['star'] = [
            '无', '一星社群', '二星社群','三星社群'
        ];
        $data['energy_captain'] = [
            '关闭', '开启'
        ];
        // 获取用户级别信息
        $ui = UserInfo::where('uid', $id)->first();
        if($ui){
            $data['level_id'] = $ui->level;
        }

        return view('admin.user.edit', $data);

    }

    //更新用户
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'nickname' => 'required',
            'mobile' => 'required|regex:/^1[34578][0-9]{9}$/',
        ], [
            'nickname.required' => '用户昵称不能为空',
            'mobile.required' => '手机号不能为空',
            'mobile.regex' => '手机号格式不正确',
        ]);

        if ($validator->fails()) {
            return returnJson(0, $validator->errors()->first());
        }

        $user = User::where('id', $id)->first();
        if (!$user) {
            return returnJson(0, '数据有误');
        }

        // 判断手机号是否重复
        //if (User::where('id', '!=', $user->id)->where('mobile', $request->get('mobile'))->exists()) {
            //return returnJson(0, '手机号已被注册');
        //}

        if ($request->has('password') && !empty($request->get('password'))) {

            $validator = Validator::make($request->all(), [
                'password' => 'regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,16}$/',
            ], [
                'password.regex' => '密码是6~16位数字和字母组合',
            ]);

            if ($validator->fails()) {
                return returnJson(0, $validator->errors()->first());
            }

            $user->password = password($request->get('password'));
        }

        if ($request->has('transaction_password') && !empty($request->get('transaction_password'))) {

            $validator = Validator::make($request->all(), [
                'transaction_password' => 'digits:6',
            ], [
                'transaction_password.digits' => '交易密码是6位数字组合',
            ]);

            if ($validator->fails()) {
                return returnJson(0, $validator->errors()->first());
            }

            $user->transaction_password = password($request->get('transaction_password'));
        }
        $user->nickname = $request->get('nickname');
        $user->mobile = $request->get('mobile');
		$user->star_community = $request->get('star_community');
        $user->energy_captain_award = $request->get('energy_captain_award');
        $user->save();

        // 获取用户级别信息
        $ui = UserInfo::where('uid', $id)->first();
        if(!$ui){
            $uiData = [
                'pid' => $user->pid,
                'pid_path' => $user->pid_path,
                'level' => $request->get('level_id', 0),
                'release_time' => now()->toDateTimeString(),
                'created_at' => now()->toDateTimeString(),
            ];

            UserInfo::create($uiData);

        }else{

            UserInfo::where('uid', $id)->update(['level' => $request->get('level_id', 0)]);

        }


        AdminLog::addLog('更新ID为' . $id . '的用户');

        return returnJson(1, '更新成功');

    }

    // 用户更换上级
    public function ajax(Request $request)
    {

        $id = $request->get('id');
        $u = User::find($id);
        if(!$u){
            return returnJson(0, '数据有误');
        }

        if($request->isMethod('POST')){

            $validator = Validator::make($request->all(), [
                'pid' => 'required',
            ], [
                'pid.required' => '上级不能为空',
            ]);

            if ($validator->fails()) {
                return returnJson(0, $validator->errors()->first());
            }

            // 判读用户是否能更改上级
            if(!$this->getPidStatus($id)){
                return returnJson(0, '该用户不能修改上级');
            }

            // 获取新的上级的信息
            $pUser = User::find($request->get('pid'));

            \DB::beginTransaction();
            try {

                $u->pid = $pUser->id;
                $u->pid_path = $pUser->pid_path . $pUser->id . ',';
                $u->save();

                \DB::commit();

            } catch (\Exception $exception) {

                \DB::rollBack();

                \Log::info('用户更改上级失败', $request->all());

                return returnJson(0, '操作异常');

            }

            return returnJson(1, '操作成功');

        }

        $pid_name = '';
        $pidUser = User::with('user_auth')->where('id', $u->pid)->first();
        if($pidUser){
            $pid_name = $pidUser->user_auth->name ?? $pidUser->nickname ?? $pidUser->mobile;
        }

        $data = [
            'id' => $id,
            'pid' => $u->pid,
            'pid_name' => $pid_name,
            'users' => User::get()->toArray(),
        ];

        return view('admin.user.ajax', $data);


    }

    // 用户增加矿池
    public function addOrePool(Request $request)
    {

        $id = $request->get('id');
        $u = User::with('user_info')->find($id);
        if(!$u){
            return returnJson(0, '数据有误');
        }

        if($request->isMethod('POST')){

            $validator = Validator::make($request->all(), [
                'good_id' => 'required',
            ], [
                'good_id.required' => '矿池数量不能为空',
            ]);

            if ($validator->fails()) {
                return returnJson(0, $validator->errors()->first());
            }

            // 获取商品信息是否有误
            $sg = ShopGood::find($request->get('good_id'));
            if(!$sg){
                return returnJson(0, '矿池信息有误');
            }

            \DB::beginTransaction();
            try {

                // 更新用户级别
                $this->updateUserLevel($id, $u->pid, $sg->buy_count, $sg->ore_pool, $u->pid_path);

                // 增加用户矿池余额记录
                UserWalletLog::addLog($u->id, 0, 0, '后台增加矿池', '+', $sg->ore_pool, 2, 1);

                // 释放订单表增加
                $reoData = [
                    'uid' => $u->id,
                    'total_num' => $sg->ore_pool,
                    'today_max' => bcmul(0.01, $sg->ore_pool, 2),
                    'release_time' => now()->subDay()->toDateTimeString(),
                    'created_at' => now()->toDateTimeString(),
                ];
                ReleaseOrder::create($reoData);

                \DB::commit();

            } catch (\Exception $exception) {

                \DB::rollBack();

                \Log::info('给用户加矿失败', $request->all());

                return returnJson(0, '操作异常');

            }

            return returnJson(1, '操作成功');

        }

        $goods = ShopGood::get()->toArray();

        $data = [
            'id' => $id,
            'num' => $u->user_info ? $u->user_info->buy_total : 0,
            'goods' => $goods,
        ];

        return view('admin.user.add_ore_pool', $data);

    }
  
   // 用户减少矿池
    public function minusOrePool(Request $request)
    {

        $id = $request->get('id');
        $u = User::with('user_info')->find($id);
        if(!$u){
            return returnJson(0, '数据有误');
        }

        if($request->isMethod('POST')){

            $validator = Validator::make($request->all(), [
                'good_id' => 'required',
            ], [
                'good_id.required' => '矿池数量不能为空',
            ]);

            if ($validator->fails()) {
                return returnJson(0, $validator->errors()->first());
            }

            // 获取商品信息是否有误
            $sg = ShopGood::find($request->get('good_id'));
            if(!$sg){
                return returnJson(0, '矿池信息有误');
            }

            \DB::beginTransaction();
            try {

                // 增加用户矿池余额记录
                UserWalletLog::addLog($u->id, 0, 0, '后台减少矿池', '-', $sg->ore_pool, 2, 1);
                //用户矿池数量
                $jlbuy_total = UserInfo::where('uid', $u->id)->value('buy_total');
                //所有未释放订单数量
                $jlall_release = ReleaseOrder::where('uid',$u->id)->where('status',0)->sum('total_num');
                if($sg->ore_pool>$jlbuy_total && $sg->ore_pool>$jlall_release){
                    return returnJson(0, '剩余数量不足');
                }
                //用户减矿
                UserInfo::where('uid', $u->id)->decrement('buy_total',$sg->ore_pool);
                $jl_all_release = ReleaseOrder::where('uid',$u->id)->where('status',0)->orderBy('id','desc')->get();
                //要减去数额
                $jl_minus = $sg->ore_pool;
                foreach ($jl_all_release as $k => $v) {
                    //订单足够减去,//不够减再去减下一个订单,将目前订单修改为0,$jl_minus相应减少
                    if($v['total_num']>=$jl_minus){
                        ReleaseOrder::where('id',$v->id)->decrement('total_num',$jl_minus);
                        break;
                    }else{
                        $jl_minus = bcsub($jl_minus,$v['total_num'],2);
                        ReleaseOrder::where('id',$v->id)->update(['total_num'=>'0']);
                    }
                }
               

                \DB::commit();

            } catch (\Exception $exception) {

                \DB::rollBack();

                \Log::info('给用户减矿失败', $request->all());

                return returnJson(0, '操作异常'.$exception);

            }

            return returnJson(1, '操作成功');

        }

        $goods = ShopGood::get()->toArray();

        $data = [
            'id' => $id,
            'num' => $u->user_info ? $u->user_info->buy_total : 0,
            'goods' => $goods,
        ];

        return view('admin.user.minus_ore_pool', $data);

    }

    // 更新用户级别
    private function updateUserLevel($uid, $pid, $buyCount, $num, $pidPath)
    {

        $userLevel = UserInfo::where('uid', $uid)->first();
        if($userLevel) {
            // 当用户级别存在的情况下
            $ulData = [
                'buy_total' => $userLevel->buy_total + $num,
                'buy_count' => $userLevel->buy_count + $buyCount
            ];

            // 当用户满足升为高级的情况下
            if(bcadd($userLevel->buy_count, $buyCount) >= 5){
                $ulData['level'] = 2;
            }else{
                $ulData['level'] = 1;
            }

            UserInfo::where('uid', $uid)->update($ulData);

            \Log::info('编辑了用户ID为'. $uid .'的用户级别信息', $ulData);

        }else{
            // 当用户级别不存在的情况下

            $level = ($buyCount >= 5) ? 2 : 1;

            $ulData = [
                'uid' => $uid,
                'pid' => $pid,
                'pid_path' => $pidPath,
                'level' => $level,
                'buy_total' => $num,
                'buy_count' => $buyCount,
            ];

            UserInfo::create($ulData);

            \Log::info('新增一条用户级别信息', $ulData);

        }

    }

    // 更新用户状态
    public function setStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required|in:0,1',
        ], [
            'id.required' => '用户信息不能为空',
            'type.required' => '操作类型不能为空',
            'type.in' => '操作类型不正确',
        ]);

        $user = User::find($request->get('id'));
        if(!$user){
            return returnJson(0, '用户数据有误');
        }

        $user->status = $request->get('type');
        $user->save();

        return returnJson(1, '操作成功');

    }
  
      //额外开通一代加速
    public function openSpeed(Request $request)
    {
       $validator = Validator::make($request->all(), [
           'id' => 'required',
           'type' => 'required|in:0,1',
       ], [
           'id.required' => '用户信息不能为空',
           'type.required' => '操作类型不能为空',
           'type.in' => '操作类型不正确',
       ]);

       $m=User::where('id',$request->id)->update(['is_open_speedup'=>$request->type]);
       if($m){
           return returnJson(1, '操作成功');
       }else{
           return returnJson(0, '操作失败');
       }

    }
  
  	//独立团队长奖
    public function openHead(Request $request)
    {
       $validator = Validator::make($request->all(), [
           'id' => 'required',
           'type' => 'required|in:0,1',
       ], [
           'id.required' => '用户信息不能为空',
           'type.required' => '操作类型不能为空',
           'type.in' => '操作类型不正确',
       ]);

       $m=User::where('id',$request->id)->update(['is_independent_head'=>$request->type]);
       if($m){
           return returnJson(1, '操作成功');
       }else{
           return returnJson(0, '操作失败');
       }

    }
    //独立管理奖
    public function openMana(Request $request)
    {
       $validator = Validator::make($request->all(), [
           'id' => 'required',
           'type' => 'required|in:0,1',
       ], [
           'id.required' => '用户信息不能为空',
           'type.required' => '操作类型不能为空',
           'type.in' => '操作类型不正确',
       ]);

       $m=User::where('id',$request->id)->update(['is_independent_management'=>$request->type]);
       if($m){
           return returnJson(1, '操作成功');
       }else{
           return returnJson(0, '操作失败');
       }

    }
  
  
  	//能量队团长等级展示
  	public function eneryHeadLv(Request $request)
    {
       $id = $request->get('id');
       $u = User::find($id);
       if(!$u){
           return returnJson(0, '数据有误');
       }
       $data=[
           'id' => $u->id,
           'new_account' => $u->new_account,
           'energy_head_lv' => $u->energy_head_lv,
       ];
        // dd($data);
        return view('admin.user.enery_head_lv',$data);
    }
	//能量队团长等级调整
    public function eneryHeadLvAdjust(Request $request)
    {
        $m=User::where('id',$request->id)->update(['energy_head_lv'=>$request->energy_head_lv]);
        if($m){
            return returnJson(1, '操作成功');
        }else{
            return returnJson(0, '操作失败');
        }
    }
  
  
  	  
  	//开通iuic独立管理奖页面
  	public function independentManagement(Request $request)
    {
       $id = $request->get('id');
       $u = User::find($id);
       if(!$u){
           return returnJson(0, '数据有误');
       }
       $data=[
           'id' => $u->id,
           'new_account' => $u->new_account,
           'is_independent_management' => $u->is_independent_management,
           'independent_management_bl' => $u->independent_management_bl,
       ];
        // dd($data);
        return view('admin.user.independent_management',$data);
    }
	//能量队团长等级调整
    public function independentManagementAdjust(Request $request)
    {
        $m=User::where('id',$request->id)->update(['is_independent_management'=>$request->is_independent_management,'independent_management_bl'=>$request->independent_management_bl]);
        if($m){
            return returnJson(1, '操作成功');
        }else{
            return returnJson(0, '操作失败');
        }
    }
  
  	//社群分享奖-伞下 页面
  	public function communitySanxia(Request $request)
    {	
      
       $id = $request->get('id');
       $u = User::find($id);
       if(!$u){
           return returnJson(0, '数据有误');
       }
       $data=[
           'id' => $u->id,
           'new_account' => $u->new_account,
           'is_community_sanxia' => $u->is_community_sanxia,
           'community_sanxia_bl' => $u->community_sanxia_bl,
       ];
       //dd($data);
        return view('admin.user.community_sanxia',$data);
    }
  
	//社群分享奖-伞下 比例
    public function communitySanxiaAdjust(Request $request)
    {
        $m=User::where('id',$request->id)->update(['is_community_sanxia'=>$request->is_community_sanxia,'community_sanxia_bl'=>$request->community_sanxia_bl]);
        if($m){
            return returnJson(1, '操作成功');
        }else{
            return returnJson(0, '操作失败');
        }
    }

}