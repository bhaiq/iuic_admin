{{--<div class="layui-form-item">--}}
    {{--<label class="layui-form-label">奖励名称</label>--}}
    {{--<div class="layui-input-block">--}}
        {{--<input type="text" name="name" maxlength="50" autocomplete="off" value="{{$name}}" class="layui-input" required>--}}
    {{--</div>--}}
{{--</div>--}}

<div class="layui-form-item">
    <label class="layui-form-label">奖励占分红手续费的比例</label>
    <div class="layui-input-block">
        <input type="text" name="tip" maxlength="10" autocomplete="off" value="{{$tip}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">指定的用户</label>
    <div class="layui-input-block">
        <select name="ids[]" xm-select="example10_1" xm-select-search="" xm-select-search-type="dl">
            @if(!empty($user_arr))
                @foreach($user_arr as $v)
                    <option value="{{$v['id']}}" @if(in_array($v['id'], $users)) selected @endif>{{$v['mobile']}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="layui-form-item">

</div>
