<form class="layui-form layui-form-pane" method="post" action="" enctype="multipart/form-data" style="padding: 30px;">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <input type="hidden" name="status" value="3">

    <div class="layui-form-item">
        <label class="layui-form-label">返回余额</label>
        <div class="layui-input-inline" style="width:80%;">
            <input type="number" name="amount" lay-verify="required"
                   style="width:300px;float: left;" autocomplete="off" value="{{$amount}}" class="layui-input">
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
                    "{{url('admin/business_auth/ajax')}}",
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
