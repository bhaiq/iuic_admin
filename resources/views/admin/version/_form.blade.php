
<div class="layui-form-item">
    <label class="layui-form-label">安装包地址</label>
    <div class="layui-input-block">
        <input type="text" name="url" maxlength="120" autocomplete="off" value="{{$url}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">当前版本号</label>
    <div class="layui-input-block">
        <input type="text" name="current_version" maxlength="120" autocomplete="off" value="{{$current_version}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否强制更新</label>
    <div class="layui-input-block">
        <input type="radio" name="is_force" value="0" title="不强制" @if($is_force == 0) checked @endif>
        <input type="radio" name="is_force" value="1" title="强制" @if($is_force == 1) checked @endif>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">系统</label>
    <div class="layui-input-block">
        <input type="radio" name="type" value="0" title="安卓" @if($type == 0) checked @endif>
        <input type="radio" name="type" value="1" title="苹果" @if($type == 1) checked @endif>
    </div>
</div>


<div class="layui-form-item">

</div>
