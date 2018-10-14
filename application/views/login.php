<!doctype html>
<html lang="en">
<head>
    <base href="<?php echo site_url() ;?>">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/login.css">
    <title>Document</title>
</head>
<body>
<div>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <form id="form1" class="form-horizontal" action="welcome/check_login" method="post" onsubmit="return toVaild()">
                    <span class="heading">用户登录</span>
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputName3" placeholder="用户名" name="username">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="form-group help">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="密码" name="password">
                        <i class="fa fa-lock"></i>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn" id="regist" style="border: 1px solid #00b4ef; color: #00b4ef; background-color: #fff;">点击注册</button>
                        <button type="submit" class="btn" id="login">立刻登录</button>
                    </div>
                    <span class="error" style="color: red">
                        <?php echo isset($err)?$err:'';?>
                    </span>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('#regist').click(function () {
            console.log('aaa');
            window.location.href='<?php echo site_url() ;?>welcome/regist';
        });

        function toVaild(){
            if($('#inputName3').val()!='' && $('#inputPassword3').val()!=''){
                localStorage.setItem('username', $('#inputName3').val());
                return true;
            } else {
                alert('请输入用户名和密码');
                return false;
            }
        }

    </script>

</div>
</body>
</html>