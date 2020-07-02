@extends('admin.base')

@section('pageHeaderOne', '新商城管理')
@section('pageHeaderTwo', '订单列表')
@section('pageHeaderTwoUrl', '/admin/mall_order/index')

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
                , url: '/admin/mall_order/index'
                , method: 'POST'
                , where: {
                    "_token":"{{csrf_token()}}"
                }
                ,limits: [10, 20, 50, 100]
                , page: true //开启分页
                , defaultToolbar: ['filter', 'exports']
                , cols: [[ //表头
                    {
                        field: 'order_sn',
                        title: '订单号',
                        width: 160
                    }
                    , {
                        field: 'store_name',
                        title: '店铺名称',
                        width: 100
                    }
                    , {
                        field: 'goods_name',
                        title: '商品名称',
                        width: 120
                    }
                    , {
                        field: 'goods_price',
                        title: '商品价格',
                        width: 120
                    }
                    , {
                        field: 'num',
                        title: '数量',
                        width: 60
                    }
                    , {
                        field: 'ore_pool',
                        title: '每个赠送的矿池',
                        width: 130
                    }
                    , {
                        field: 'status',
                        title: '状态',
                        width: 90,
                        templet: function (d) {
                            var str = '';

                            if(d.status == 2){
                                str += '<span class="layui-btn layui-btn-normal layui-btn-xs">已完成</span>';
                            }else if(d.status == 1){
                                str += '<span class="layui-btn layui-btn-xs layui-btn-primary">待收货</span>';
                            }else{
                                str += '<span class="layui-btn layui-btn-xs layui-btn-warm">待发货</span>';
                            }

                            return str;
                        }
                    }
                    , {
                        field: 'to_name',
                        title: '收货人',
                        width: 90
                    }
                    , {
                        field: 'to_mobile',
                        title: '收货手机'
                    }
                    , {
                        field: 'address',
                        title: '收货地址'
                    }
                    , {
                        field: 'kd_name',
                        title: '快递公司'
                    }
                    , {
                        field: 'kd_no',
                        title: '快递单号'
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
                            if(d.status == 2 && d.js_status == 0){
                                @if(Gate::forUser(auth('admin')->user())->check('admin.mall_order.edit'))
                                    str += '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="edit">结算收益</a>';
                                @endif
                            }

                            return str;
                        }
                    }
                ]]
                , id: 'testReload'
            });

            //监听工具条
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                if (obj.event === 'del') {
                    layer.confirm('真的删除么', function (index) {
                        $.ajax({
                            url: "/admin/mall_order/ajax",
                            type: "POST",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'id': data.id,
                                'status' : 9,
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
                    layer.confirm('确定结算么', function (index) {
                        $.ajax({
                            url: "/admin/mall_order/ajax",
                            type: "POST",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'id': data.id,
                                'status' : 1,
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    layer.close(index);
                                    layer.msg(d.msg, {icon: 6})
                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                                location.href = location.href;
                            }
                        });
                    })
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

            $('body').on('click', '.layer-photos-demo', function () {

                layer.photos({
                    photos: '.layer-photos-demo'
                    ,anim: 0 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
                });
            });

        });
    </script>
@stop