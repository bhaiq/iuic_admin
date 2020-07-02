
<div class="layui-form-item">
    <label class="layui-form-label">商品名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" maxlength="120" autocomplete="off" value="{{$name}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">商品图片</label>
    <div class="layui-input-block">
        <button type="button" class="layui-btn" id="test1">上传图片</button>
        <div class="layui-upload-list">
            <p id="demoText">
                <img class="layui-upload-img" style="max-width: 300px;" id="demo1" @if(isset($img)&&!empty($img)) src="{{$img}}" @endif>
            </p>
        </div>
        <input type="hidden" name="img" value="{{$img}}">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">中奖概率(小数)</label>
    <div class="layui-input-block">
        <input type="text" name="zj_bl" autocomplete="off" value="{{ $zj_bl }}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否宣传</label>
    <div class="layui-input-block">
        <input type="radio" name="is_xc" value="0" title="关闭" @if($is_xc == 0) checked @endif>
        <input type="radio" name="is_xc" value="1" title="开启" @if($is_xc == 1) checked @endif>
    </div>
    <div style="font-size: 12px;color:red;">注：这个是控制是否在抽奖实时记录里面宣传</div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">奖品说明</label>
    <div class="layui-input-block">
        <textarea placeholder="请输入说明" class="layui-textarea" name="info" maxlength="200">{{$info}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否展示</label>
    <div class="layui-input-block">
        <input type="radio" name="is_display" value="0" title="不展示" @if($is_display == 0) checked @endif>
        <input type="radio" name="is_display" value="1" title="展示" @if($is_display == 1) checked @endif>
    </div>
    <div style="font-size: 12px;color:red;">注：这个是控制是否在规则里面展示商品说明</div>
</div>

<div class="layui-form-item">

</div>
