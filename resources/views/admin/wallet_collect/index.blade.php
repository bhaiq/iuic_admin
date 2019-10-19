@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '余额统计')
@section('pageHeaderTwoUrl', '/admin/wallet_total/index')

@section('body')
    <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="ID" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload" id="soso">搜索</button>
    </div>
    <p style="margin-top: 20px;color:red;">
        <span>
            IUIC的数量 = IUIC可用数量 + IUIC冻结数量 + IUIC买入交易数 - IUIC卖出交易数;
        </span><br>
        <span>
            USDT的数量 = USDT可用数量 + USDT冻结数量 - USDT买入交易数 + USDT卖出交易数 + 燃烧费 + 结余累计
        </span>
    </p>
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
                , url: '/admin/wallet_total/index'
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
                    ,{
                        field: 'id',
                        title: 'ID',
                        sort: true,
                        width: 70
                    }
                    , {
                        field: 'unum',
                        title: 'USDT可用数量'
                    }
                    , {
                        field: 'inum',
                        title: 'IUIC可用数量'
                    }
                    , {
                        field: 'u_frozen_num',
                        title: 'USDT冻结数量'
                    }
                    , {
                        field: 'i_frozen_num',
                        title: 'IUIC冻结数量'
                    }
                    , {
                        field: 'buy_trade_num',
                        title: 'IUIC买入交易数'
                    }
                    , {
                        field: 'sell_trade_num',
                        title: 'IUIC卖出交易数'
                    }
                    , {
                        field: 'buy_usdt_num',
                        title: 'USDT买入交易数'
                    }
                    , {
                        field: 'sell_usdt_num',
                        title: 'USDT卖出交易数'
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