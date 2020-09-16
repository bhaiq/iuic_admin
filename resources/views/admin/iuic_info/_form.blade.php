<div class="layui-form-item">
    <label class="layui-form-label">矿池信息描述</label>
    <div class="layui-input-block">
        <input type="text" name="exp" min="1" autocomplete="off" value="{{$exp}}" class="layui-input" required>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">是否使用虚拟数据</label>
    <div class="layui-input-block">
        <select name="is_close">

            @foreach($is_closed as $k => $v)
                <option value="{{$k}}" @if($k == $is_close) selected @endif>{{$v}}</option>
            @endforeach

        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">虚拟值</label>
    <div class="layui-input-block">
        <input type="text" name="value" autocomplete="off" value="{{$value}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">

</div>
