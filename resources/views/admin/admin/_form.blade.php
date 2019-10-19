

<div class="layui-form-item">
    <label class="layui-form-label">用户名</label>
    <div class="layui-input-block">
        <input type="text" name="name" maxlength="120" autocomplete="off" value="{{$name}}" class="layui-input" required>
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">邮箱</label>
    <div class="layui-input-block">
        <input type="email" name="email" maxlength="120" autocomplete="off" value="{{$email}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">密码</label>
    <div class="layui-input-block">
        <input type="password" name="password" autocomplete="off" value="" class="layui-input" @if(!isset($id)) required @else placeholder="不填写表示不改密码" @endif>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-row">
        <div class="layui-col-xs1">
            <label class="layui-form-label">角色列表：</label>
        </div>
        @if(isset($id)&&$id==1)
            <div class="layui-col-xs6" style="float:left;padding-left:20px;margin-top:8px;"><h2>超级管理员</h2></div>
        @else
            <div class="layui-col-xs6" style="float:left;padding-left:20px;margin-top:8px;">
                @foreach($rolesAll as $v)
                    <div class="layui-col-xs3"  style="float:left;">
                        <input id="inputChekbox{{$v['id']}}"
                               @if(in_array($v['id'],$roles))
                               checked
                               @endif
                               type="radio" name="role[]" title="{{$v['name']}}" lay-skin="primary" value="{{$v['id']}}">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="layui-form-item">

</div>
