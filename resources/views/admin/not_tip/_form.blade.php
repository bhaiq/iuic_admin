<div class="layui-form-item">
    <label class="layui-form-label">免手续费用户</label>
    <div class="layui-input-block">
        <select name="uid" lay-verify="required" lay-search="">
            @foreach($users as $v)
                <option value="{{$v['id']}}" @if($v['id'] == $uid) selected @endif>{{$v['mobile']}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">

</div>
