@extends('admin.base')

@section('pageHeaderOne', '能量商城')
@section('pageHeaderTwo', '质押级别')
@section('pageHeaderTwoUrl', '/admin/pledge_levels/index')
@section('pageHeaderThree', '编辑质押级别')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>编辑质押级别</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/pledge_levels/{{ $id }}">

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        @include('admin.pledge_levels._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop