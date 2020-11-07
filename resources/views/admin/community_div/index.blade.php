@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '用户业绩')
@section('pageHeaderTwoUrl', '/admin/community_div/index')

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

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            @if(Gate::forUser(auth('admin')->user())->check('admin.user.create'))<button class="layui-btn layui-btn-sm" lay-event="create">新增</button>@endif
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
                , url: '/admin/community_div/index'
                , method: 'POST'
                , where: {
                    "_token":"{{csrf_token()}}"
                }
                ,limits: [10, 20, 50, 100, 9999]
                , page: true //开启分页
                , defaultToolbar: ['filter', 'exports']
                , cols: [[ //表头
                    {
                        field: 'id',
                        title: 'ID',
                        sort: true,
                        // width: 70
                    }
                    , {
                        field: 'new_account',
                        title: '账号',
                        // width: 120
                    }
                    , {
                        field: 'this_month',
                        title: '虚拟业绩',
                        // width: 100
                    }
                    , {
                        field: 'true_num',
                        title: '真实业绩',
                        // width: 120
                    }
                    , {
                        field: 'created_at',
                        title: '创建时间',
                        sort: true,
                        // width: 180
                    }
                    , {
                        field: 'right',
                        title: '操作',
                        // width: 210,
                        templet: function (d) {

                            var str = '';

                            @if(Gate::forUser(auth('admin')->user())->check('admin.community_div.edit'))
                                str += '<a class="layui-btn layui-btn-xs layui-btn-warm"  onclick="active(\'/admin/community_div/ajax\','+ d.id +',\'用户业绩\',\'GET\',\'800px\',\'330px\')">业绩操作</a>';
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
                if (obj.event === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        $.ajax({
                            url: "/admin/community_div/" + data.id,
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
                    location.href = '/admin/community_div/' + data.id + '/edit';
                } else if (obj.event === 'wallet') {
                    location.href = '/admin/wallet/index?soso=' + data.mobile;
                } else if (obj.event === 'enable') {
                    that = $(this);
                    layer.confirm('需要启用用户么', function (index) {
                        $.ajax({
                            url: "/admin/community_div/status",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'type': 1,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    // obj.del();
                                    // layer.close(index);
                                    layer.msg(d.msg, {icon: 6})

                                    that.removeClass('layui-btn-danger');
                                    that.addClass('layui-btn-normal');
                                    that.html('启用');

                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    })
                } else if (obj.event === 'prohibit') {
                    that = $(this);
                    layer.confirm('需要禁用用户么', function (index) {
                        $.ajax({
                            url: "/admin/community_div/status",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'type': 0,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    // obj.del();
                                    // layer.close(index);
                                    layer.msg(d.msg, {icon: 6});

                                    that.addClass('layui-btn-danger');
                                    that.removeClass('layui-btn-normal');
                                    that.html('禁用');

                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    });


                }else if(obj.event === 'downspeed'){
                    that = $(this);
                    layer.confirm('开通么', function (index) {
                        $.ajax({
                            url: "/admin/community_div/opspeed",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'type': 1,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    // alert(d.data);
                                    // obj.del();
                                    // layer.close(index);
                                    layer.msg(d.msg, {icon: 6});

                                    // that.addClass('layui-btn-danger');
                                    // that.removeClass('layui-btn-normal');
                                    // that.html('开通');
                                    parent.location.reload();

                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    });
                }else if(obj.event === 'openspeed'){
                    that = $(this);
                    layer.confirm('关闭么', function (index) {
                        $.ajax({
                            url: "/admin/community_div/opspeed",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'type': 0,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    // alert(d.data);
                                    // obj.del();
                                    // layer.close(index);
                                    layer.msg(d.msg, {icon: 6})
                                    parent.location.reload();
                                    // that.removeClass('layui-btn-danger');
                                    // that.addClass('layui-btn-normal');
                                    // that.html('关闭');

                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    })
                }else if(obj.event === 'downhead'){
                    that = $(this);
                    layer.confirm('开通独立团队长奖么', function (index) {
                        $.ajax({
                            url: "/admin/community_div/ophead",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'type': 1,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    // alert(d.data);
                                    // obj.del();
                                    // layer.close(index);
                                    layer.msg(d.msg, {icon: 6});

                                    // that.addClass('layui-btn-danger');
                                    // that.removeClass('layui-btn-normal');
                                    // that.html('开通');
                                    parent.location.reload();

                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    });
                }else if(obj.event === 'openhead'){
                    that = $(this);
                    layer.confirm('关闭独立团队长奖么', function (index) {
                        $.ajax({
                            url: "/admin/community_div/ophead",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'type': 0,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    // alert(d.data);
                                    // obj.del();
                                    // layer.close(index);
                                    layer.msg(d.msg, {icon: 6})
                                    parent.location.reload();
                                    // that.removeClass('layui-btn-danger');
                                    // that.addClass('layui-btn-normal');
                                    // that.html('关闭');

                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    })
                }else if(obj.event === 'downmana'){
                    that = $(this);
                    layer.confirm('开通独立管理奖么', function (index) {
                        $.ajax({
                            url: "/admin/community_div/opmana",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'type': 1,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    // alert(d.data);
                                    // obj.del();
                                    // layer.close(index);
                                    layer.msg(d.msg, {icon: 6});

                                    // that.addClass('layui-btn-danger');
                                    // that.removeClass('layui-btn-normal');
                                    // that.html('开通');
                                    parent.location.reload();

                                } else {
                                    layer.msg(d.msg, {icon: 5})
                                }
                            }
                        });
                    });
                }else if(obj.event === 'openmana'){
                    that = $(this);
                    layer.confirm('关闭独立管理奖么', function (index) {
                        $.ajax({
                            url: "/admin/community_div/opmana",
                            type: "POST",
                            data: {
                                'id': data.id,
                                'type': 0,
                                '_token': "{{ csrf_token() }}"
                            },
                            success: function (d) {
                                if (d.code == 1) {
                                    // alert(d.data);
                                    // obj.del();
                                    // layer.close(index);
                                    layer.msg(d.msg, {icon: 6})
                                    parent.location.reload();
                                    // that.removeClass('layui-btn-danger');
                                    // that.addClass('layui-btn-normal');
                                    // that.html('关闭');

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
                        location.href = '/admin/community_div/create';
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