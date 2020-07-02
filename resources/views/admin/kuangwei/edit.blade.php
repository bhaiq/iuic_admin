@extends('admin.base')

@section('pageHeaderOne', '矿机管理')
@section('pageHeaderTwo', '矿位列表')
@section('pageHeaderTwoUrl', '/admin/kuangwei/index')
@section('pageHeaderThree', '编辑矿位')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>编辑矿位</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/kuangwei/{{ $id }}">

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
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