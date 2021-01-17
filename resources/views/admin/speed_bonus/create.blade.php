@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '团队长加速分红列表')
@section('pageHeaderTwoUrl', '/admin/speed_bonus/index')
@section('pageHeaderThree', '添加团队长加速分红')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加团队长加速分红</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/speed_bonus">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {{--<input type="hidden" name="coin_id" value="1">--}}
        {{--<input type="hidden" name="status" value="1">--}}
        @include('admin.speed_bonus._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop

@section('js')

    <script src="/script/ue/ueditor.config.js"></script>
    <script src="/script/ue/ueditor.all.min.js"></script>
    <script src="/script/ue/lang/zh-cn/zh-cn.js"></script>

    <script type="text/javascript">

        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor');

    </script>

@stop