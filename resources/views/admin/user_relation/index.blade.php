@extends('admin.base')
@section('pageHeaderOne', '用户管理')
@section('pageHeaderTwo', '用户关系')
@section('pageHeaderTwoUrl', '/admin/public_platoon/index')

@section('body')

    <div class="demoTable">
        <label class="layui-form-label">关键字</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="soso" name="soso"
                   value="{{ isset($soso) ? $soso : '' }}" placeholder="账号">
        </div>
        <div class="layui-input-inline">
            <button class="layui-btn layui-btn-sm layui-btn-normal" lay-submit lay-filter="selectsub"><i
                        class="layui-icon layui-icon-search"></i>搜索</button>
        </div>
    </div>

    <div class="layui-card">

        <style type="text/css">
            .tree {
                min-height: 20px;
                padding: 19px;
                margin-bottom: 20px;
                background-color: #fbfbfb;
                border: 1px solid #999;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
                -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05)
            }

            .tree ul {
                margin-left: 25px;
            }

            .tree li {
                list-style-type: none;
                margin: 0;
                padding: 10px 5px 0 5px;
                position: relative
            }

            .tree li::before, .tree li::after {
                content: '';
                left: -20px;
                position: absolute;
                right: auto
            }

            .tree li::before {
                border-left: 1px solid #999;
                bottom: 50px;
                height: 100%;
                top: 0;
                width: 1px
            }

            .tree li::after {
                border-top: 1px solid #999;
                height: 20px;
                top: 25px;
                width: 25px
            }

            .tree li span {
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
                border: 1px solid #999;
                border-radius: 5px;
                display: inline-block;
                padding: 3px 8px;
                text-decoration: none
            }

            .tree li.parent_li > span {
                cursor: pointer
            }

            .tree > ul > li::before, .tree > ul > li::after {
                border: 0
            }

            .tree li:last-child::before {
                height: 30px
            }

            .tree li.parent_li > span:hover, .tree li.parent_li > span:hover + ul li span {
                background: #eee;
                border: 1px solid #94a0b4;
                color: #000
            }

            .add_color {
                color: #dddddd;
            }

            .dj {
                color: #FF5722;
            }

            .member_id {
                color: #01AAED;
            }
        </style>

        <div class="layui-card-body">
            <div class="main-content" style="margin-left: 0">
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <!-- <div class="panel-body" > -->
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>推荐列表(点击查看下级)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td scope="row">
                                            <div class="tree well">
                                                @if($data->isEmpty())
                                                    暂无数据
                                                @else
                                                    @foreach ($data as $v)
                                                        <ul>
                                                            <li class="parent_li">
                                                                <span data="{{$v['id']}}" dj="1" @if($v['num'] > 0) onclick='span_click($(this));'
                                                                      @else style='color:#d2d2d2;' @endif >
                                                                     <i class="layui-icon layui-icon-top"></i>
                                                                     <font class="dj">顶级</font>
                                                                     <b style="color: black">/</b>
                                                                     <font class="member_id" >{{$v['new_account']}} | {{$v['nickname']}} | {{$v['level_name']}} | {{$v['is_bonus']}} | {{$v['is_admin']}} </font>| {{$v['id']}} | {{$v['mobile']}}
                                                                </span>
                                                                <ul>

                                                                </ul>
                                                            </li>
                                                        </ul>
                                                        <ul>
                                                            <li class="parent_li">
                                                            </li>
                                                        </ul>

                                                    @endforeach
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <!-- </div> -->
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        layui.use('form', function () {
            let form = layui.form;
            form.render();
            form.render('select', 'test2');
            form.on('submit(selectsub)', function (data) {
                let soso = $('#soso').val();//关键字
                location.href = '/admin/user_relation/index?soso=' + soso;
                return false;
            });
        })

        function span_click(obj) {

            let id = obj.attr('data');
            let dj = Number(obj.attr('dj')) + 1;

            let len = obj.next('ul').children('li').length;
            // console.log(len);
            if (len == 0) {
                $.ajax({
                    url: "/admin/user_relation/index",
                    type: 'post',
                    data: {pid: id, '_token':"{{csrf_token()}}"},
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        // console.log(data);
                        // alert(data.uid)
                        obj.next('ul').html('');
                        for (let i of data['data']) {
                            // console.log(i);
                            let info = "";
                            if (i.num > 0) {
                                info += "<li class='parent_li'>";
                                info += "<span data='" + i.id + "' dj='" + dj + "' onclick=' span_click($(this));' >";
                                info += "<i class='layui-icon layui-icon-add-circle' dj='" + dj + "' ></i> ";
                            } else {
                                info += "<li>";
                                info += "<span style='color:#d2d2d2;'>";
                                info += "<i class='layui-icon layui-icon-close-fill' dj='" + dj + "' ></i> ";
                            }
                            info += "<font class='dj'>" + dj + "级</font>";
                            info += "<b style='color: black'>/</b>";
                            info += '<font class=\'member_id\' >' + i.new_account + ' | ' + i.nickname + ' | ' + i.level_name + ' | '+ i.is_bonus + ' | ' + i.is_admin + ' | ' + '</font>' + i.id + ' | ' + i.mobile;
                            info += '</span>';
                            info += '<ul> </ul>';
                            info += "</li>";
                            obj.next('ul').append(info);
                        }
                    },
                    error: function () {
                        alert('出错了');
                        return false;
                    }
                })
            }
            if (obj.next('ul').is(':visible')) {
                obj.next('ul').hide();
            } else {
                obj.next('ul').show();
            }
        }

    </script>

@stop


