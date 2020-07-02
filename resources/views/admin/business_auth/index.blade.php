@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '商家认证')
@section('pageHeaderTwoUrl', '/admin/business_auth/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

    <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="ID" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload" id="soso">搜索</button>

        <button class="checkbtn layui-btn layui-btn-sm" data-id="0" data-type="reload">申请认证</button>
        <button class="checkbtn layui-btn layui-btn-sm layui-btn-primary" data-id="1" data-type="reload">已认证</button>
        <button class="checkbtn layui-btn layui-btn-sm layui-btn-primary" data-id="2" data-type="reload">认证取消</button>

        <input type="hidden" name="status" value="0">

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
                , url: '/admin/business_auth/index'
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
                        field: 'new_account',
                        title: '账号',
                        width: 130
                    }
                    , {
                        field: 'nickname',
                        title: '昵称',
                        width: 130
                    }
                    , {
                        field: 'mobile',
                        title: '手机号',
                        width: 130
                    }
                    , {
                        field: 'coin_name',
                        title: '押金币种',
                        width: 130
                    }
                    , {
                        field: 'coin_type_name',
                        title: '币种账户',
                        width: 130
                    }
                    , {
                        field: 'amount',
                        title: '数量'
                    }
                    , {
                        field: 'status',
                        title: '状态',
                        templet: function (d) {
                            var str = '';

                            if(d.status == 0){
                                return '<span class="layui-btn layui-btn-xs layui-btn-warm">申请认证商家</span>';
                            }

                            if(d.status == 1){
                                return '<span class="layui-btn layui-btn-xs layui-btn-normal">认证商家</span>';
                            }

                            if(d.status == 2){
                                return '<span class="layui-btn layui-btn-xs layui-btn-warm">申请退出认证</span>';
                            }

                            return str;
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
                        width: 180,
                        templet: function (d) {
                            var str = '';

                            if(d.status == 0){
                                @if(Gate::forUser(auth('admin')->user())->check('admin.business_auth.edit'))
                                    str += '<a class="layui-btn layui-btn-xs" lay-event="edit">通过</a>';
                                    str += '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">拒绝</a>';
                                @endif
                            }

                            if(d.status == 1){
                                @if(Gate::forUser(auth('admin')->user())->check('admin.business_auth.edit'))
                                    str += '<a class="layui-btn layui-btn-xs layui-btn-warm"  onclick="active(\'/admin/business_auth/ajax\','+ d.id +',\'取消认证\',\'GET\',\'800px\',\'330px\')">取消认证</a>';
                                @endif
                            }

                            if(d.status == 2){
                                @if(Gate::forUser(auth('admin')->user())->check('admin.business_auth.edit'))
                                    str += '<a class="layui-btn layui-btn-xs layui-btn-warm"  onclick="active(\'/admin/business_auth/ajax\','+ d.id +',\'同意取消认证\',\'GET\',\'800px\',\'330px\')">同意</a>';
                                    str += '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="oppose">反对</a>';
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
                    layer.confirm('真的拒绝么', function (index) {
                        $.ajax({
                            url: "/admin/business_auth/ajax",
                            type: "POST",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'id': data.id,
                                'status' : 2,
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
                    layer.confirm('真的通过么', function (index) {
                        $.ajax({
                            url: "/admin/business_auth/ajax",
                            type: "POST",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'id': data.id,
                                'status' : 1,
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
                } else if (obj.event === 'oppose') {
                    layer.confirm('真的反对么', function (index) {
                        $.ajax({
                            url: "/admin/business_auth/ajax",
                            type: "POST",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'id': data.id,
                                'status' : 5,
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
                }
            });

            // 增加搜索
            var $ = layui.$, active = {
                reload: function(){
                    var demoReload = $('#demoReload');
                    var status = $('input[name=status]').val();


                    //执行重载
                    table.reload('testReload', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            soso: demoReload.val(),
                            status: status,
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

            $('.checkbtn').on('click', function(){

                $('input[name=status]').val($(this).attr('data-id'));
                $('.checkbtn').addClass('layui-btn-primary');
                $(this).removeClass('layui-btn-primary');

                var type = $(this).attr('data-type');
                active[type] ? active[type].call(this) : '';
            });

        });
    </script>
@stop