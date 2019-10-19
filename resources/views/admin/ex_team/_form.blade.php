
<div class="layui-form-item">
    <label class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" maxlength="120" autocomplete="off" value="{{$name}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">交易币</label>
    <div class="layui-input-block">
        <select name="coin_id_goods">
            @foreach($jy_coins as $v)
                <option value="{{$v['id']}}" @if($coin_id_goods == $v['id']) selected @endif>{{$v['name']}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">法币</label>
    <div class="layui-input-block">
        <select name="coin_id_legal">
            @foreach($fb_coins as $v)
                <option value="{{$v['id']}}" @if($coin_id_legal == $v['id']) selected @endif>{{$v['name']}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">状态</label>
    <div class="layui-input-block">
        <select name="status">
            @foreach($status_arr as $k => $v)
                <option value="{{$k}}" @if($status == $k) selected @endif>{{$v}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">

</div>
