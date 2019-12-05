<div class="layui-form-item">
    <label class="layui-form-label">用户账号</label>
    <div class="layui-input-block">
        <input type="text" name="account" autocomplete="off" value="{{$account}}" class="layui-input" required>
        <input type="hidden" name="type" autocomplete="off" value="{{$type}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">节点类型</label>
    <div class="layui-input-block">
        <select name="node_type">
        @foreach($nodes as $k => $v)
            <option value="{{$k}}" @if($k==$node_type) selected @endif>{{ $v }}</option>
        @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">

</div>
