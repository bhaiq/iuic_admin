@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '持币详细')
@section('pageHeaderTwoUrl', '/admin/hold_user/index')

@section('body')
    <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="ID" id="demoReload" value="{{$soso}}" autocomplete="off">
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
                , autoSort: false
                , toolbar: '#toolbarDemo'
                , url: '/admin/hold_user/index'
                , method: 'POST'
                , where: {
                    "_token":"{{csrf_token()}}",'soso':"{{$soso}}"
                }
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
                    }
                    , {
                        field: 'name',
                        title: '真实名称',
                    }
                    , {
                        field: 'mobile',
                        title: '手机号',
                    }
                    , {
                        field: 'price',
                        title: '持币价格',
                        sort: true,
                    }
                    , {
                        field: 'amount',
                        title: '持币数量',
                        sort: true,
                    }
                    , {
                        field: 'updated_at',
                        title: '持币时间',
                        width: 180
                    }
                ]]
                , id: 'testReload'
            });

            //监听工具条
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                if (obj.event === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        $.ajax({
                            url: "/admin/hold_user/" + data.id,
                            type: "POST",
                            data: {
                                '_method': "DELETE",
                                '_token': "{{ csrf_token() }}"
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
                    location.href = '/admin/hold_user/index?soso=' + data.price;
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

            //监听排序事件
            table.on('sort(test)', function(obj){

                table.reload('testReload', {
                    initSort: obj
                    ,where: {
                        field: obj.field //排序字段
                        ,sort: obj.type //排序方式
                    }
                });

            });

        });
    </script>
@stop