<form class="layui-form layui-form-pane" method="post" action="" enctype="multipart/form-data" style="padding: 30px;">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">

    <div class="layui-form-item">
        <label class="layui-form-label">帐号</label>
        <div class="layui-input-inline" style="width:80%;">
            <div style="padding: 10px;">{{$new_account}}</div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">当前等级</label>
        <div class="layui-input-inline" style="width:80%;">
            <div style="padding: 10px;">
                @if($energy_head_lv == 3)
                    三级
                @elseif($energy_head_lv == 2)
                    二级
                @elseif($energy_head_lv == 1)
                    一级
                @else
                    没有等级
                @endif

            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">调整等级</label>
        <div class="layui-input-inline" style="width:80%;">
            <select name="energy_head_lv">
              	<option value="0">无等级</option>
                <option value="1">一级</option>
                <option value="2">二级</option>
                <option value="3">三级</option>
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
                    "{{url('admin/user/enery_head_lv_adjust')}}",
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
