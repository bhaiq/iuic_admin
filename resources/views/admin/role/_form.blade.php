


<div class="layui-form-item">
    <label class="layui-form-label">角色名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" autocomplete="off" value="{{$name}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">备注</label>
    <div class="layui-input-block">
        <input type="text" name="description"  autocomplete="off" value="{{$description}}" class="layui-input" required>
    </div>
</div>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>权限列表</legend>
</fieldset>

<div class="layui-form-item">
    @if($permissionAll)
        @foreach($permissionAll[0] as $v)
            <div class="layui-row" style="padding: 20px 0;">
                <div class="layui-col-xs1">
                    <label class="layui-form-label">{{$v['label']}}：</label>
                </div>
                <div class="layui-col-xs6">
                    @if(isset($permissionAll[$v['id']]))
                        @foreach($permissionAll[$v['id']] as $vv)
                            <div class="layui-col-xs3"  style="float:left;padding-left:20px;margin-top:8px;">
                                <input id="inputChekbox{{$vv['id']}}"
                                       @if(in_array($vv['id'],$permissions))
                                       checked
                                       @endif
                                       type="checkbox" name="permissions[]" lay-skin="primary" title="{{$vv['label']}}" value="{{$vv['id']}}">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="layui-form-item">

</div>
