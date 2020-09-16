@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', 'IUIC矿池信息')
@section('pageHeaderTwoUrl', '/admin/iuic_info/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

    <!-- <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="ID" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload" id="soso">搜索</button>
    </div> -->

    <table id="demo" lay-filter="test"></table>

    <script type="text/html" id="barDemo">
        @if(Gate::forUser(auth('admin')->user())->check('admin.iuic_info.edit'))<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>@endif
        <!-- @if(Gate::forUser(auth('admin')->user())->check('admin.iuic_info.destroy'))<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>@endif -->
    </script>

    <!-- <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            @if(Gate::forUser(auth('admin')->user())->check('admin.iuic_info.create'))<button class="layui-btn layui-btn-sm" lay-event="create">新增</button>@endif
            </div>
        </script> -->

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
                , url: '/admin/iuic_info/index'
                , method: 'POST'
                , where: {
                    "_token":"{{csrf_token()}}"
                }
                , page: true //开启分页
                , defaultToolbar: ['filter', 'exports']
                , cols: [[ //表头
                    {
                        field: 'id',
                        title: 'ID',
                        sort: true,
                        width: 70
                    }
                    , {
                        field: 'exp',
                        title: '描述',
                    }
                    , {
                        field: 'true_value',
                        title: '真实数据',
                    }
                    , {
                        field: 'is_close',
                        title: '是否使用虚拟数据',
                        templet: function (d) {
                            if(d.is_close == 0){
                                return '<span class="layui-btn layui-btn-normal layui-btn-xs">是</span>';
                            }else if(d.is_close == 1){
                                return '<span class="layui-btn layui-btn-xs">否</span>';
                            }
                        }
                    }
                    , {
                        field: 'value',
                        title: '虚拟数据',
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
                    layer.confirm('真的删除行么', function (index) {
                        $.ajax({
                            url: "/admin/iuic_info/" + data.id,
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
                    location.href = '/admin/iuic_info/' + data.id + '/edit';
                }
            });

            //头工具栏事件
            table.on('toolbar(test)', function (obj) {
                switch (obj.event) {
                    case 'create':
                        location.href = '/admin/iuic_info/create';
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
