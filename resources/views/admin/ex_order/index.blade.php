@extends('admin.base')

@section('pageHeaderOne', '交易所')
@section('pageHeaderTwo', '币币订单')
@section('pageHeaderTwoUrl', '/admin/ex_order/index')

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
                , url: '/admin/ex_order/index'
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
                        width: 70
                    }
                    , {
                        field: 'new_account',
                        title: '账号',
                        width: 120
                    }
                    , {
                        field: 'mobile',
                        title: '手机号',
                        width: 120
                    }
                    , {
                        field: 'realname',
                        title: '真实姓名',
                        width: 100
                    }
                    , {
                        field: 'et_name',
                        title: '交易对名称',
                        width: 120
                    }
                    , {
                        field: 'price',
                        title: '单价',
                        width: 150
                    }
                    , {
                        field: 'amount',
                        title: '商品币数量'
                    }
                    , {
                        field: 'amount_lost',
                        title: '剩下商品币数量'
                    }
                    , {
                        field: 'amount_deal',
                        title: '花费法币数量'
                    }
                    , {
                        field: 'type',
                        title: '交易类型',
                        width: 90,
                        templet: function (d) {
                            if(d.type == 0){
                                return '<span class="layui-btn layui-btn-xs layui-btn-danger">卖</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">买</span>';
                            }
                        }
                    }
                    , {
                        field: 'status',
                        title: '状态',
                        width: 90,
                        templet: function (d) {
                            if(d.status == 1){
                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">已完成</span>';
                            }else if(d.status == 0){
                                return '<span class="layui-btn layui-btn-xs layui-btn-primary">未完成</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-xs layui-btn-danger">已取消</span>';
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