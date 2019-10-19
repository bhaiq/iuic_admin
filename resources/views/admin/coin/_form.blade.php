
<div class="layui-form-item">
    <label class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" maxlength="120" autocomplete="off" value="{{$name}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否法币</label>
    <div class="layui-input-block">
        <select name="is_legal">
            @foreach($is_legal_arr as $k => $v)
                <option value="{{$k}}" @if($is_legal == $k) selected @endif>{{$v}}</option>
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
    <label class="layui-form-label">币种信息</label>
    <div class="layui-input-block">
        <table class="layui-table" id="example2">
            <thead>
                <tr>
                    <th width="80">币种</th>
                    <th width="300">合约值</th>
                    <th width="60">操作</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($coin_types))
                @foreach($coin_types as $v)

                    <tr>
                        <td>
                            <select name="coin_type_arr[]">

                            @foreach($coin_types_arr as $key => $val)
                                <option value="{{$key}}" @if($key == $v['coin_type']) selected @endif>{{$val}}</option>
                            @endforeach

                            </select>
                        </td>
                        <td>
                            <input type="text" name="value_arr[]" value="{{$v['value']}}" class="layui-input" maxlength="120">
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="layui-btn layui-btn-sm layui-btn-danger table_del">删除</a></td>
                        </td>
                    </tr>

                @endforeach
                @endif
            </tbody>
            <tfoot>
            <td colspan="5">
                <a href="javascript:void(0);" class="layui-btn layui-btn-sm layui-btn-normal table_add">新增</a>
            </td>
            </tfoot>
        </table>
    </div>
</div>

<div class="layui-form-item">

</div>
