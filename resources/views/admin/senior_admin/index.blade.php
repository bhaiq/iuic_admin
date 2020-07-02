@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '高级管理奖')
@section('pageHeaderTwoUrl', '/admin/senior_admin/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

    <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="ID" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload">搜索</button>
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
                , url: '/admin/senior_admin/index'
                , method: 'POST'
                , where: {
                    "_token":"{{csrf_token()}}"
                }
                , page: true //开启分页
                , defaultToolbar: ['filter', 'exports']
                , cols: [[ //表头
                    {
                        fixed: 'left',
                        type: 'checkbox'
                    },
                    {
                        field: 'id',
                        title: 'ID',
                        sort: true,
                        width: 80
                    }
                    , {
                        field: 'new_account',
                        title: '账号',
                        width: 130
                    }
                    , {
                        field: 'mobile',
                        title: '手机号',
                        width: 130
                    }
                    , {
                        field: 'realname',
                        title: '真实名称',
                        width: 120
                    }
                    , {
                        field: 'num',
                        title: '质押数量'
                    }
                    , {
                        field: 'status',
                        title: '状态',
                        width: 100,
                        templet: function (d) {
                            if(d.status == 1){
                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">成功</span>';
                            }else if(d.status == 0){
                                return '<span class="layui-btn layui-btn-xs layui-btn-warm">申请中</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-xs layui-btn-danger">已拒绝</span>';
                            }
                        }
                    }
                    , {
                        field: 'type',
                        title: '级别',
                        width: 100,
                        templet: function (d) {
                            return d.type + '星';
                        }
                    }
                    , {
                        field: 'created_at',
                        title: '创建时间',
                        sort: true,
                        width: 180
                    }
                    , {
                        field: 'right',
                        title: '操作',
                        width: 180,
                        templet: function (d) {

                            var str = '';

                            if(d.status == 0){

                                @if(Gate::forUser(auth('admin')->user())->check('admin.senior_admin.edit'))
                                    str += '<a href="javascript:void(0)" class="layui-btn layui-btn-xs layui-btn-normal" lay-event="success">通过</a>';
                                    str += '<a href="javascript:void(0)" class="layui-btn layui-btn-xs layui-btn-danger" lay-event="fail">拒绝</a>';
                                @endif

                            }

                            return str;
                        }
                    }
                ]]
                , id: 'testReload'
            });

            //监听工具条
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                if (obj.event === 'success') {
                    layer.confirm('真的通过该申请么', function (index) {
                        $.ajax({
                            url: "/admin/senior_admin/ajax",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'status': 1,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    layer.close(index);
                                    layer.msg(d.msg, {icon: 6});
                                    location.href = location.href;
                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    })
                } else if (obj.event === 'fail') {
                    layer.confirm('真的拒绝该申请么', function (index) {
                        $.ajax({
                            url: "/admin/senior_admin/ajax",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'status': 9,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    layer.close(index);
                                    layer.msg(d.msg, {icon: 6});
                                    location.href = location.href;
                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    })
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

            $('.demoTable .layui-btn').on('click', function(){
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });


        });
    </script>
@stop