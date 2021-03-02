@extends('admin.base')
@section('pageHeaderOne', '生态2管理')
@section('pageHeaderTwo', '生态2公共配置')
@section('pageHeaderTwoUrl', '/admin/ecology_configpub/index')
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
                <a class="layui-btn-sm" href="{{url('admin/ecology_configpub/index')}}"
                   style="cursor:pointer;"><cite>生态2公共配置</cite></a>;
            </span>
            </div>
        </fieldset>
    </div>

    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <li class="layui-this">购买积分</li>
                    <li class="">积分划转USDT手续费</li>
                    <li class="">车奖</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <!-- <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;"> -->
                        <!-- 生态2公共配置 -->
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post" action="{{url('admin/ecology_configpub/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">
                                        <i class="layui-icon layui-icon-rate-solid" style="font-size:8px;color:red;"></i>充值赠送冻结积分倍数
                                    </label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" step="0.01" min="0.00" max="99" name="point_multiple" required lay-verify="required" placeholder="请输入倍数" autocomplete="off" class="layui-input" value="{{$point_multiple}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">倍</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">
                                        <i class="layui-icon layui-icon-rate-solid" style="font-size:8px;color:red;"></i>生态2分享奖比例
                                    </label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" step="0.01" min="0.00" max="99" name="rate_direct" required lay-verify="required" placeholder="请输入比例" autocomplete="off" class="layui-input" value="{{$rate_direct}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">{{$rate_direct*100}}% 秒结</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">
                                        <i class="layui-icon layui-icon-rate-solid" style="font-size:8px;color:red;"></i>生态2合伙人奖
                                    </label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" step="0.01" min="0.00" max="99" name="rate_partner" required lay-verify="required" placeholder="请输入比例" autocomplete="off" class="layui-input" value="{{$rate_partner}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">{{$rate_partner*100}}% 日结</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">生态2团队长奖</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="radio" name="settlement_switch" value="1" title="自动" @if($settlement_switch == 1) checked @endif >
                                        <input type="radio" name="settlement_switch" value="2" title="手动" @if($settlement_switch == 2) checked @endif >
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
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post" action="{{url('admin/ecology_configpub/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">
                                        <i class="layui-icon layui-icon-rate-solid" style="font-size:8px;color:red;"></i>积分划转USDT手续费
                                    </label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" step="0.01" min="0.00" max="99" name="rate" required lay-verify="required" placeholder="请输入比例" autocomplete="off" class="layui-input" value="{{$rate}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">{{$rate*100}}% 秒结</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">
                                        <i class="layui-icon layui-icon-rate-solid" style="font-size:8px;color:red;"></i>生态2手续费合伙人奖
                                    </label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" step="0.01" min="0.00" max="99" name="rate_service_partner" required lay-verify="required" placeholder="请输入比例" autocomplete="off" class="layui-input" value="{{$rate_service_partner}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">{{$rate_service_partner*100}}% 合伙人加权分 日结</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">
                                        <i class="layui-icon layui-icon-rate-solid" style="font-size:8px;color:red;"></i>生态2手续费奖
                                    </label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" step="0.01" min="0.00" max="99" name="rate_service" required lay-verify="required" placeholder="请输入比例" autocomplete="off" class="layui-input" value="{{$rate_service}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">{{$rate_service*100}}% 指定人员加权分 日结</div>
                                </div>
                                {{--<div class="layui-form-item layui-form-text">--}}
                                    {{--<label class="layui-form-label">指定人员id集合</label>--}}
                                    {{--<div class="layui-input-block">--}}
                                        {{--<textarea placeholder="多个用户id,用英文逗号 ' , ' 隔开 如: 1,2,3,4" class="layui-textarea" name="designees">{{$designees}}</textarea>--}}
                                    {{--</div>--}}
                                    {{--<div class="layui-form-mid layui-word-aux">多个用户id,用英文逗号 ' , ' 隔开 如: 1,2,3,4</div>--}}
                                {{--</div>--}}
                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post" action="{{url('admin/ecology_configpub/update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">
                                        <i class="layui-icon layui-icon-rate-solid" style="font-size:8px;color:red;"></i>车奖比例
                                    </label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" step="0.01" min="0.00" max="99" name="car_rate" required lay-verify="required" placeholder="请输入比例" autocomplete="off" class="layui-input" value="{{$car_rate}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">{{$car_rate*100}}% 全网新增业绩</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">
                                        <i class="layui-icon layui-icon-rate-solid" style="font-size:8px;color:red;"></i>累计车奖
                                    </label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" step="0.0001" min="0.00" max="9999999999" name="" disabled lay-verify="disabled" placeholder="请输入数量" autocomplete="off" class="layui-input" value="{{$car_total}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">平台实际</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">
                                        <i class="layui-icon layui-icon-rate-solid" style="font-size:8px;color:red;"></i>剩余累计车奖
                                    </label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" step="0.0001" min="0.0000" max="9999999999" name="" disabled lay-verify="required" placeholder="请输入数量" autocomplete="off" class="layui-input" value="{{$car_surplus}}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">前端显示</div>
                                </div>
                                <div class="layui-form-item">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </form>
                            <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                            加减累计车奖
                            <form class="layui-form layui-form-pane" method="post" action="{{url('admin/ecology_configpub/update')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="car_surplus_sub" value="1">
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">操作数量</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="number" step="0.0001" min="0.0000" max="9999999999" name="car_surplus_change" required lay-verify="required" placeholder="请输入数量" autocomplete="off" class="layui-input" value="">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;">+/-</label>
                                    <div class="layui-input-inline" style="width:500px;">
                                        <input type="radio" name="car_surplus_addcut" value="-" title="减少" checked>
                                        <input type="radio" name="car_surplus_addcut" value="+" title="增加">
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
                        '/admin/ecology_configpub/update',
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