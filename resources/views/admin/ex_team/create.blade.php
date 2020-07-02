@extends('admin.base')

@section('pageHeaderOne', '交易所')
@section('pageHeaderTwo', '交易对')
@section('pageHeaderTwoUrl', '/admin/ex_team/index')
@section('pageHeaderThree', '添加交易对')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加商品</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/ex_team">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @include('admin.ex_team._form')
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
                        '/admin/ex_team',
                        data.field,
                        function (d) {
                            layer.close();
                            layer.closeAll();
                            layer.msg(d.msg);
                            if (d.code == 1) {
                                location.href = '/admin/ex_team';
                            }
                        }
                    );

                });
                return false;
            });
        });
    </script>
@stop
