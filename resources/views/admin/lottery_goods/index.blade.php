@extends('admin.base')

@section('pageHeaderOne', '抽奖管理')
@section('pageHeaderTwo', '商品列表')
@section('pageHeaderTwoUrl', '/admin/lottery_goods/index')
@section('css')
    <style>
        .layui-table-cell{
            height: auto;
            max-height: 150px;
        }
    </style>
@stop
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

    <script type="text/html" id="barDemo">
        @if(Gate::forUser(auth('admin')->user())->check('admin.lottery_goods.edit'))<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>@endif
        {{--@if(Gate::forUser(auth('admin')->user())->check('admin.lottery_goods.destroy'))<a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>@endif--}}
    </script>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            {{--@if(Gate::forUser(auth('admin')->user())->check('admin.lottery_goods.create'))<button class="layui-btn layui-btn-sm" lay-event="create">新增</button>@endif--}}
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
                , url: '/admin/lottery_goods/index'
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
                        field: 'name',
                        title: '商品名称',
                        width: 150
                    }
                    , {
                        field: 'img',
                        title: '商品图片',
                        width: 125,
                        templet: function (d) {
                            return '<div class="layer-photos-demo" ><img layer-src="'+ d.img +'" src="'+ d.img +'" ></div>';
                        }
                    }
                    , {
                        field: 'zj_bl',
                        title: '中奖概率',
                        sort: true
                    }
                    , {
                        field: 'is_xc',
                        title: '是否宣传',
                        width: 120,
                        templet: function (d) {
                            if(d.is_xc == 1){
                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">宣传</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-xs layui-btn-primary">不宣传</span>';
                            }
                        }
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
                        toolbar: '#barDemo',
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
                            url: "/admin/lottery_goods/" + data.id,
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
                    location.href = '/admin/lottery_goods/' + data.id + '/edit';
                }
            });

            //头工具栏事件
            table.on('toolbar(test)', function (obj) {
                switch (obj.event) {
                    case 'create':
                        location.href = '/admin/lottery_goods/create';
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