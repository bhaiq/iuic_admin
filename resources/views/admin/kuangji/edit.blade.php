@extends('admin.base')

@section('pageHeaderOne', '矿机管理')
@section('pageHeaderTwo', '矿机列表')
@section('pageHeaderTwoUrl', '/admin/kuangji/index')
@section('pageHeaderThree', '编辑矿机')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>编辑矿机</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/kuangji/{{ $id }}">

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        @include('admin.kuangji._form')
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

            //普通图片上传
            var uploadInst = upload.render({
                elem: '#test1'
                ,url: '/admin/common/upload'
                ,data: {
                    type: "image",
                    "_token": "{{ csrf_token() }}"
                }
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#demo1').attr('src', result); //图片链接（base64）
                    });
                }
                ,done: function(res){

                    layer.msg(res.msg);
                    //上传成功
                    if(res.code == 1){
                        $('input[name=img]').val(res.data.url);
                    }

                }
                ,error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });

        });

    </script>
@stop