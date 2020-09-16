@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '回购销毁记录')
@section('pageHeaderTwoUrl', '/admin/buy_back/index')
@section('pageHeaderThree', '添加记录')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加回购销毁记录</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/buy_back">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {{--<input type="hidden" name="num" value="{{$num}}" height="200px">--}}

        @include('admin.buy_back._form')
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