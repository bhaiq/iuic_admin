@extends('admin.base')

@section('pageHeaderOne', '生态2管理')
@section('pageHeaderTwo', '日全网新增业绩列表')
@section('pageHeaderTwoUrl', '/admin/ecology_creadits_day/index')
@section('pageHeaderThree', '日全网新增业绩结算')

@section('body')
    @include('admin.partials.fail')
    
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>日全网新增业绩结算</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/ecology_creadits_day/{{ $id }}">

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        @include('admin.ecology_creadits_day._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop