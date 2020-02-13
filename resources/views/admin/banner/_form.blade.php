<div class="layui-form-item">
    <label class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" maxlength="3" autocomplete="off" value="{{$title}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">轮播图图片</label>
    <div class="layui-input-block">
        <button type="button" class="layui-btn" id="test1">上传图片</button>
        <div class="layui-upload-list">
            <img class="layui-upload-img" id="demo1" style="width: 300px;" @if(isset($img_url)&&!empty($img_url)) src="{{$img_url}}" @endif>
            <p id="demoText"></p>
        </div>
        <input type="hidden" name="img_url" value="{{$img_url}}">
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">位置权重</label>
    <div class="layui-input-block">
        <input type="number" name="top" maxlength="3" autocomplete="off" value="{{$top}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">类型</label>
    <div class="layui-input-block">
        <select name="type">
            @foreach($types as $k => $v)
                <option value="{{$k}}" @if($k == $type) selected @endif>{{$v}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">内部跳转地址</label>
    <div class="layui-input-block">
        <select name="jump_type">
            @foreach($jump_types as $k => $v)
                <option value="{{$k}}" @if($k == $type) @endif>{{$v}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">外部跳转地址</label>
    <div class="layui-input-block">
        <input type="text" name="jump_url" maxlength="250" autocomplete="off" value="{{$jump_url}}" class="layui-input">
    </div>
</div>


<div class="layui-form-item">

</div>
