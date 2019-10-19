

<div class="layui-form-item">
    <label class="layui-form-label">权限规则</label>
    <div class="layui-input-block">
        <input type="text" name="name" autocomplete="off" value="{{$name}}" class="layui-input" required>
        <input type="hidden" class="form-control" name="cid" value="{{ $cid }}" >
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">权限名称</label>
    <div class="layui-input-block">
        <input type="text" name="label" autocomplete="off" value="{{$label}}" class="layui-input" required>
    </div>
</div>

@if($cid == 0 )

<div class="layui-form-item">
    <label class="layui-form-label">图标</label>
    <div class="layui-input-block">
        <input type="text" name="icon" lay-verify="required|title" value="{{$icon ? $icon : "fa fa-bars"}}" autocomplete="off" class="layui-input" required>
    </div>
</div>

@endif

<div class="layui-form-item">
    <label class="layui-form-label">权限概述</label>
    <div class="layui-input-block">
        <input type="text" name="description"  autocomplete="off" value="{{$description}}" class="layui-input">
    </div>
</div>

