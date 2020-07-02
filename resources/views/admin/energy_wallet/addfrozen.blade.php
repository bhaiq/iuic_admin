<form class="layui-form layui-form-pane" method="post" action="" enctype="multipart/form-data" style="padding: 30px;">
    @csrf
    <input type="hidden" name="id" value="{{$uid}}">
    <input type="hidden" name="type" value="1">

    <div class="layui-form-item">
        <label class="layui-form-label">能量矿池</label>
        <div class="layui-input-inline" style="width:80%;">
            <div style="padding: 10px;">{{$amount_freeze}}</div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label" style="visibility: hidden;"></label>
        <div class="layui-input-inline" style="width:80%;">
            <a href="javascript:void(0)" class="layui-btn cc_add layui-btn-xs layui-btn-primary">增加</a>
        </div>
    </div>

    <div class="layui-form-item cc_inp" style="display: none">
        <label class="layui-form-label">增加余额</label>
        <div class="layui-input-inline" style="width:80%;">
            <input type="number" name="num" lay-verify="required" value="0"
                   style="width:300px;float: left;" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script>
    //Demo
    layui.use(['form'], function () {
        var form = layui.form;
        form.render();
        //监听提交
        form.on('submit(formDemo)', function (data) {
            layer.confirm('确认执行此操作？', {icon: 3, title: '提示'}, function (index) {

                $.post(
                    "{{url('admin/energy_wallet/addfrozen')}}",
                    data.field,
                    function (d) {
                        layer.close();
                        layer.closeAll();
                        layer.msg(d.msg);
                        if (d.code == 1) {
                            location.href = location.href;
                        }
                    }
                );

            });
            return false;
        });

    });
</script>
<script>
    $(document).ready(function () {
        $('.cc_add').click(function () {

            $(this).addClass('layui-btn-normal');
            $(this).removeClass('layui-btn-primary');
            $('.cc_sub').addClass('layui-btn-primary');
            $('.cc_sub').removeClass('layui-btn-normal');

            $('.cc_inp').find('.layui-form-label').html('增加余额');

            $('input[name=type]').val(1);

            $('.cc_inp').css({
                'display': 'block'
            });

            $('input[name=num]').val(0);

        });

        $('.cc_sub').click(function () {

            $(this).addClass('layui-btn-normal');
            $(this).removeClass('layui-btn-primary');
            $('.cc_add').addClass('layui-btn-primary');
            $('.cc_add').removeClass('layui-btn-normal');

            $('.cc_inp').find('.layui-form-label').html('减少余额');

            $('input[name=type]').val(2);

            $('.cc_inp').css({
                'display': 'block'
            });

            $('input[name=num]').val(0);

        });
    });
</script>
