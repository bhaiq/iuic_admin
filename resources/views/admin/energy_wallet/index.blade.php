@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '能量钱包')
@section('pageHeaderTwoUrl', '/admin/energy_wallet/index')

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
                , url: '/admin/energy_wallet/index'
                , method: 'POST'
                , where: {
                    "_token":"{{csrf_token()}}"
                }
                ,limits: [10, 20, 50, 100, 9999]
                , page: true //开启分页
                , defaultToolbar: ['filter', 'exports']
                , cols: [[ //表头
                    {
                        fixed: 'left',
                        type: 'checkbox'
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
                        width: 100
                    }
                    , {
                        field: 'energy_num',
                        title: '可用余额'
                    }
                    , {
                        field: 'energy_frozen_num',
                        title: '冻结余额'
                    }
                    , {
                        field: 'consumer_num',
                        title: '消费积分'
                    }
                    , {
                        field: 'energy_lock_num',
                        title: '锁仓能量余额'
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

                            @if(Gate::forUser(auth('admin')->user())->check('admin.energy_wallet.edit'))
                                str += '<a class="layui-btn layui-btn-xs layui-btn-warm"  onclick="active(\'/admin/energy_wallet/ajax\','+ d.uid +',\'能量钱包\',\'GET\',\'800px\',\'330px\')">余额操作</a>';
                            str += '<a class="layui-btn layui-btn-xs"  onclick="active(\'/admin/energy_wallet/addfrozen\','+ d.uid +',\'能量钱包\',\'GET\',\'800px\',\'330px\')">加能量矿池</a>';
                            @endif

                                return str;

                        }
                    }
                ]]
                , id: 'testReload'
            });

            //监听工具条
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                if (obj.event === 'edit') {


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