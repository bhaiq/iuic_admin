@extends('admin.base')

@section('pageHeaderOne', '配置管理')
@section('pageHeaderTwo', '版本列表')
@section('pageHeaderTwoUrl', '/admin/version/index')
@section('pageHeaderThree', '编辑版本')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>编辑版本</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/version/{{ $id }}">

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        @include('admin.version._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop



