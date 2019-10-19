@extends('admin.base')

@section('pageHeaderOne', '交易所')
@section('pageHeaderTwo', '币种列表')
@section('pageHeaderTwoUrl', '/admin/coin/index')
@section('pageHeaderThree', '编辑币种')

@section('body')

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>编辑币种</legend>
    </fieldset>

    <form class="layui-form" method="POST" action="/admin/coin/{{ $id }}">

        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        @include('admin.coin._form')
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

@stop

@section('js')
    <script>
        //Demo
        layui.use('form', function () {

            var form = layui.form;
            form.render();

            //监听提交
            form.on('submit(demo1)', function (data) {
                layer.confirm('确定提交更新信息吗？', {icon: 3, title: '提示'}, function (index) {
                    console.log(data.field);
                    $.post(
                        "/admin/coin/{{$id}}",
                        data.field,
                        function (d) {
                            layer.close();
                            layer.closeAll();
                            layer.msg(d.msg);
                            if (d.code == 1) {
                                location.href = '/admin/coin';
                            }
                        }
                    );

                });
                return false;
            });

            //点击删除一行
            $(document).on("click",".table_del",function(){
                $(this).parent().parent().remove();
            });

            //点击增加一行
            $('.table_add').click(function(){

                var table_tr = '';
                table_tr += '<tr><td>';
                table_tr += '<select name="coin_type_arr[]">';

                @foreach($coin_types_arr as $k => $v)

                    table_tr += '<option value="{{$k}}">{{$v}}</option>';

                @endforeach

                    table_tr += '</select>';
                table_tr += '</td><td>';

                table_tr += '<input type="text" name="value_arr[]" class="layui-input" maxlength="120">';

                table_tr += '</td><td>';

                table_tr += '<a href="javascript:void(0);" class="layui-btn layui-btn-sm layui-btn-danger table_del">删除</a></td>';

                table_tr += '</td></tr>';

                $('#example2').find('tbody').append(table_tr);

                form.render();
            });

        });
    </script>

@stop


