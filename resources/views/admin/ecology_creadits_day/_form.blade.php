<div class="layui-form-item">
    <label class="layui-form-label">日期</label>
    <div class="layui-input-block">
        <input type="text" name="" autocomplete="off" value="{{$day_time}}" class="layui-input" disabled>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">日新增业绩(元)(应结算数)</label>
    <div class="layui-input-block">
        <input type="number" name="" autocomplete="off" value="{{$total_cny}}" class="layui-input" disabled>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">实际结算数</label>
    <div class="layui-input-block">
        <input type="number" step="0.01" min="0.00" max="9999999999.00" name="total_cny_actual" autocomplete="off" value="{{$total_cny_actual}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">结算方式</label>
    <div class="layui-input-block">
        <input type="radio" name="set_status" value="2" title="手动" checked>
        <!-- <input type="radio" name="set_status" value="1" title="自动" disabled> -->
    </div>
</div>


<div class="layui-form-item">

</div>
