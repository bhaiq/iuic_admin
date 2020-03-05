@extends('admin.base')
@section('pageHeaderOne', '抽奖管理')
@section('pageHeaderTwo', '抽奖配置')
@section('pageHeaderTwoUrl', '/admin/lottery_config/index')
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
                <a class="layui-btn-sm" href="{{url('admin/lottery_config/index')}}"
                   style="cursor:pointer;"><cite>配置列表</cite></a>;
            </span>
            </div>
        </fieldset>
    </div>

    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <li class="layui-this">抽奖配置</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <hr style="margin-top:0px;margin-bottom:0px;border-top: 1px solid #d2d2d2;">
                        抽奖配置
                        <div class="layui-card-body">
                            <form class="layui-form layui-form-pane" method="post"
                                  action="{{url('admin/lottery_config/update')}}" enctype="multipart/form-data">
                                @csrf

                                <div class="layui-form-item">
                                    <label class="layui-form-label" style="width: 200px;"><i
                                                class="layui-icon layui-icon-rate-solid"
                                                style="font-size:8px;color:red;"></i>单次抽奖数量</label>
                                    <div class="layui-input-inline" style="width:300px;">
                                        <input type="text" name="lottery_one_num" required lay-verify="required"
                                               placeholder="请输入数量" autocomplete="off" class="layui-input"
                                               value="{{$lottery_one_num}}">
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

            //监听提交
            form.on('submit(formDemo)', function (data) {
                layer.confirm('确认更新配置吗？', {icon: 3, title: '提示'}, function (index) {
                    console.log(data.field);
                    $.post(
                        '/admin/lottery_config/update',
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