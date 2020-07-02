<form class="layui-form layui-form-pane" method="post" action="" enctype="multipart/form-data" style="padding: 30px;">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">

    <div class="layui-form-item">
        <label class="layui-form-label">目前用户上级</label>
        <div class="layui-input-inline" style="width:80%;">
            <div style="padding: 10px;">{{$pid_name}}</div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">新的用户上级</label>
        <div class="layui-input-inline" style="width:80%;">
            <select name="pid" lay-verify="required" lay-search="">
                @foreach($users as $v)
                    <option value="{{$v['id']}}" @if($pid == $v['id']) @endif>{{$v['mobile']}}</option>
                @endforeach
            </select>
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
                    "{{url('admin/user/ajax')}}",
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

