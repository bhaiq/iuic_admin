@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '能量日志')
@section('pageHeaderTwoUrl', '/admin/energy_log/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

    <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="ID" id="demoReload" value="" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload">搜索</button>
    </div>

    <table id="demo" lay-filter="test"></table>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
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
                , url: '/admin/energy_log/index'
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
                        field: 'mobile',
                        title: '账号',
                        width: 130
                    }
                    ,{
                        field: 'realname',
                        title: '真实姓名',
                        width: 120
                    }
                    , {
                        field: 'wallet_type',
                        title: '币种类型',
                        width: 100,
                        templet: function (d) {
                            if(d.wallet_type == 1){
                                return '能量积分';
                            }else if(d.wallet_type == 2){
                                return '消费积分';
                            }
                        }
                    }
                    , {
                        field: 'num',
                        title: '数量',
                        width: 200
                    }
                    , {
                        field: 'sign',
                        title: '增减',
                        width: 120,
                        templet: function (d) {
                            if(d.sign == '-'){
                                return '<span class="layui-btn layui-btn-xs layui-btn-danger">减少</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">增加</span>';
                            }
                        }
                    }
                    , {
                        field: 'exp',
                        title: '说明'
                    }
                    , {
                        field: 'uu_mobile',
                        title: '对应账户',
                        width: 130
                    }
                    , {
                        field: 'uu_realname',
                        title: '对应名称',
                        width: 100
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

            $('.demoTable .layui-btn').on('click', function(){
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });

        });
    </script>
@stop