@extends('admin.base')

@section('pageHeaderOne', '商城管理')
@section('pageHeaderTwo', '订单列表')
@section('pageHeaderTwoUrl', '/admin/shop_order/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

    <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="ID" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload">搜索</button>
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
                , url: '/admin/shop_order/index'
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
                        field: 'goods_name',
                        title: '商品名称',
                        width: 110
                    }
                    , {
                        field: 'goods_price',
                        title: '商品价格',
                        width: 110
                    }
                    , {
                        field: 'coin_type',
                        title: '支付币种',
                        width: 80
                    }
                    , {
                        field: 'ore_pool',
                        title: '赠送的矿池数量',
                        width: 150
                    }
                    , {
                        field: 'status',
                        title: '状态',
                        width: 100,
                        templet: function (d) {
                            if(d.status == 2){
                                return '已发货';
                            }else{
                                return '购买成功';
                            }
                        }
                    }
                    , {
                        field: 'to_name',
                        title: '收货人',
                        width: 100
                    }
                    , {
                        field: 'to_mobile',
                        title: '收货手机',
                        width: 130
                    }
                    , {
                        field: 'to_address',
                        title: '收货地址'
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

            $('body').on('click', '.layer-photos-demo', function () {

                layer.photos({
                    photos: '.layer-photos-demo'
                    ,anim: 0 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
                });
            });

        });
    </script>
@stop