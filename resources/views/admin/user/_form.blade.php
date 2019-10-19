
<div class="layui-form-item">
    <label class="layui-form-label">昵称</label>
    <div class="layui-input-block">
        <input type="text" name="nickname" maxlength="120" autocomplete="off" value="{{$nickname}}" class="layui-input" required>
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">手机</label>
    <div class="layui-input-block">
        <input type="text" name="mobile" maxlength="120" autocomplete="off" value="{{$mobile}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">密码</label>
    <div class="layui-input-block">
        <input type="password" name="password" autocomplete="off" value="" class="layui-input" @if(!isset($id)) required @else placeholder="不填写表示不改密码" @endif>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">交易密码</label>
    <div class="layui-input-block">
        <input type="password" name="transaction_password" autocomplete="off" value="" class="layui-input" @if(!isset($id)) required @else placeholder="不填写表示不改交易密码" @endif>
    </div>
</div>

@if(isset($id))
<div class="layui-form-item">
    <label class="layui-form-label">用户级别</label>
    <div class="layui-input-block">
        <select name="level_id">

            @if(!empty($levels))
                @foreach($levels as $k => $v)
                    <option value="{{$k}}" @if($k == $level_id) selected @endif>{{$v}}</option>
                @endforeach
            @endif

        </select>
    </div>
</div>
@endif

@if(!isset($id))
<div class="layui-form-item">
    <label class="layui-form-label">邀请码</label>
    <div class="layui-input-block">
        <input type="text" name="invite_code" autocomplete="off" value="" class="layui-input" required>
    </div>
</div>
@endif

<div class="layui-form-item">

</div>