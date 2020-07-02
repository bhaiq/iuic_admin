@extends('admin.base')

@section('pageHeaderOne', '新商城管理')
@section('pageHeaderTwo', '商品列表')
@section('pageHeaderTwoUrl', '/admin/mall_goods/index')
@section('pageHeaderThree', '编辑商品')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>编辑管理员</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/mall_goods/edit">

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @include('admin.mall_goods._form')
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
                layer.confirm('确定提交更新信息吗？', {icon: 3, title: '提示'}, function (index) {
                    console.log(data.field);
                    $.post(
                        "/admin/mall_goods/edit",
                        data.field,
                        function (d) {
                            layer.close();
                            layer.closeAll();
                            layer.msg(d.msg);
                            if (d.code == 1) {
                                location.href = '/admin/mall_goods';
                            }
                        }
                    );

                });
                return false;
            });
        });
    </script>
@stop
