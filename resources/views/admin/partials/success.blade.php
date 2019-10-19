@if (Session::has('success'))

    <div class="layui-row" style="margin-bottom: 20px;">
        <div class="layui-col-xs12">
            <div class="grid-demo" style="padding: 15px 10px;background-color: rgb(99, 186, 121);color:#fff;">{{ Session::get('success') }}</div>
        </div>
    </div>

@endif