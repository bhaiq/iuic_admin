@extends('admin.base')
@section('pageHeaderOne', '系统设置')
@section('pageHeaderTwo', '配置列表')
@section('pageHeaderTwoUrl', '/admin/config/index')
@section('head')
    <style>
        .layui-form-label {
            width: 250px;
        }
    </style>
@stop
@section('body')
    <div class="layui-card">
        <fieldset class="layui-elem-field">
            <div class="layui-field-box">
            <span class="layui-breadcrumb" lay-separator=">>">
                <a class="layui-btn-sm" href="{{url('admin/config/index')}}"
                   style="cursor:pointer;"><cite>配置列表</cite></a>;
            </span>
            </div>
        </fieldset>
    </div>

    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <li class="layui-this">OTC商家配置</li>
                    <li class="">会员提现配置</li>
                    <li class="">交易释放配置</li>
                    <li class="">交易配置</li>
                    <li class="">奖励配置</li>
                    <li class="">合伙人配置</li>
                    <li class="">矿机配置</li>
                    <li class="">网上购物商城配置</li>
                    <li class="">能量配置</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        OTC商家配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/config/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>押金币种名称</label>
                                    <div class="layui-input-inline" style="width:300px;">
                                        <select name="coin_name">
                                            @if(!empty($coin_arr))
                                                @foreach($coin_arr as $v)
                                                    <option value="{{$v['name']}}" @if($v['name'] == $coin_name) selected @endif>{{ $v['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>商家押金币种类型</label>
                                    <div class="layui-input-inline" style="width:300px;">
                                        <select name="coin_type">
                                            @if(!empty($coin_type_arr))
                                                @foreach($coin_type_arr as $k => $v)
                                                    <option value="{{$k}}" @if($k == $coin_type) selected @endif>{{ $v }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>押金数量</label>
                                    <div class="layui-input-inline" style="width:300px;">
                                        <input type="text" name="coin_num" required lay-verify="required"
                                               placeholder="请输入押金数量" autocomplete="off" class="layui-input"
                                               value="{{$coin_num}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="layui-tab-item">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        会员提现配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/config/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>USDT手续费</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="usdt_tip" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$usdt_tip}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>IUIC手续费</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="iuic_tip" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$iuic_tip}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>手机单一注册开关</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="radio" name="register_mobile_switch" value="0" title="关闭" @if($register_mobile_switch == 0) checked @endif>
                                        <input type="radio" name="register_mobile_switch" value="1" title="开启" @if($register_mobile_switch == 1) checked @endif>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：开启以后一个手机只能注册1个账号，关闭的话一个手机可以注册10个账号</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>用户认证开关</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="radio" name="user_auth_switch" value="0" title="关闭" @if($user_auth_switch == 0) checked @endif>
                                        <input type="radio" name="user_auth_switch" value="1" title="开启" @if($user_auth_switch == 1) checked @endif>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：开启以后用户提交的身份信息需要认证</div>
                                </div>

                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="layui-tab-item">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        交易释放配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/config/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>单笔交易释放比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="trade_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$trade_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>单日释放比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="today_release_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$today_release_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>单日释放次数</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="today_release_count" required lay-verify="required"
                                               placeholder="请输入次数" autocomplete="off" class="layui-input"
                                               value="{{$today_release_count}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>当日可释放最高数量</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="today_release_num" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$today_release_num}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>矿池每日静态释放比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="kuangchi_static_release_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$kuangchi_static_release_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>交易释放开始时间</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="trade_release_min_time" value="{{$trade_release_min_time}}" class="layui-input" id="test8" placeholder="HH:mm:ss">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>交易释放结束时间</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="trade_release_max_time" value="{{$trade_release_max_time}}" class="layui-input" id="test9" placeholder="HH:mm:ss">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="layui-tab-item">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        交易配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/config/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>交易卖方手续费比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="tip_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$tip_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>交易手续费分红比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="tip_bonus_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$tip_bonus_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>币币交易开始时间</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="cc_min_time" value="{{$cc_min_time}}" class="layui-input" id="test4" placeholder="HH:mm:ss">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>币币交易结束时间</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="cc_max_time" value="{{$cc_max_time}}" class="layui-input" id="test5" placeholder="HH:mm:ss">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>法币交易开始时间</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="lc_min_time" value="{{$lc_min_time}}" class="layui-input" id="test6" placeholder="HH:mm:ss">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>法币交易结束时间</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="lc_max_time" value="{{$lc_max_time}}" class="layui-input" id="test7" placeholder="HH:mm:ss">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>当日涨停百分比</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="today_trade_max_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$today_trade_max_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>当日跌停百分比</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="today_trade_min_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$today_trade_min_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>实时价格最大购买百分比</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="cur_trade_max_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$cur_trade_max_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>实时价格最小购买百分比</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="cur_trade_min_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$cur_trade_min_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="layui-tab-item">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        奖励配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/config/update')}}" enctype="multipart/form-data">
                                @csrf

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>用户认证奖励矿池</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="auth_reward" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$auth_reward}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>直推分享奖励比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="recommend_share_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$recommend_share_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>上级奖励矿池比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="pid_reward" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$pid_reward}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>管理奖数量</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" name="admin_bonus_num" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$admin_bonus_num}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>手续费分红奖比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="bonus_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$bonus_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>手续费管理奖比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="admin_bonus_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$admin_bonus_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>小节点奖分红比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="small_node" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$small_node}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.05表示5%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>大节点奖分红比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="big_node" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$big_node}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.04表示4%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>超级节点奖分红比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="super_node" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$super_node}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.03表示3%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>高级管理奖下级高级用户数</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="senior_admin_lower_user_count" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$senior_admin_lower_user_count}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>高级管理奖质押IUIC数量</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="senior_admin_num" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$senior_admin_num}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>1星高级管理奖拿伞下报单比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="senior_admin_1_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$senior_admin_1_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.15表示15%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>2星高级管理奖拿伞下报单比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="senior_admin_2_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$senior_admin_2_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.2表示20%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>3星高级管理奖拿伞下报单比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="senior_admin_3_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$senior_admin_3_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.25表示25%</div>
                                </div>

                              	<!-- iuic独立团队长奖 -->
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>iuic独立团队长奖比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="admin_mall_head_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$admin_mall_head_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.02表示2%，这个比例是伞下新增报单中扣除</div>
                                </div>

                                <!-- iuic独立管理奖 -->
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>iuic独立管理奖比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="admin_mall_mana_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$admin_mall_mana_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.05表示5%，这个比例是全网新增报单中扣除</div>
                                </div>
                              
                              
                              
                              	                              
                              	<!-- iuic社群分红配置 -->
                              
                              
                              	<div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>iuic每月社群分红第一级</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="community_lv1" required lay-verify="required"
                                               placeholder="请输入要达到的累计业绩" autocomplete="off" class="layui-input"
                                               value="{{$community_lv1}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：7200表示报单累计达到7200U</div>
                                </div>
                              
                              	<div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>iuic每月社群分红第二级</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="community_lv2" required lay-verify="required"
                                               placeholder="请输入要达到的累计业绩" autocomplete="off" class="layui-input"
                                               value="{{$community_lv2}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：100000表示报单累计达到100000U</div>
                                </div>
                              	<div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>iuic每月社群分红第三级</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="community_lv3" required lay-verify="required"
                                               placeholder="请输入要达到的累计业绩" autocomplete="off" class="layui-input"
                                               value="{{$community_lv3}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：500000表示报单累计达到500000U</div>
                                </div>
								
                              	<div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>iuic每月社群分红第四级</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="community_lv4" required lay-verify="required"
                                               placeholder="请输入要达到的累计业绩" autocomplete="off" class="layui-input"
                                               value="{{$community_lv4}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：1500000表示报单累计达到1500000U</div>
                                </div>
                              
                              	<div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>iuic每月社群分红第一级比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="community_bl_lv1" required lay-verify="required"
                                               placeholder="请输入要达到的累计业绩" autocomplete="off" class="layui-input"
                                               value="{{$community_bl_lv1}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.02表示2%,iuic每月社群分红第一级比例</div>
                                </div>
                              	<div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>iuic每月社群分红第二级比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="community_bl_lv2" required lay-verify="required"
                                               placeholder="请输入要达到的累计业绩" autocomplete="off" class="layui-input"
                                               value="{{$community_bl_lv2}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.02表示2%,iuic每月社群分红第二级比例</div>
                                </div>
                              	<div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>iuic每月社群分红第三级比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="community_bl_lv3" required lay-verify="required"
                                               placeholder="请输入要达到的累计业绩" autocomplete="off" class="layui-input"
                                               value="{{$community_bl_lv3}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.02表示2%,iuic每月社群分红第三级比例</div>
                                </div>
                              
                              	<div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>iuic每月社群分红第四级比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="community_bl_lv4" required lay-verify="required"
                                               placeholder="请输入要达到的累计业绩" autocomplete="off" class="layui-input"
                                               value="{{$community_bl_lv4}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.02表示2%,iuic每月社群分红第四级比例</div>
                                </div>
                              
                              
                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="layui-tab-item">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        合伙人配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/config/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>一份的价格</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="cost" required lay-verify="required"
                                               placeholder="请输入价格" autocomplete="off" class="layui-input"
                                               value="{{$cost}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：扣的是法币USDT</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>合伙人的总数量</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="count" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$count}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：请输入不能比前一个小的数字</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>合伙人分红比例(奖励I)</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="tip_partner" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$tip_partner}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>合伙人奖励比例(奖励U)</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="recommend_partner_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$recommend_partner_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.05表示5%，这里是老报单那里的配置</div>
                                </div>

                              
                              	<!-- 全网首次报单合伙人奖励比例 -->
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>全网首次报单合伙人奖励比例(奖励U)</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="recommend_all_first_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$recommend_all_first_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.05表示5%</div>
                                </div>
                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="layui-tab-item">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        矿机配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/config/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>矿机释放手续费比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="kuangji_release_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$kuangji_release_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.3表示30%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>币币交易释放开关</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="radio" name="trade_release_status" value="0" title="关闭" @if($trade_release_status == 0) checked @endif>
                                        <input type="radio" name="trade_release_status" value="1" title="开启" @if($trade_release_status == 1) checked @endif>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>矿机30天内赎回比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="kuangji_redeem_30_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$kuangji_redeem_30_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.3表示30%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>矿机60天内赎回比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="kuangji_redeem_60_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$kuangji_redeem_60_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.3表示30%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>矿机90天内赎回比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="kuangji_redeem_30_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$kuangji_redeem_90_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.3表示30%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>矿机赎回开关</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="radio" name="kuangji_redeem_switch" value="0" title="关闭" @if($kuangji_redeem_switch == 0) checked @endif>
                                        <input type="radio" name="kuangji_redeem_switch" value="1" title="开启" @if($kuangji_redeem_switch == 1) checked @endif>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>灵活矿位价格</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="kuangji_flexible_price" required lay-verify="required"
                                               placeholder="请输入价格" autocomplete="off" class="layui-input"
                                               value="{{$kuangji_flexible_price}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>灵活矿机算力比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="kuangji_flexible_suanli_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$kuangji_flexible_suanli_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.02表示2%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>灵活矿机购买最小值</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="kuangji_flexible_min" required lay-verify="required"
                                               placeholder="请输入最小值" autocomplete="off" class="layui-input"
                                               value="{{$kuangji_flexible_min}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>灵活矿机购买最大值</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="kuangji_flexible_max" required lay-verify="required"
                                               placeholder="请输入最大值" autocomplete="off" class="layui-input"
                                               value="{{$kuangji_flexible_max}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>提现矿池限制开关</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="radio" name="kuangji_cash_switch" value="0" title="关闭" @if($kuangji_cash_switch == 0) checked @endif>
                                        <input type="radio" name="kuangji_cash_switch" value="1" title="开启" @if($kuangji_cash_switch == 1) checked @endif>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>灵活矿机赎回开关</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="radio" name="kuangji_linghuo_redeem_switch" value="0" title="关闭" @if($kuangji_linghuo_redeem_switch == 0) checked @endif>
                                        <input type="radio" name="kuangji_linghuo_redeem_switch" value="1" title="开启" @if($kuangji_linghuo_redeem_switch == 1) checked @endif>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>


                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="layui-tab-item">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        网上购物商城配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/config/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>商家收入比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="admin_mall_store_income_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$admin_mall_store_income_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.4表示40%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>平台收入比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="admin_mall_platform_income_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$admin_mall_platform_income_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.6表示60%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>消费者推荐人分红比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="admin_mall_xfz_recommend_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$admin_mall_xfz_recommend_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.05表示5%，这个比例是从平台收入中扣除</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>合伙人分红比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="admin_mall_hhr_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$admin_mall_hhr_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个比例是从平台收入中扣除</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>管理奖分红比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="admin_mall_admin_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$admin_mall_admin_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个比例是从平台收入中扣除</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>社区分红比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="admin_mall_community_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$admin_mall_community_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.05表示5%，这个比例是从平台收入中扣除</div>
                                </div>

                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="layui-tab-item">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        能量商城
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/config/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量兑人民币的比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_cny" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_cny}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：1表示一个能量等于1人民币，2表示一个能量等于2个人民币</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量兑换的手续费</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_exchange_tip" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_exchange_tip}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.02表示2%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量静态释放比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_static_release_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_static_release_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.01表示1%，每天静态释放本金的比例</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量释放中可用能量的释放比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_ky_release_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_ky_release_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.8表示80%，这个比例是从释放的能量中占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量释放中消费者积分的释放比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_xfjf_release_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_xfjf_release_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个比例是从释放的能量中占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量释放中公益金的释放比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_gyjjf_release_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_gyjjf_release_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个比例是从释放的能量中占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>团队奖释放比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_team_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_team_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个比例是每日静态收益中占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>第一代代数奖比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_recommend_1_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_recommend_1_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个是报单时本金的占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>第二代代数奖比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_recommend_2_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_recommend_2_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个是报单时本金的占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>社区节点奖持币量超50000比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_community_50000_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_community_50000_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个是报单时本金的占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>社区节点奖持币量超40000比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_community_40000_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_community_40000_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个是报单时本金的占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>社区节点奖持币量超30000比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_community_30000_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_community_30000_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个是报单时本金的占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>社区节点奖持币量超20000比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_community_20000_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_community_20000_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个是报单时本金的占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>社区节点奖持币量超10000比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_community_10000_reward_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_community_10000_reward_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.1表示10%，这个是报单时本金的占比</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量兑换转矿比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_zk_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_zk_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.5表示50%</div>
                                </div>
								
                              	<!-- 加速比例设置 -->
                               <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量报单加速比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_jiasu_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_jiasu_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.2表示20%</div>
                               </div>
                              
                              <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量团队长奖</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_captain_bl" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_captain_bl}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.2表示20%</div>
                                </div>
                              <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>社群分享奖</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="share_star_reward" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$share_star_reward}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.2表示20%</div>
                                </div>
                              
                              
                              	<!-- 能量独立团队长分红设置 -->
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量独立团队长分红一级</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_head_lv1" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_head_lv1}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.2表示20%</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量独立团队长分红二级</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_head_lv2" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_head_lv2}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.2表示20%</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 300px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>能量独立团队长分红三级</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="energy_head_lv3" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$energy_head_lv3}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：0.2表示20%</div>
                                </div>
                              
                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        //Demo
        layui.use(['form', 'laydate'], function () {

            var form = layui.form;
            var laydate = layui.laydate;
            form.render();

            //时间选择器
            laydate.render({
                elem: '#test4'
                ,type: 'time'
            });
            laydate.render({
                elem: '#test5'
                ,type: 'time'
            });
            laydate.render({
                elem: '#test6'
                ,type: 'time'
            });
            laydate.render({
                elem: '#test7'
                ,type: 'time'
            });
            laydate.render({
                elem: '#test8'
                ,type: 'time'
            });
            laydate.render({
                elem: '#test9'
                ,type: 'time'
            });

            //监听提交
            form.on('submit(formDemo)', function (data) {
                layer.confirm('确认更新配置吗？', {icon: 3, title: '提示'}, function (index) {
                    console.log(data.field);
                    $.post(
                        '/admin/config/update',
                        data.field,
                        function (d) {
                            layer.close();
                            layer.closeAll();
                            layer.msg(d.msg);
                            if (d.code == 1) {
                                location.href = location.href;
                            }
                        }
                    );

                });
                return false;
            });
        });
    </script>
@stop