@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '用户列表')
@section('pageHeaderTwoUrl', '/admin/user/index')
@section('pageHeaderThree', '添加用户')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加用户</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/user">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @include('admin.user._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop

@section('js')
    <script>
        //Demo
        layui.use('form', function () {

            var form = layui.form;
            form.render();

            //监听提交
            form.on('submit(demo1)', function (data) {
                layer.confirm('确定提交新增信息吗？', {icon: 3, title: '提示'}, function (index) {
                    console.log(data.field);
                    $.post(
                        '/admin/user',
                        data.field,
                        function (d) {
                            layer.close();
                            layer.closeAll();
                            layer.msg(d.msg);
                            if (d.code == 1) {
                                location.href = '/admin/user';
                            }
                        }
                    );

                });
                return false;
            });
        });
    </script>
@stop
