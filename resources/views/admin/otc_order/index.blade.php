@extends('admin.base')

@section('pageHeaderOne', '交易所')
@section('pageHeaderTwo', 'OTC订单')
@section('pageHeaderTwoUrl', '/admin/otc_order/index')

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
                , url: '/admin/otc_order/index'
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
                        field: 'sell_mobile',
                        title: '卖方账号',
                        width: 120
                    }
                    , {
                        field: 'sell_name',
                        title: '卖方名称',
                        width: 90
                    }
                    , {
                        field: 'buy_mobile',
                        title: '买方账号',
                        width: 120
                    }
                    , {
                        field: 'buy_name',
                        title: '买方名称',
                        width: 90
                    }
                    , {
                        field: 'coin_name',
                        title: '币种名称',
                        width: 90
                    }
                    , {
                        field: 'amount',
                        title: '交易数量'
                    }
                    , {
                        field: 'price',
                        title: '单价',
                        width: 80
                    }
                    , {
                        field: 'total_price',
                        title: '总价'
                    }
                    , {
                        field: 'status',
                        title: '状态',
                        width: 70,
                        templet: function (d) {
                            if(d.status == 1){
                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">已完成</span>';
                            }else if(d.status == 2){
                                return '<span class="layui-btn layui-btn-xs layui-btn-danger">已取消</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-xs layui-btn-primary">进行中</span>';
                            }
                        }
                    }
                    , {
                        field: 'is_pay',
                        title: '是否支付',
                        width: 90,
                        templet: function (d) {
                            if(d.is_pay == 1){
                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">已支付</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-xs layui-btn-primary">未支付</span>';
                            }
                        }
                    }
                    , {
                        field: 'is_pay_coin',
                        title: '是否放币',
                        width: 90,
                        templet: function (d) {
                            if(d.is_pay_coin == 1){
                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">已放币</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-xs layui-btn-primary">未放币</span>';
                            }
                        }
                    }
                    , {
                        field: 'appeal_mobile',
                        title: '申诉账号',
                        width: 120
                    }
                    , {
                        field: 'created_at',
                        title: '创建时间',
                        sort: true,
                        width: 170
                    }
                    , {
                        field: 'right',
                        title: '操作',
                        width: 180,
                        templet: function (d) {


                            var str = '';

                            @if(Gate::forUser(auth('admin')->user())->check('admin.otc_order.edit'))

                                if(d.status == 0 && d.appeal_mobile > 0){
                                    str += '<a class="layui-btn layui-btn-xs" lay-event="go_buy">放币给买家</a>';
                                    str += '<a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="go_sell">放币给卖家</a>';
                                }

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
                if (obj.event === 'go_buy') {
                    layer.confirm('真的放币给买家么', function (index) {
                        $.ajax({
                            url: "/admin/otc_order/ajax",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'type': 1,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    layer.close(index);
                                    layer.msg(d.msg, {icon: 6})
                                    window.location.href = './';
                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    })
                } else if (obj.event === 'go_sell') {
                    layer.confirm('真的放币给卖家么', function (index) {
                        $.ajax({
                            url: "/admin/otc_order/ajax",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'type': 2,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    layer.close(index);
                                    layer.msg(d.msg, {icon: 6})
                                    window.location.href = './';
                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    })
                }
            });

            //头工具栏事件
            table.on('toolbar(test)', function (obj) {
                switch (obj.event) {
                    case 'create':
                        location.href = '/admin/news/create';
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