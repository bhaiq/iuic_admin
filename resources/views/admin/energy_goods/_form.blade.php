
<div class="layui-form-item">
    <label class="layui-form-label">商品名称</label>
    <div class="layui-input-block">
        <input type="text" name="goods_name" maxlength="120" autocomplete="off" value="{{$goods_name}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">商品图片</label>
    <div class="layui-input-block">
        <button type="button" class="layui-btn" id="test1">上传图片</button>
        <div class="layui-upload-list">
            <p id="demoText">
                <img class="layui-upload-img" style="max-width: 300px;" id="demo1" @if(isset($goods_img)&&!empty($goods_img)) src="{{$goods_img}}" @endif>
            </p>
        </div>
        <input type="hidden" name="goods_img" value="{{$goods_img}}">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">商品价格</label>
    <div class="layui-input-block">
        <input type="number" name="goods_price" autocomplete="off" value="{{ $goods_price }}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">本金数量</label>
    <div class="layui-input-block">
        <input type="number" name="num" autocomplete="off" value="{{ $num}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">赠送的能量数</label>
    <div class="layui-input-block">
        <input type="number" name="add_num" autocomplete="off" value="{{ $add_num}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">限购数量</label>
    <div class="layui-input-block">
        <input type="number" name="xg_num" autocomplete="off" value="{{ $xg_num}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">权重</label>
    <div class="layui-input-block">
        <input type="number" name="top" autocomplete="off" value="{{ $top}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">商品详情</label>
    <div class="layui-input-block">
        <textarea id="editor" type="text/plain" name="goods_details" style="width:1024px;height:500px;">{!! htmlspecialchars_decode($goods_details) !!}</textarea>
    </div>
</div>

<div class="layui-form-item">

</div>
