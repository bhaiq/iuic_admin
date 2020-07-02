@extends('admin.base')

@section('pageHeaderOne', '能量商城')
@section('pageHeaderTwo', '指定锁仓用户')
@section('pageHeaderTwoUrl', '/admin/energy_appoint_user/index')
@section('pageHeaderThree', '添加指定锁仓用户')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加指定锁仓用户</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/energy_appoint_user">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @include('admin.energy_appoint_user._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop

