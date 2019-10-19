<div class="layui-form-item">
    <label class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" autocomplete="off" value="{{$name}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">矿机图片</label>
    <div class="layui-input-block">
        <button type="button" class="layui-btn" id="test1">上传图片</button>
        <div class="layui-upload-list">
            <img class="layui-upload-img" id="demo1" style="width: 300px;" @if(isset($img)&&!empty($img)) src="{{$img}}" @endif>
            <p id="demoText"></p>
        </div>
        <input type="hidden" name="img" value="{{$img}}">
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">单价</label>
    <div class="layui-input-block">
        <input type="number" name="price" autocomplete="off" value="{{$price}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">赠送的矿池数量</label>
    <div class="layui-input-block">
        <input type="number" name="num" autocomplete="off" value="{{$num}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">算力</label>
    <div class="layui-input-block">
        <input type="number" name="suanli" autocomplete="off" value="{{$suanli}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">有效天数</label>
    <div class="layui-input-block">
        <input type="text" name="valid_day" maxlength="250" autocomplete="off" value="{{$valid_day}}" class="layui-input">
    </div>
</div>

<div class="layui-form-item">

</div>
