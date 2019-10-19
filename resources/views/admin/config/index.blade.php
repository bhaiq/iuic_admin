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
                    <li class="layui-this">商家配置</li>
                    <li class="">提现配置</li>
                    <li class="">交易释放</li>
                    <li class="">商城配置</li>
                    <li class="">交易配置</li>
                    <li class="">奖励配置</li>
                    <li class="">合伙人配置</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        商家配置
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
                        提现配置
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
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="layui-tab-item">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        交易释放
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
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="layui-tab-item">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        商城配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/config/update')}}" enctype="multipart/form-data">
                                @csrf
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
                                                style="font-size:8px;color:red;"></i>合伙人分红比例</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="tip_partner" required lay-verify="required"
                                               placeholder="请输入比例" autocomplete="off" class="layui-input"
                                               value="{{$tip_partner}}">
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