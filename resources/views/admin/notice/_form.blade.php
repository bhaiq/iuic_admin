<div class="layui-form-item">
    <label class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" maxlength="200" autocomplete="off" value="{{$title}}" class="layui-input" required>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <textarea id="editor" type="text/plain" name="content"  style="width:1024px;height:500px;">{!! htmlspecialchars_decode($content) !!}</textarea>
    </div>
</div>

<div class="layui-form-item">

</div>
