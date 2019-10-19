@extends('admin.base1')

@section('pageHeaderOne', '配置管理')
@section('pageHeaderTwo', '额外奖励')
@section('pageHeaderTwoUrl', '/admin/extra_bonus/index')
@section('pageHeaderThree', '编辑额外奖励')

@section('css')
    <link rel="stylesheet" href="/script/layui/formSelects-v4.css" />
@stop

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>编辑额外奖励</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/extra_bonus/{{ $id }}">

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        @include('admin.extra_bonus._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop

@section('js')
    <script src="/script/layui/formSelects-v4.js"></script>
    <script type="text/javascript">

        //加载模块
        layui.use(['jquery', 'formSelects'], function(){
            var formSelects = layui.formSelects;

        });
    </script>
@stop