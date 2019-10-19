<div class="layui-form-item">
    <label class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" autocomplete="off" value="{{$name}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">单价</label>
    <div class="layui-input-block">
        <input type="number" name="price" autocomplete="off" value="{{$price}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">状态</label>
    <div class="layui-input-block">
        <input type="radio" name="status" value="0" title="关闭" @if($status == 0) checked @endif>
        <input type="radio" name="status" value="1" title="开启" @if($status == 1) checked @endif>
    </div>
</div>

<div class="layui-form-item">

</div>
