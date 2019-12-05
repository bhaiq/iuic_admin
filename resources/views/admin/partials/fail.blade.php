@if (Session::has('fail'))

    <div class="layui-row" style="margin-bottom: 20px;">
        <div class="layui-col-xs12">
            <div class="grid-demo" style="padding: 15px 10px;background-color: rgb(255, 87, 34);color:#fff;">{{ Session::get('fail') }}</div>
        </div>
    </div>

@endif