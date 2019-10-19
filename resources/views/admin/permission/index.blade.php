@extends('admin.base')

@section('pageHeaderOne', '权限管理')
@section('pageHeaderTwo', '权限列表')
@section('pageHeaderTwoUrl', '/admin/permission/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

    <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="soso" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload">搜索</button>
    </div>

    <table id="demo" lay-filter="test"></table>

    <script type="text/html" id="barDemo">
        @if($cid == 0)<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">下级</a>@endif
        @if(Gate::forUser(auth('admin')->user())->check('admin.permission.edit'))<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>@endif
        @if(Gate::forUser(auth('admin')->user())->check('admin.permission.destroy'))<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>@endif
    </script>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            @if(Gate::forUser(auth('admin')->user())->check('admin.permission.create'))<button class="layui-btn layui-btn-sm" lay-event="create">新增</button>@endif
            @if($cid != 0)
                <button class="layui-btn layui-btn-sm" lay-event="returnUp">返回上级</button>@endif

        </div>
    </script>


@stop

@section('js')
    <script>
        layui.use('table', function () {
            var table = layui.table;

            //第一个实例
            table.render({
                elem: '#demo'
                , toolbar: '#toolbarDemo'
                , url: '/admin/permission/index'
                , method: 'POST'
                , where: {
                    "cid": "{{$cid}}","_token":"{{csrf_token()}}"
                }
                , page: true //开启分页
                , defaultToolbar: ['filter', 'exports']
                , cols: [[ //表头
                    {
                        fixed: 'left',
                        type: 'checkbox',
                    },
                    {
                        field: 'id',
                        title: 'ID',
                        sort: true,
                        width: 80
                    }
                    , {
                        field: 'name',
                        title: '权限规则',
                        width: 240
                    }
                    , {
                        field: 'label',
                        title: '权限名称',
                        width: 140
                    }
                    , {
                        field: 'description',
                        title: '权限概述'
                    }
                    , {
                        field: 'created_at',
                        title: '创建时间',
                        sort: true,
                        width: 180
                    }
                    , {
                        field: 'updated_at',
                        title: '更新时间',
                        sort: true,
                        width: 180
                    }
                    , {
                        field: 'right',
                        title: '操作',
                        toolbar: '#barDemo',
                        width: 180
                    }
                ]]
                , id: 'testReload'
            });

            //监听工具条
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                if (obj.event === 'detail') {
                    location.href = '/admin/permission?cid=' + data.id;
                } else if (obj.event === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        $.ajax({
                            url: "/admin/permission/" + data.id,
                            type: "POST",
                            data: {
                                '_method': "DELETE",
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    obj.del();
                                    layer.close(index);
                                    layer.msg(d.msg, {icon: 6})
                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    })
                } else if (obj.event === 'edit') {
                    location.href = '/admin/permission/' + data.id + '/edit';
                }
            });

            //头工具栏事件
            table.on('toolbar(test)', function (obj) {
                var checkStatus = table.checkStatus(obj.config.id);
                switch (obj.event) {
                    case 'create':
                        location.href = '/admin/permission/create?cid={{$cid}}';
                        break;

                    case 'returnUp':
                        location.href = '/admin/permission/index';
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
            };

            $('.demoTable .layui-btn').on('click', function(){
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });

        });
    </script>
@stop