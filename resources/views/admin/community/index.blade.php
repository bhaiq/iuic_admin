@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '社区列表')
@section('pageHeaderTwoUrl', '/admin/community/index')

@section('body')

    @include('admin.partials.fail')
    @include('admin.partials.success')

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
                , url: '/admin/community/index'
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
                        field: 'id',
                        title: 'ID',
                        width: 80
                    }
                    , {
                        field: 'new_account',
                        title: '账号',
                        width: 130
                    }
                    , {
                        field: 'u_mobile',
                        title: '手机号',
                        width: 130
                    }
                    , {
                        field: 'realname',
                        title: '真实姓名',
                        width: 130
                    }
                    , {
                        field: 'name',
                        title: '社区名称',
                        width: 130
                    }
                    , {
                        field: 'mobile',
                        title: '社区电话',
                        width: 130
                    }
                    , {
                        field: 'address',
                        title: '社区地址'
                    }
                    , {
                        field: 'oneself_img',
                        title: '本人照片',
                        width: 150,
                        templet: function (d) {
                            return '<div class="layer-photos-demo" ><img layer-src="'+ d.oneself_img +'" src="'+ d.oneself_img +'" ></div>';
                        }
                    }
                    , {
                        field: 'field_img',
                        title: '场地照片',
                        width: 150,
                        templet: function (d) {
                            return '<div class="layer-photos-demo" ><img layer-src="'+ d.field_img +'" src="'+ d.field_img +'" ></div>';
                        }
                    }
                    , {
                        field: 'status',
                        title: '状态',
                        width: 90,
                        templet: function (d) {
                            var str = '';

                            if(d.status == 0){
                                str += '<span class="layui-btn layui-btn-primary layui-btn-xs">申请中</span>';
                            }else if(d.status == 1){
                                str += '<span class="layui-btn layui-btn-xs layui-btn-normal">成功</span>';
                            }else{
                                str += '<span class="layui-btn layui-btn-xs layui-btn-danger">已拒绝</span>';
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
                                @if(Gate::forUser(auth('admin')->user())->check('admin.user_auth.edit'))
                                    str += '<a class="layui-btn layui-btn-xs" lay-event="edit">通过</a>';
                                    str += '<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">拒绝</a>';
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
                            url: "/admin/community/ajax",
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
                    layer.confirm('真的通过么', function (index) {
                        $.ajax({
                            url: "/admin/community/ajax",
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
                    var is_auth = $('input[name=is_auth]').val();


                    //执行重载
                    table.reload('testReload', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            soso: demoReload.val(),
                            is_auth: is_auth,
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

                $('input[name=is_auth]').val($(this).attr('data-id'));
                $('.checkbtn').addClass('layui-btn-primary');
                $(this).removeClass('layui-btn-primary');

                var type = $(this).attr('data-type');
                active[type] ? active[type].call(this) : '';
            });

        });
    </script>
@stop