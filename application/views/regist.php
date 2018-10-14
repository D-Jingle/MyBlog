<!doctype html>
<html lang="en">
<head>
    <base href="<?php echo site_url() ;?>">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
    <style>
        body{
            font-size: 14px;
        }
        .error{
            color: red;
            margin: 0 20px;
        }
        table{
            border: 1px solid white;
            text-align: left;
        }
        .signin{
            display: inline-block;
        }
        .box{
            text-align: center;
        }
        .title{
            margin: 20px 0;
        }
        .import{
            color: red;
        }

    </style>
</head>
<body>
<div class="box">
    <div class="signin">
        <div class="title">
            <h1>注册信息</h1>
        </div>
        <form action="welcome/save" method="post">
            <table border="1px solid white" title="注册">
                <tr>
                    <td>用户名：<span class="import">*</span></td>
                    <td>
                        <input type="text" class="form-control" name="username">
                    </td>
                    <td>
                        <span class="error">
                            <?php echo isset($err_name)?$err_name:'';?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>密码：<span class="import">*</span></td>
                    <td>
                        <input type='password' class="form-control" name="password">
                    </td>
                    <td>
                        <span class="error">
                            <?php echo isset($err_pwd)?$err_pwd:'';?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>确认密码：<span class="import">*</span></td>
                    <td>
                        <input type='password' class="form-control" name="repassword">
                    </td>
                </tr>
                <tr>
                    <td>性别：<span class="import">*</span></td>
                    <td>
                        <div class="radio">
                            <label>
                                <input type="radio" name="sex" value="1"> 男
                            </label>
                            <label>
                                <input type="radio" name="sex" value="2"> 女
                            </label>
                        </div>
                    </td>
                    <td>
                        <span class="error">
                            <?php echo isset($err_sex)?$err_sex:'';?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>电子邮箱：</td>
                    <td>
                        <input type="email" class="form-control" placeholder="电子邮件" name="email" id="bir">
                    </td>
                </tr>
<!--                <tr>-->
<!--                    <td>生日：</td>-->
<!--                    <td><input type="date" name="birthday">-->
<!--                    </td>-->
<!--                </tr>-->
                <tr>
                    <td >心情签名：</td>
                    <td>
                        <textarea class="form-control" rows="3" placeholder="可以输入多行文本" name="mood"></textarea>
                    </td>
                </tr>
            </table>
            <input class="btn btn-primary" type="submit" value="注册">
            <input class="btn btn-default" type="reset" value="重置">
        </form>
    </div>
</div>

<script>
    function login(){
        window.location.href='<?php echo site_url() ;?>welcome/login';
    }
</script>

</body>
</html>