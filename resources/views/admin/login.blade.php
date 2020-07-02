<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>后台系统登录</title>
    <meta name="renderer" content="webkit">
    <script src="/script/login/jquery-1.11.3.min.js"></script>
    <link href="/script/login/bootstrap.min.css" rel="stylesheet">
    <link href="/script/login/login.css" rel="stylesheet">
</head>
<body>
@include('admin.partials.errors')
@include('admin.partials.success')
<div class="container">
    <div class="main_box">
        <div class="setting"><a href="javascript:;" onclick="choose_bg();" title="更换背景"></a></div>
        <form action="/admin/login" method="post" >
            <input id="offset" type="hidden" name="offset" value="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <p class="text-center logo"><img src="/img/logo.jpg"></p>
            <p class="text-center logo" style="font-size:34px;color:#fff;">后台管理系统</p>
            <div class="login_msg text-center"><font color="red"></font></div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon-user">账号</span>
                    <input type="text" class="form-control" id="j_username" name="username" value="" placeholder="登录账号"
                           aria-describedby="sizing-addon-user">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon-password">密码</span>
                    <input type="password" class="form-control" id="j_password" name="password" placeholder="登录密码"
                           aria-describedby="sizing-addon-password">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">验证</span>
                    <input type="text" class="form-control" id="yzm" name="yzm" placeholder="验证码"
                           aria-describedby="sizing-addon-password" style="width:80%;">
                    <span class="input-group-addon" id="captcha" onclick="gettwoma()" style="border: 0;cursor: pointer;">发送</span>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" id="login_ok" class="btn btn-primary btn-lg">&nbsp;登&nbsp;录&nbsp;</button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn btn-default btn-lg">&nbsp;重&nbsp;置&nbsp;</button>
            </div>
        </form>
    </div>
</div>
<script>

    // 获取验证码
    function gettwoma(){

        var name = $('input[name=username]').val();

        $.ajax({
            url:"/admin/common/send",    //请求的url地址
            dataType:"json",   //返回格式为json
            data:{'name':name, '_token': "{{ csrf_token() }}"},
            type:"POST",   //请求方式
            success:function(d){
                if(d.code == 1){
                    alert('发送成功');
                    daojishi();
                }else{
                    alert(d.msg);
                }
            },
            error:function(d){
                alert(d.msg);
            }
        });

    }

    var flag = 1;
    var i = 60;
    function daojishi() {

        i = i - 1;
        var btn = document.getElementById("captcha");
        $(btn).attr("onclick", "")
        $(btn).text(i + '秒')

        if (i == 0) {
            $(btn).attr("onclick", "gettwoma()")
            $(btn).text("发送")
            flag = 1;
            i = 60;
            return;
        }
        setTimeout('daojishi()',1000);
    }

</script>
</body>
</html>
