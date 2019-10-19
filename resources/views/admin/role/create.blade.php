@extends('admin.base')

@section('pageHeaderOne', '权限管理')
@section('pageHeaderTwo', '角色列表')
@section('pageHeaderTwoUrl', '/admin/role/index')
@section('pageHeaderThree', '添加角色')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加角色</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/role">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @include('admin.role._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop
