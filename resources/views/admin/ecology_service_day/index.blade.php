@extends('admin.base')

@section('pageHeaderOne', '生态2管理')
@section('pageHeaderTwo', '日全网新增手续费列表')
@section('pageHeaderTwoUrl', '/admin/ecology_service_day/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

    <div class="demoTable">
        <!-- <form class="layui-form">
            <div class="layui-inline">
                <input class="layui-input" name="sou_uid" id="sou_uid" value="" autocomplete="off" placeholder="用户ID">
            </div>
            <div class="layui-inline" style="width: 180px;">
                <input type="text" class="layui-input" style="width:100%;" id="sou_created" placeholder="创建时间">
            </div>
            <button type="button" class="layui-btn" data-type="reload">搜索</button>
        </form> -->
    </div>

    <table id="demo" lay-filter="test"></table>

@stop

@section('js')
    <script>
        layui.use(['table', 'form'], function () {
            var table = layui.table;
            var form = layui.form;

            //第一个实例
            table.render({
                elem: '#demo'
                , toolbar: '#toolbarDemo'
                , url: '/admin/ecology_service_day/index'
                , method: 'POST'
                , where: {
                    "_token":"{{csrf_token()}}"
                }
                , page: true //开启分页
                ,limits: [10, 20, 50, 100, 9999]
                , defaultToolbar: ['filter', 'exports']
                , cols: [[ //表头
                    // {
                    //     fixed: 'left',
                    //     type: 'checkbox'
                    // },
                    {
                        field: 'id',
                        title: 'ID',
                        align: 'center',
                        width: 90
                    }, {
                        field: 'day_time',
                        title: '日期',
                        align: 'center',
                        // width: 90
                    }, {
                        field: 'total_point',
                        title: '日划转数',
                        align: 'center',
                    }, {
                        field: 'total_cny',
                        title: '日划转手续费',
                        align: 'center',
                    }, {
                        field: 'total_cny_actual',
                        title: '实际结算手续费',
                        align: 'center',
                    }, {
                        field: 'set_status_msg',
                        title: '结算方式',
                        align: 'center',
                    }, {
                        field: 'set_time',
                        title: '结算时间',
                        align: 'center',
                    }, {
                        field: 'created_at',
                        title: '创建时间',
                        align: 'center',
                        // width:180
                    },
                    {{--{--}}
                        {{--field: 'right',--}}
                        {{--title: '操作',--}}
                        {{--width: 180,--}}
                        {{--templet: function (d) {--}}
                            {{--var str = '';--}}
                            {{--@if(Gate::forUser(auth('admin')->user())->check('admin.ecology_service_day.edit'))--}}
                            {{--if(d.set_status_value == 0){--}}
                                {{--str += '<a class="layui-btn layui-btn-xs" lay-event="settlement">手动结算</a>';--}}
                            {{--}--}}
                            {{--@endif--}}
                                {{--return str;--}}
                        {{--}--}}
                    {{--}--}}
                ]]
                , id: 'testReload'
            });

            //监听工具条
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                if (obj.event === 'settlement') {
                    location.href = '/admin/ecology_service_day/' + data.id + '/edit';
                }
            });



            // 增加搜索
            var $ = layui.$, active = {
                reload: function(){
                    // var demoReload = $('#demoReload');
                    var sou_uid = $('#sou_uid').val();
                    var sou_created = $('#sou_created').val();

                    //执行重载
                    table.reload('testReload', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            sou_uid: sou_uid,
                            sou_created: sou_created
                        }
                    });
                }
                ,parseTable: function(){
                    table.init('demo');
                }
            };

            $('.demoTable .layui-btn').on('click', function(){
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });

        });
    </script>
@stop