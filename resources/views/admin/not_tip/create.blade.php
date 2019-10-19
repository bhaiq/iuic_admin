@extends('admin.base')

@section('pageHeaderOne', '交易所')
@section('pageHeaderTwo', '免手续费')
@section('pageHeaderTwoUrl', '/admin/not_tip/index')
@section('pageHeaderThree', '添加免手续费用户')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>添加免手续费用户</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/not_tip">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @include('admin.not_tip._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop
