@extends('admin.base')

@section('pageHeaderOne', '财务管理')
@section('pageHeaderTwo', '指定节点')
@section('pageHeaderTwoUrl', '/admin/appoint_bonus/index')
@section('pageHeaderThree', '添加指定节点')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加指定节点</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/appoint_bonus">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @include('admin.appoint_bonus._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop