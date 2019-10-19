<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>后台管理</title>
    <link rel="stylesheet" href="/script/layui/css/layui.css">
    @section('css')
    @show
    <script src="/script/layui/layui.all.js"></script>
    <script>
        //JavaScript代码区域
        layui.use(['element', 'form'], function () {
            var element = layui.element;
            var form = layui.form;

            //全局定义一次, 加载formSelects
            layui.config({
                base: '/script/layui/' //此处路径请自行处理, 可以使用绝对路径
            }).extend({
                formSelects: 'formSelects-v4'
            });

            //弹窗页面
            active = function (url, id = '', title = '提示框', htp = 'GET', width = '800px', height = 'auto') {

                $.ajax({
                    url: url,
                    type: htp,
                    data: {id: id},
                    dataType: 'html',
                    headers: {
                        "_token": "{{csrf_token()}}"
                    },
                    success: function (arr) {
                        if (arr.code == 0) {
                            layer.msg(arr.msg);
                            return false;
                        } else {
                            layer.open({
                                title: title,
                                type: 1,
                                area: [width, height],
                                fixed: true,
                                content: arr,
                                skin: '',
                                // skin: 'layui-layer-lan',
                                // skin: 'layui-layer-molv',
                                maxmin: true,
                                offset: 'auto',
                                resizing: function (layro) {
                                    let h = layro.height();
                                    layro.find('.layui-layer-content').css('height', h - 42 + 'px');
                                }
                            });
                        }
                    },
                    error: function () {
                        layer.msg("系统正忙");
                    }
                })
            }

        });
    </script>
    @section('js')
    @show
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">中链 后台管理</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->

        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    {{auth()->user()->user}}
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="/admin/logout">退了</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <?php $comData = Request::get('comData_menu');?>
                <li class="layui-nav-item">
                    <a href="/admin/index"  @if(count($comData['openarr']) <= 0) class="layui-this" @endif><i class="layui-icon layui-icon-home">
                        </i>&nbsp;
                        <span>首页</span></a>
                </li>
                @foreach($comData['top'] as $v)
                    <li class="layui-nav-item @if(in_array($v['id'],$comData['openarr'])) layui-nav-itemed @endif">
                        <a href="#"><i class="layui-icon {{ $v['icon'] }}"></i>&nbsp;
                            <span>{{$v['label']}}</span>
                        </a>
                        <dl class="layui-nav-child">
                            @foreach($comData[$v['id']] as $vv)
                                <dd @if(in_array($vv['id'],$comData['openarr'])) class="layui-this" @endif>
                                    <a href="{{URL::route($vv['name'])}}" addtabs="{{$vv['id']}}"
                                       url="{{URL::route($vv['name'])}}">&nbsp;&nbsp;
                                        <i class="layui-icon layui-icon-circle"></i>&nbsp;&nbsp;
                                        {{$vv['label']}}
                                    </a>
                                </dd>
                            @endforeach
                        </dl>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>

    <div class="layui-body">
        <div style="padding: 15px;">
            @section('body')
            @show
        </div>
    </div>

    <div class="layui-footer">
        @section('footer')
        @show
    </div>
</div>
</body>
</html>