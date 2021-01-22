@extends('admin.base')

@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '用户列表')
@section('pageHeaderTwoUrl', '/admin/user/index')

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
                , url: '/admin/user/index'
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
                        width: 70
                    }
                    , {
                        field: 'new_accounts',
                        title: '账号',
                        width: 120
                    }
                    , {
                        field: 'realname',
                        title: '真实姓名',
                        width: 100
                    }
                    , {
                        field: 'mobile',
                        title: '手机号',
                        width: 120
                    }
                    , {
                        field: 'avatar',
                        title: '头像',
                        width: 120,
                        templet: function (d) {
                            return '<div class="layer-photos-demo" ><img layer-src="'+ d.avatar +'" src="'+ d.avatar +'" ></div>';
                        }
                    }
                    , {
                        field: 'invite_code',
                        title: '邀请码',
                        width: 75
                    }
                    , {
                        field: 'pid_mobile',
                        title: '上级账户',
                        width: 125
                    }
                    , {
                        field: 'is_auth',
                        title: '实名认证',
                        width: 90,
                        templet: function (d) {
                            if(d.is_auth == 2){
                                return '<span class="layui-btn layui-btn-normal layui-btn-xs">认证中</span>';
                            }else if(d.is_auth == 1){
                                return '<span class="layui-btn layui-btn-xs">已认证</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-primary layui-btn-xs">未认证</span>';
                            }
                        }
                    }
                    , {
                        field: 'level',
                        title: '级别',
                        width: 90,
                        templet: function (d) {
                            if(d.level == 1){
                                return '普通会员';
                            }else if(d.level == 2){
                                return '高级会员';
                            }else{
                                return '无';
                            }
                        }
                    }
                    , {
                        field: 'buy_total',
                        title: '矿池总量',
                        sort: true
                    }
                    , {
                        field: 'release_total',
                        title: '释放总量',
                        sort: true
                    }
                    , {
                        field: 'is_bonus',
                        title: '分红奖',
                        width: 75,
                        templet: function (d) {
                            if(d.is_bonus == 1){
                                return '<span class="layui-btn layui-btn-xs">有</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-primary layui-btn-xs">无</span>';
                            }
                        }
                    }
                    , {
                        field: 'is_admin',
                        title: '管理奖',
                        width: 75,
                        templet: function (d) {
                            if(d.is_admin == 1){
                                return '<span class="layui-btn layui-btn-xs">有</span>';
                            }else{
                                return '<span class="layui-btn layui-btn-primary layui-btn-xs">无</span>';
                            }
                        }
                    },
                  	{
                        field: 'is_open_speedup',
                        title: '额外一代加速',
                        width: 75,
                        templet: function (d) {
                            if(d.is_open_speedup == 1){
                                return '<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="openspeed">开通</a>';
                            }else{
                                return '<a class="layui-btn layui-btn-danger layui-btn-xs"  lay-event="downspeed">关闭</a>';
                            }
                        }
                    }
                  	, {
                        field: 'independent_head',
                        title: 'iuic独立团队长奖',
                        width: 75,
                        templet: function (d) {
                            if(d.is_independent_head == 1){
                                return '<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="openhead">开通</a>';
                            }else{
                                return '<a class="layui-btn layui-btn-danger layui-btn-xs"  lay-event="downhead">关闭</a>';
                            }
                        }
                    }
                  	, {
                        field: 'is_independent_management',
                        title: 'iuic独立管理奖',
                        width: 75,
                        templet: function (d) {
                            if(d.is_independent_management == 1){
                                return '<span style="color:green">已开通</span>';
                              	
                            }else{
                                return '<span style="color:red">已关闭</span>';
                            }
                        }
                    }
                  	, {
                        field: 'independent_management_bl',
                        title: 'iuic独立管理奖比例',
                        width: 75
                    }
                  
                  	, {
                        field: 'is_independent_management',
                        title: '社群分享奖-伞下',
                        width: 75,
                        templet: function (d) {
                            if(d.is_community_sanxia == 1){
                                return '<span style="color:green">已开通</span>';
                              	
                            }else{
                                return '<span style="color:red">已关闭</span>';
                            }
                        }
                    }
                  	, {
                        field: 'community_sanxia_bl',
                        title: '社群分享奖比例-伞下',
                        width: 75
                    }
                  	, {
                        field: 'star_community',
                        title: '社群等级',
                        width: 90,
                        templet: function (d) {
                            if(d.star_community == 1){
                                return '<span>一星社群</span>';
                            }else if(d.star_community == 2){
                                return '<span>二星社群</span>';
                            }else if(d.star_community == 3){
                                return '<span>三星社群</span>';
                            }else{
                                return '<span>没有社群</span>';
                            }	
                        }
                    }
                  	
                  	
                    ,{
                        field: 'status',
                        title: '状态',
                        width: 60,
                        templet: function (d) {
                            if(d.status == 1){
                                return '<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="prohibit">启用</a>';
                            }else{
                                return '<a class="layui-btn layui-btn-danger layui-btn-xs"  lay-event="enable">禁用</a>';
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
                        width: 210,
                        templet: function (d) {

                            var str = '';

                            @if(Gate::forUser(auth('admin')->user())->check('admin.user.edit'))
                                str += '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>';
                            @endif

                            @if(Gate::forUser(auth('admin')->user())->check('admin.wallet.index'))
                                str += '<a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="wallet">钱包</a>';
                            @endif
                            
                            @if(Gate::forUser(auth('admin')->user())->check('admin.user.edit'))
                                str += '<a class="layui-btn layui-btn-xs"  onclick="active(\'/admin/user/add_ore_pool\','+ d.id +',\'增加矿池\',\'GET\',\'800px\',\'330px\')">加矿</a>';
                            @endif
                            
                            @if(Gate::forUser(auth('admin')->user())->check('admin.user.edit'))
                                str += '<a class="layui-btn layui-btn-xs"  onclick="active(\'/admin/user/minus_ore_pool\','+ d.id +',\'减少矿池\',\'GET\',\'800px\',\'330px\')">减矿</a>';
                            @endif
                            
                            @if(Gate::forUser(auth('admin')->user())->check('admin.user.edit'))
                                str += '<a class="layui-btn layui-btn-xs"  onclick="active(\'/admin/user/enery_head_lv\','+ d.id +',\'调整能量独立团长等级\',\'GET\',\'800px\',\'330px\')">调整能量独立团长等级</a>';
                            @endif
							
                            
                            @if(Gate::forUser(auth('admin')->user())->check('admin.user.edit'))
                                str += '<a class="layui-btn layui-btn-xs"  onclick="active(\'/admin/user/independent_management\','+ d.id +',\'开通iuic独立管理奖\',\'GET\',\'800px\',\'330px\')">开通iuic独立管理奖</a>';
                            @endif
							
                            @if(Gate::forUser(auth('admin')->user())->check('admin.user.edit'))
                                str += '<a class="layui-btn layui-btn-xs"  onclick="active(\'/admin/user/community_sanxia\','+ d.id +',\'社群分享奖-伞下\',\'GET\',\'800px\',\'330px\')">社群分享奖-伞下</a>';
                            @endif
                            
                            if(d.p_status == 1){
                                @if(Gate::forUser(auth('admin')->user())->check('admin.user.edit'))
                                    str += '<a class="layui-btn layui-btn-xs layui-btn-normal"  onclick="active(\'/admin/user/ajax\','+ d.id +',\'换上级\',\'GET\',\'800px\',\'330px\')">换上级</a>';
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
                    layer.confirm('真的删除行么', function (index) {
                        $.ajax({
                            url: "/admin/user/" + data.id,
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
                    location.href = '/admin/user/' + data.id + '/edit';
                } else if (obj.event === 'wallet') {
                    location.href = '/admin/wallet/index?soso=' + data.mobile;
                } else if (obj.event === 'enable') {
                    that = $(this);
                    layer.confirm('需要启用用户么', function (index) {
                        $.ajax({
                            url: "/admin/user/status",
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
                            url: "/admin/user/status",
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
                            url: "/admin/user/opspeed",
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
                            url: "/admin/user/opspeed",
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
                            url: "/admin/user/ophead",
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
                            url: "/admin/user/ophead",
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
                            url: "/admin/user/opmana",
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
                            url: "/admin/user/opmana",
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
                        location.href = '/admin/user/create';
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