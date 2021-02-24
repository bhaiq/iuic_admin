@extends('admin.base')

@section('pageHeaderOne', '生态2管理')
@section('pageHeaderTwo', '车奖排行榜')
@section('pageHeaderTwoUrl', '/admin/ecology_carranking/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

    <div class="demoTable">
        <!-- 搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="ID" id="demoReload" autocomplete="off" placeholder="名称">
        </div>
        <button id="soso" class="layui-btn" data-type="reload">搜索</button> -->
    </div>

    <table id="demo" lay-filter="test"></table>

    <script type="text/html" id="barDemo">
        @if(Gate::forUser(auth('admin')->user())->check('admin.ecology_carranking.edit'))
            <!-- <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a> -->
        @endif
        @if(Gate::forUser(auth('admin')->user())->check('admin.ecology_carranking.destroy'))
            <!-- <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> -->
        @endif
    </script>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            @if(Gate::forUser(auth('admin')->user())->check('admin.ecology_carranking.create'))
                <!-- <button class="layui-btn layui-btn-sm" lay-event="create">新增</button> -->
            @endif
        </div>
    </script>

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
                , url: '/admin/ecology_carranking/index'
                , method: 'POST'
                , where: {
                    "_token":"{{csrf_token()}}"
                }
                , page: true //开启分页
                , defaultToolbar: ['filter', 'exports']
                , cols: [[ //表头
                    {
                        fixed: 'left',
                        title: '排名',
                        type: 'numbers',
                        width: 80
                    }
                    // {
                    //     field: 'carranking',
                    //     title: '排名',
                    //     sort: true,
                    //     width: 80
                    // }
                    ,{
                        field: 'id',
                        title: '用户ID',
                        width: 150
                    }
                    , {
                        field: 'new_account',
                        title: '账号',
                    }
                    , {
                        field: 'realname',
                        title: '真实姓名',
                    }
                    , {
                        field: 'mobile',
                        title: '手机号',
                    }
                    , {
                        field: 'ecology_lv',
                        title: '生态2等级',
                    }
                    , {
                        field: 'ecology_lv_time',
                        title: '生态2等级更新时间',
                    }
                    , {
                        field: 'car_is_show',
                        title: '是否在车奖排行榜显示',
                        templet: function (d) {
                            if(d.car_is_show == 1){
                                return '<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="prohibit">显示</a>';
                            }else{
                                return '<a class="layui-btn layui-btn-danger layui-btn-xs"  lay-event="enable">隐藏</a>';
                            }
                        }
                    }
                    // , {
                    //     field: 'right',
                    //     title: '操作',
                    //     toolbar: '#barDemo',
                    //     width:180
                    // }
                ]]
                , id: 'testReload'
            });

            //监听工具条
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                if (obj.event === 'enable') {
                    that = $(this);
                    layer.confirm('需要显示么', function (index) {
                        $.ajax({
                            url: "/admin/ecology_carranking/status",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'car_is_show': 1,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    // obj.del();
                                    // layer.close(index);
                                    layer.msg(d.msg, {icon: 6})

                                    that.removeClass('layui-btn-danger');
                                    that.addClass('layui-btn-normal');
                                    that.html('显示');

                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    })
                } else if (obj.event === 'prohibit') {
                    that = $(this);
                    layer.confirm('需要隐藏么', function (index) {
                        $.ajax({
                            url: "/admin/ecology_carranking/status",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'car_is_show': 0,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    // obj.del();
                                    // layer.close(index);
                                    layer.msg(d.msg, {icon: 6});

                                    that.addClass('layui-btn-danger');
                                    that.removeClass('layui-btn-normal');
                                    that.html('隐藏');

                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    });
                }
            });

            //头工具栏事件
            table.on('toolbar(test)', function (obj) {
                var checkStatus = table.checkStatus(obj.config.id);
                switch (obj.event) {
                    case 'create':
                        location.href = '/admin/ecology_carranking/create';
                        break;
                }
            });

            // 增加搜索
            var $ = layui.$, active = {
                reload: function(){
                    var demoReload = $('#demoReload');

                    //执行重载
                    table.reload('testReload', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            soso: demoReload.val()
                        }
                    });
                }
                ,parseTable: function(){
                    table.init('demo');
                }
            };

            $('#soso').on('click', function(){
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
        });
    </script>
@stop