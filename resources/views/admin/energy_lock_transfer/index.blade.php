@extends('admin.base')

@section('pageHeaderOne', '能量商城')
@section('pageHeaderTwo', '锁仓能量转账')
@section('pageHeaderTwoUrl', '/admin/energy_lock_transfer/index')

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
                , url: '/admin/energy_lock_transfer/index'
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
                        field: 'nickname',
                        title: '昵称'
                    }
                    , {
                        field: 'num',
                        title: '数量'
                    }
                    , {
                        field: 'account',
                        title: '对方账号',
                        width: 130
                    }
                    , {
                        field: 'uu_nickname',
                        title: '对方昵称'
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