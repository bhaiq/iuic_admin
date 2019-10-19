@extends('admin.base')

@section('pageHeaderOne', '权限管理')
@section('pageHeaderTwo', '管理日志')
@section('pageHeaderTwoUrl', '/admin/admin_log/index')

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
            搜索关键字：
            <div class="layui-inline">
                <input class="layui-input" name="ID" id="demoReload" autocomplete="off">
            </div>
            <button class="layui-btn" id="soso" data-type="reload">搜索</button>
        </div>
    </div>

    <table id="demo" lay-filter="test"></table>

    <script type="text/html" id="barDemo">
    </script>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
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
                elem: '#time'
                ,range: true
            });

            //第一个实例
            table.render({
                elem: '#demo'
                , toolbar: '#toolbarDemo'
                , url: '/admin/admin_log/index'
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
                    }
                    , {
                        field: 'name',
                        title: '管理员名称',
                        width: 250,
                    }
                    , {
                        field: 'log',
                        title: '操作记录'
                    }
                    , {
                        field: 'ip',
                        title: 'IP',
                        width: 180,
                    }
                    , {
                        field: 'created_at',
                        title: '创建时间',
                        sort: true,
                        width: 180
                    }
                ]]
                , id: 'testReload'
            });

            // 增加搜索
            var $ = layui.$, active = {
                reload: function () {
                    var demoReload = $('#demoReload');
                    var time = $('#time');

                    //执行重载
                    table.reload('testReload', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        , where: {
                            soso: demoReload.val(),
                            time: time.val()
                        }
                    });
                }
                , parseTable: function () {
                    table.init('demo');
                }
            };

            $('#soso').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });

        });
    </script>
@stop