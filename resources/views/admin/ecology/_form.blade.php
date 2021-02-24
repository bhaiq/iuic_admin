<div class="layui-form-item">
    <label class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" autocomplete="off" value="{{$name}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">考核部门数</label>
    <div class="layui-input-block">
        <input type="number" name="branch_num" autocomplete="off" value="{{$branch_num}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">部门达到等级</label>
    <div class="layui-input-block">
        <select name="branch_level">
            @if(!empty($levels))
                @foreach($levels as $v)
                    <option value="{{$v->id}}" @if($v['id'] == $branch_level) selected @endif>{{$v->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">生态2团队长奖</label>
    <div class="layui-input-block">
        <input type="number" step="0.01" min="0.00" max="1.00" name="rate_bonus" autocomplete="off" value="{{$rate_bonus}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">备注</label>
    <div class="layui-input-block">
        <input type="text" name="remarks" maxlength="250" autocomplete="off" value="{{$remarks}}" class="layui-input">
    </div>
</div>

<div class="layui-form-item">

</div>
