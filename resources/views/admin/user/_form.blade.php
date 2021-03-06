
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

@if(isset($id))
<div class="layui-form-item">
    {{--<label class="layui-form-label">星级社群</label>--}}
    <label class="layui-form-label">运营中心</label>
    <div class="layui-input-block">
        <select name="star_community">

                @foreach($star as $k => $v)
                    <option value="{{$k}}" @if($k == $star_community) selected @endif>{{$v}}</option>
                @endforeach

        </select>
    </div>
</div>
@endif

@if(isset($id))
<div class="layui-form-item">
    <label class="layui-form-label">是否开启能量团队长奖</label>
    <div class="layui-input-block">
        <select name="energy_captain_award">

                @foreach($energy_captain as $k => $v)
                    <option value="{{$k}}" @if($k == $energy_captain_award) selected @endif>{{$v}}</option>
                @endforeach

        </select>
    </div>
</div>
@endif

<div class="layui-form-item">
    <label class="layui-form-label">生态2手续费团队长奖比例</label>
    <div class="layui-input-block">
        <input type="text" name="ecology_team_bl" maxlength="120" autocomplete="off" value="{{$ecology_team_bl}}" class="layui-input" required>
    </div>
</div>

@if(isset($id))
    <div class="layui-form-item">
        <label class="layui-form-label">生态2手续费奖</label>
        <div class="layui-input-block">
            <select name="is_ecology_service">

                @foreach($ecology_service as $k => $v)
                    <option value="{{$k}}" @if($k == $is_ecology_service) selected @endif>{{$v}}</option>
                @endforeach

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
    <label class="layui-form-label">生态2指定领导人伞下管理奖</label>
    <div class="layui-input-block">
        <input type="text" name="ecology_leader_bl" maxlength="120" autocomplete="off" value="{{$ecology_leader_bl}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">

</div>
