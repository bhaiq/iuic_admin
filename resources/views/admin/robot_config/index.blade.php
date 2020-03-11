@extends('admin.base')
@section('pageHeaderOne', '机器人管理')
@section('pageHeaderTwo', '机器人配置')
@section('pageHeaderTwoUrl', '/admin/robot_config/index')
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
                <a class="layui-btn-sm" href="{{url('admin/robot_config/index')}}"
                   style="cursor:pointer;"><cite>配置列表</cite></a>;
            </span>
            </div>
        </fieldset>
    </div>

    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <li class="layui-this">机器人配置</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        机器人配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/robot_config/update')}}" enctype="multipart/form-data">
                                @csrf

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>机器人总开关</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="radio" name="robot_switch" value="0" title="关闭" @if($robot_switch == 0) checked @endif>
                                        <input type="radio" name="robot_switch" value="1" title="开启" @if($robot_switch == 1) checked @endif>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>机器人开始运行时间</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="robot_start_time" value="{{$robot_start_time}}" class="layui-input" id="test1" placeholder="HH:mm:ss">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>机器人结束运行时间</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="robot_end_time" value="{{$robot_end_time}}" class="layui-input" id="test2" placeholder="HH:mm:ss">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>机器人挂单最小价格幅度</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="robot_min_range" required lay-verify="required"
                                               placeholder="请输入价格幅度" autocomplete="off" class="layui-input"
                                               value="{{$robot_min_range}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：这个指的是机器人挂单的时候最小加或者减多少钱</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>机器人挂单最大价格幅度</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="robot_max_range" required lay-verify="required"
                                               placeholder="请输入价格幅度" autocomplete="off" class="layui-input"
                                               value="{{$robot_max_range}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">注：这个指的是机器人挂单的时候最大加或者减多少钱</div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>机器人拉单的方向</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="radio" name="robot_trade_status" value="0" title="做空" @if($robot_trade_status == 0) checked @endif>
                                        <input type="radio" name="robot_trade_status" value="1" title="做多" @if($robot_trade_status == 1) checked @endif>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>机器人挂多单的最大价格</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="robot_max_price" required lay-verify="required"
                                               placeholder="请输入价格" autocomplete="off" class="layui-input"
                                               value="{{$robot_max_price}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>机器人挂空单的最的价格</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="robot_min_price" required lay-verify="required"
                                               placeholder="请输入价格" autocomplete="off" class="layui-input"
                                               value="{{$robot_min_price}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>机器人挂单的最小数量</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="robot_min_trade_num" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$robot_min_trade_num}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>机器人挂单的最大数量</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="text" name="robot_max_trade_num" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$robot_max_trade_num}}">
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

            laydate.render({
                elem: '#test1'
                ,type: 'time'
            });
            laydate.render({
                elem: '#test2'
                ,type: 'time'
            });

            //监听提交
            form.on('submit(formDemo)', function (data) {
                layer.confirm('确认更新配置吗？', {icon: 3, title: '提示'}, function (index) {
                    console.log(data.field);
                    $.post(
                        '/admin/robot_config/update',
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