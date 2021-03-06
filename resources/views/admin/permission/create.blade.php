@extends('admin.base')

@section('pageHeaderOne', '权限管理')
@section('pageHeaderTwo', '权限列表')
@section('pageHeaderTwoUrl', '/admin/permission/index')
@section('pageHeaderThree', '添加权限')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加权限</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/permission">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @include('admin.permission._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop