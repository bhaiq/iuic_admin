<form class="layui-form layui-form-pane" method="post" action="" enctype="multipart/form-data" style="padding: 30px;">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <input type="hidden" name="type" value="1">

    <div class="layui-form-item">
        <label class="layui-form-label">矿池数量</label>
        <div class="layui-input-inline" style="width:80%;">
            <div style="padding: 10px;">{{$num}}</div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">增加数量</label>
        <div class="layui-input-inline" style="width:80%;">
            <select name="good_id">

                @if(!empty($goods))
                    @foreach($goods as $v)
                        <option value="{{$v['id']}}">{{$v['ore_pool']}}</option>
                    @endforeach
                @endif

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
                    "{{url('admin/user/add_ore_pool')}}",
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