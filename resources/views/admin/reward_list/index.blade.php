@extends('admin.base')

@section('pageHeaderOne', '财务管理')
@section('pageHeaderTwo', '分红列表')
@section('pageHeaderTwoUrl', '/admin/reward_list/index')

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
                , url: '/admin/reward_list/index'
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
                        field: 'new_account',
                        title: '账号'
                    }
                    , {
                        field: 'u_mobile',
                        title: '手机号'
                    }
                    , {
                        field: 'realname',
                        title: '真实名称'
                    }
                    , {
                        field: 'type',
                        title: '奖励名称',
                        templet: function (d) {
                            if(d.type == 1){
                                if(d.node_type == 0){
                                    return '<span class="layui-btn layui-btn-xs layui-btn-primary">节点奖</span>';
                                }else if(d.node_type == 1) {
                                    return '<span class="layui-btn layui-btn-xs">小节点奖</span>';
                                }else if(d.node_type == 2){
                                    return '<span class="layui-btn layui-btn-xs layui-btn-normal">大节点奖</span>';
                                }else if(d.node_type == 3){
                                    return '<span class="layui-btn layui-btn-xs layui-btn-danger">超级节点奖</span>';
                                }else{
                                    return '未知';
                                }

                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">节点奖<span>';
                            }else if(d.type == 2){
                                return '<span class="layui-btn layui-btn-xs layui-btn-warm">管理奖</span>';
                            }
                        }
                    }

                    , {
                        field: 'created_at',
                        title: '创建时间',
                        sort: true,
                        width: 170
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