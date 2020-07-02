
<div class="layui-form-item">
    <label class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" maxlength="120" autocomplete="off" value="{{$title}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">轮播图图片</label>
    <div class="layui-input-block">
        <button type="button" class="layui-btn" id="test1">上传图片</button>
        <div class="layui-upload-list">
            <p id="demoText">
                <img class="layui-upload-img" style="max-width: 300px;" id="demo1" @if(isset($img_url)&&!empty($img_url)) src="{{$img_url}}" @endif>
            </p>
        </div>
        <input type="hidden" name="goods_img" value="{{$img_url}}">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">权重</label>
    <div class="layui-input-block">
        <input type="text" name="top" maxlength="3" autocomplete="off" value="{{$top}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">

</div>
