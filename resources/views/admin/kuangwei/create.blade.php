@extends('admin.base')

@section('pageHeaderOne', '矿机管理')
@section('pageHeaderTwo', '矿位列表')
@section('pageHeaderTwoUrl', '/admin/kuangwei/index')
@section('pageHeaderThree', '添加矿位')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加矿机</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/kuangwei">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @include('admin.kuangwei._form')
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

    layui.use(['form', 'upload'], function() {

        var $ = layui.jquery,form = layui.form,upload = layui.upload;

    });

</script>
@stop
