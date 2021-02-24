@extends('admin.base')

@section('pageHeaderOne', '生态2管理')
@section('pageHeaderTwo', '生态等级配置列表')
@section('pageHeaderTwoUrl', '/admin/ecology/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

    <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="ID" id="demoReload" autocomplete="off" placeholder="名称">
        </div>
        <button id="soso" class="layui-btn" data-type="reload">搜索</button>
    </div>

    <table id="demo" lay-filter="test"></table>

    <script type="text/html" id="barDemo">
        @if(Gate::forUser(auth('admin')->user())->check('admin.ecology.edit'))<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>@endif
        @if(Gate::forUser(auth('admin')->user())->check('admin.ecology.destroy'))
            <!-- <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> -->
        @endif
    </script>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            @if(Gate::forUser(auth('admin')->user())->check('admin.ecology.create'))
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
                , url: '/admin/ecology/index'
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
                        field: 'name',
                        title: '名称',
                        width: 130
                    }
                    , {
                        field: 'branch_num',
                        title: '考核部门数',
                    }
                    , {
                        field: 'branch_level',
                        title: '部门达到等级(ID)',
                    }
                    , {
                        field: 'rate_bonus',
                        title: '生态2团队长奖',
                    }
                    , {
                        field: 'remarks',
                        title: '备注',
                    }
                    , {
                        field: 'created_at',
                        title: '创建时间',
                        sort: true,
                        width:180
                    }
                    , {
                        field: 'right',
                        title: '操作',
                        toolbar: '#barDemo',
                        width:180
                    }
                ]]
                , id: 'testReload'
            });

            //监听工具条
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                if (obj.event === 'del') {
                    alert("暂不开放");
                    return false;
                    layer.confirm('真的删除行么', function (index) {
                        $.ajax({
                            url: "/admin/ecology/" + data.id,
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
                    location.href = '/admin/ecology/' + data.id + '/edit';
                }
            });

            //头工具栏事件
            table.on('toolbar(test)', function (obj) {
                var checkStatus = table.checkStatus(obj.config.id);
                switch (obj.event) {
                    case 'create':
                        location.href = '/admin/ecology/create';
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