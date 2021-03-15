@extends('admin.base')

@section('pageHeaderOne', '生态2管理')
@section('pageHeaderTwo', '购买积分订单列表')
@section('pageHeaderTwoUrl', '/admin/ecology_buypoint/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

    <div class="demoTable">
        <form class="layui-form">
            <div class="layui-inline">
                <input class="layui-input" name="sou_uid" id="sou_uid" value="" autocomplete="off" placeholder="用户ID">
            </div>
            <div class="layui-inline" style="width: 180px;">
                <input type="text" class="layui-input" style="width:100%;" id="sou_created" placeholder="创建时间">
            </div>
            <button type="button" class="layui-btn" data-type="reload">搜索</button>
        </form>
    </div>

    <table id="demo" lay-filter="test"></table>

    <script type="text/html" id="barDemo">
        @if(Gate::forUser(auth('admin')->user())->check('admin.ecology_buypoint.edit'))
            <!-- <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a> -->
        @endif
        @if(Gate::forUser(auth('admin')->user())->check('admin.ecology_buypoint.destroy'))
            <!-- <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> -->
        @endif
    </script>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            @if(Gate::forUser(auth('admin')->user())->check('admin.ecology_buypoint.create'))
                <!-- <button class="layui-btn layui-btn-sm" lay-event="create">新增</button> -->
            @endif
        </div>
    </script>

@stop

@section('js')
    <script>
        layui.use(['table', 'form', 'laydate'], function () {
            var table = layui.table;
            var form = layui.form;
            var laydate = layui.laydate;

            laydate.render({
                elem: '#sou_created'
                ,range: true
            });

            //第一个实例
            table.render({
                elem: '#demo'
                , toolbar: '#toolbarDemo'
                , url: '/admin/ecology_buypoint/index'
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
                        width: 90,
                        sort: true,
                        align: 'center',
                    },{
                        field: 'uid',
                        title: '用户ID',
                        align: 'center',
                        width: 90
                    }, {
                        field: 'new_account',
                        title: '账号',
                        align: 'center',
                    }, {
                        field: 'realname',
                        title: '真实姓名',
                        align: 'center',
                    }, {
                        field: 'mobile',
                        title: '手机号',
                        align: 'center',
                    }, {
                        field: 'price_cny',
                        title: '购买金额(元)',
                        align: 'center',
                    }, {
                        field: 'now_price',
                        title: '当时IUIC/CNY价格',
                        align: 'center',
                    }, {
                        field: 'iuic_amount',
                        title: '消耗IUIC',
                        align: 'center',
                    }, {
                        field: 'creadit_amount',
                        title: '获得冻结积分',
                        align: 'center',
                    }, {
                        field: 'already_amount',
                        title: '已释放积分',
                        align: 'center',
                    }, {
                        field: 'pural',
                        title: '是否复投',
                        align: 'center',
                    }, {
                        field: 'end_time',
                        title: '释放结束时间',
                        align: 'center',
                        // width:180
                    }, {
                        field: 'created_at',
                        title: '创建时间',
                        align: 'center',
                        // width:180
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
                // if (obj.event === 'enable') {
                //     that = $(this);
                //     layer.confirm('需要显示么', function (index) {
                //         $.ajax({
                //             url: "/admin/ecology_buypoint/status",
                //             type: "POST",
                //             data: {
                //                 'id': data.id,
                //                 'car_is_show': 1,
                //                 '_token': "{{ csrf_token() }}"
                //             },
                //             success: function (d) {
                //                 if (d.code == 1) {
                //                     // obj.del();
                //                     // layer.close(index);
                //                     layer.msg(d.msg, {icon: 6})

                //                     that.removeClass('layui-btn-danger');
                //                     that.addClass('layui-btn-normal');
                //                     that.html('显示');

                //                 } else {
                //                     layer.msg(d.msg, {icon: 5})
                //                 }
                //             }
                //         });
                //     })
                // } else if (obj.event === 'prohibit') {
                //     that = $(this);
                //     layer.confirm('需要隐藏么', function (index) {
                //         $.ajax({
                //             url: "/admin/ecology_buypoint/status",
                //             type: "POST",
                //             data: {
                //                 'id': data.id,
                //                 'car_is_show': 0,
                //                 '_token': "{{ csrf_token() }}"
                //             },
                //             success: function (d) {
                //                 if (d.code == 1) {
                //                     // obj.del();
                //                     // layer.close(index);
                //                     layer.msg(d.msg, {icon: 6});

                //                     that.addClass('layui-btn-danger');
                //                     that.removeClass('layui-btn-normal');
                //                     that.html('隐藏');

                //                 } else {
                //                     layer.msg(d.msg, {icon: 5})
                //                 }
                //             }
                //         });
                //     });
                // }
            });

            //头工具栏事件
            table.on('toolbar(test)', function (obj) {
                var checkStatus = table.checkStatus(obj.config.id);
                switch (obj.event) {
                    case 'create':
                        // location.href = '/admin/ecology_buypoint/create';
                        break;
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