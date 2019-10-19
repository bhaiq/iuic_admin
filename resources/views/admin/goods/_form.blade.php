
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
    <label class="layui-form-label">商品说明</label>
    <div class="layui-input-block">
        <input type="text" name="goods_info" maxlength="120" autocomplete="off" value="{{$goods_info}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">商品价格</label>
    <div class="layui-input-block">
        <input type="number" name="goods_price" autocomplete="off" value="{{ $goods_price }}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">购买币种</label>
    <div class="layui-input-block">
        <select name="coin_type">
            @foreach($coins as $v)
                <option value="{{$v}}">{{$v}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">赠送的矿池数量</label>
    <div class="layui-input-block">
        <input type="number" name="ore_pool" autocomplete="off" value="{{ $ore_pool }}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">商品价值</label>
    <div class="layui-input-block">
        <input type="number" name="buy_count" maxlength="2" autocomplete="off" value="{{ $buy_count }}" class="layui-input" required>
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
