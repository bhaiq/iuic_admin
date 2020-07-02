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
        <label class="layui-form-label">是否开通iuic独立管理奖</label>
        <div class="layui-input-inline" style="width:80%;">
            
               <select name="is_independent_management">
              	<option value="1">开通</option>
                <option value="0">关闭</option>   
            </select>
            
        </div>
    </div>
	
  
   	<div class="layui-form-item">
        <label class="layui-form-label">iuic独立管理奖比例</label>
        <div class="layui-input-inline" style="width:80%;">
            <input type="text" name="independent_management_bl" autocomplete="off" value="" class="layui-input">
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
                    "{{url('admin/user/independent_management_adjust')}}",
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
