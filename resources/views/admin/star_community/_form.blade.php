<div class="layui-form-item">
    {{--<label class="layui-form-label">星级社群名字</label>--}}
    <label class="layui-form-label">运营中心名字</label>
    <div class="layui-input-block">
        <input type="text" name="name" min="1" autocomplete="off" value="{{$name}}" class="layui-input" required>
    </div>
</div>
<div class="layui-form-item">
    {{--<label class="layui-form-label">星级社群价格</label>--}}
    <label class="layui-form-label">运营中心价格</label>
    <div class="layui-input-block">
        <input type="number" name="price" min="1" autocomplete="off" value="{{$price}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">拿伞下新增IUIC 报单的业绩的比例</label>
    <div class="layui-input-block">
        <input type="text" name="star_bl" autocomplete="off" value="{{$star_bl}}" class="layui-input" required>
    </div>
    <div style="color: red">
        注：0.01表示1%
    </div>
</div>

<div class="layui-form-item">

</div>
