@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '业绩查询')
@section('pageHeaderTwoUrl', '/admin/ex_service/index')

@section('body')
    <div class="layui-row">
        <form class="layui-form">
            <div class="layui-col-xs3">
                <label class="layui-form-label">日期范围</label>
                <div class="layui-input-inline  layui-col-xs7">
                    <input type="text" class="layui-input" style="width:100%;" id="time" placeholder=" - ">
                </div>
            </div>
        </form>
        <div class="layui-col-xs3">
            {{--用户手机号：--}}
            {{--<div class="layui-inline">--}}
                {{--<input class="layui-input" name="ID" id="demoReload" autocomplete="off">--}}
            {{--</div>--}}
            <button class="layui-btn" id="soso">搜索</button>
        </div>
    </div>

    <br><br><br>

    <div style="padding: 20px; background-color: #F2F2F2;">

        <div class="layui-row layui-col-space15">

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">交易手续费</div>
                    <div class="layui-card-body" id="self_num">
                        0
                    </div>
                </div>
            </div>
            {{--<div class="layui-col-md4">--}}
                {{--<div class="layui-card">--}}
                    {{--<div class="layui-card-header">团队业绩</div>--}}
                    {{--<div class="layui-card-body" id="team_num">--}}
                        {{--0--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="layui-col-md4">--}}
                {{--<div class="layui-card">--}}
                    {{--<div class="layui-card-header">个人团队业绩</div>--}}
                    {{--<div class="layui-card-body" id="total_num">--}}
                        {{--0--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

        </div>

    </div>
@stop

@section('js')
    <script>
        layui.use(['table', 'form', 'laydate'], function () {
            var laydate = layui.laydate;
            var $ = layui.jquery;

            laydate.render({
                elem: '#time'
                ,range: true
            });

            $('#soso').click(function () {

                var soso = $('#demoReload').val();
                var time = $('#time').val();

                $.ajax({
                    url:"/admin/ex_service/ajax",    //请求的url地址
                    dataType:"json",   //返回格式为json
                    data:{'soso':soso,'time':time, '_token': "{{csrf_token()}}"},
                    type:"POST",   //请求方式
                    success:function(d){
                        console.log(d);
                        if(d.code == 1){

                            $('#self_num').html(d.data.self_num);
                            $('#team_num').html(d.data.team_num);
                            $('#total_num').html(d.data.total_num);

                            $('#ipfc_num').html(d.data.ipfc_num);
                            $('#ipfc_price').html(d.data.ipfc_price);
                            $('#ipfc_total').html(d.data.ipfc_total);

                            $('#qd_num').html(d.data.qd_num);
                            $('#js_num').html(d.data.js_num);
                            $('#jb_num').html(d.data.jb_num);

                        }else{
                            layer.alert(d.msg);
                        }
                    },
                    error:function(d){
                        layer.alert(d);
                    }
                });

            });

        });
    </script>
@stop
