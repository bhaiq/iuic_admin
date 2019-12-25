@extends('admin.base')

@section('pageHeaderOne', '矿机管理')
@section('pageHeaderTwo', '矿机订单')
@section('pageHeaderTwoUrl', '/admin/kuangji_order/index')

@section('body')
    <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="ID" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload" id="soso">搜索</button>
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
                , url: '/admin/kuangji_order/index'
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
                        width: 80
                    }
                    , {
                        field: 'new_account',
                        title: '账号',
                    }
                    , {
                        field: 'u_mobile',
                        title: '手机号',
                    }
                    , {
                        field: 'realname',
                        title: '真实名称',
                    }
                    , {
                        field: 'kj_name',
                        title: '矿机名称',
                    }
                    , {
                        field: 'status',
                        title: '状态',
                        width: 120,
                        templet: function (d) {
                            if(d.status == 1){
                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">正在运行</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-xs layui-btn-danger">已失效</span>';
                            }
                        }
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