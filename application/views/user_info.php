<!doctype html>
<html lang="en">
<head>
    <base href="<?php echo site_url() ;?>">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="static/css/zui.css">
    <link rel="stylesheet" href="static/css/zui-theme.css">
    <link rel="stylesheet" href="static/css/zui.lite.css">
    <!-- Bootstrap -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="static/css/index.css">
    <title>Document</title>
    <style>
        table
        {
            width:70%;
        }
        tr td:nth-child(even)
        {
            height:45px;
            padding-left: 80px;
        }
        .box2{
            display: flex;
            height: 100%;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="welcome/to_index">玳玳花的亲嘴烧</a>
        </div>
        <ul class="nav navbar-nav navbar-right"></ul>
    </div>
</nav>
<div class="bigbox">
    <!--左侧-->
    <div class="left-nav">
        <div class="box">
            <div class="list-group">
                <a class="list-group-item" id="write">写文章</a>
                <a class="list-group-item" id="atical">文章管理</a>
                <a class="list-group-item" id="sort">分类管理</a>
                <a class="list-group-item active" id="info">个人信息</a>
            </div>
        </div>
    </div>
    <!--右侧-->
    <div class="right-artical">
        <fieldset>
            <legend style="padding: 10px;">个人信息</legend>
        <div class="box2">
            <table border="0">
                <tr>
                    <td>用户名：</td>
                    <td>
                        <input type="text" class="form-control" placeholder="用户名" id="username">
                    </td>
                </tr>
                <tr>
                    <td>密码：</td>
                    <td><input type="password" class="form-control" placeholder="密码" id="password"></td>
                </tr>
                <tr>
                    <td>邮箱：</td>
                    <td><input type="email" class="form-control" placeholder="邮箱" id="email"></td>
                </tr>
                <tr>
                    <td>性别：</td>
                    <td>
                        <select class="form-control" id="sex">
                            <option value="1">男</option>
                            <option value="2">女</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>电话号码：</td>
                    <td><input type="text" class="form-control" placeholder="电话号" id="tel"></td>
                </tr>
                <tr>
                    <td>qq号码：</td>
                    <td><input type="text" class="form-control" placeholder="qq号" id="qq"></td>
                </tr>
                <tr>
                    <td>居住地：</td>
                    <td>
                        <input type="text" class="form-control" placeholder="居住地址" id="address">
                    </td>
                </tr>
                <tr>
                    <td>出生日期：</td>
                    <td>
                        <input type="date" class="form-control" id="birthday">
                    </td>
                </tr>
                <tr>
                    <td>心情签名：</td>
                    <td>
                        <textarea class="form-control" rows="3" placeholder="心情签名" id="mood"></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button class="btn btn-block btn-primary" style="margin-top: 20px" type="button" id="submit">确认修改</button>
                    </td>
                </tr>
            </table>
        </div>
        </fieldset>
    </div>
</div>
<script>
    var userinfo = {};
    window.onload = function () {
        if(localStorage.getItem("username")==null){
            window.location.href='<?php echo site_url() ;?>welcome/login';
        } else {
            if (window.localStorage.getItem('username')) {
                var item =
                    '<li><a> 欢迎' + window.localStorage.getItem('username') + ' </a></li>' +
                    '<li><a href="welcome/issue_artical"><span class="glyphicon glyphicon-user"></span> 个人中心</a></li>' +
                    '<li onclick="logout()"><a href="welcome/to_index"><span class="glyphicon glyphicon-log-in"></span>  &nbsp;&nbsp;注销 </a></li>';                $(".navbar-right").append(item);
            } else {
                var item = '<li><a href="welcome/regist"><span class="glyphicon glyphicon-user"></span> 注册 </a></li><li><a href="welcome/login"><span class="glyphicon glyphicon-log-in"></span> 登录 </a></li>';
                $(".navbar-right").append(item);
            }

            $.ajax({
                type: 'GET',
                url: "<?php echo site_url();?>Welcome/get_userinfo",
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if (res.code == 0) {
                        $("#username").val(res.info.username);
                        $("#password").val(res.info.password);
                        $("#email").val(res.info.email);
                        $("#sex").val(res.info.sex);
                        $("#tel").val(res.info.tel);
                        $("#qq").val(res.info.qq);
                        $("#address").val(res.info.address);
                        $("#birthday").val(res.info.birthday);
                        $("#mood").val(res.info.mood);
                    } else {
                        alert('获取用户信息失败');
                    }
                },
                error: function (err) {
                    console.log(err);
                    alert("获取用户信息失败");
                }
            })
        }
    };

    // 获取修改信息
    function get_userinfo_from_table(){
        userinfo.username = $("#username").val();
        userinfo.password = $("#password").val();
        userinfo.email = $("#email").val();
        userinfo.sex = $("#sex").val();
        userinfo.tel = $("#tel").val();
        userinfo.qq = $("#qq").val();
        userinfo.address = $("#address").val();
        userinfo.birthday = $("#birthday").val();
        userinfo.mood = $("#mood").val();
    }

    // 提交修改
    $("#submit").click(function () {
        if($("#tel").val().length!=11 && $("#tel").val().length!=''){
            alert('请输入正确的手机号');
        } else {
            get_userinfo_from_table();
            $.ajax({
                type:"POST",
                url:"<?php echo site_url() ;?>Welcome/update_userinfo",
                dataType:'json',
                data:userinfo,
                success:function (res) {
                    console.log(res);
                    if(res.code == 0){
                        alert("修改成功");
                        window.location.reload();
                    } else {
                        alert("修改失败");
                    }
                },
                error:function (err) {
                    console.log(err);
                    alert('修改失败');
                }
            })
        }
    });

    function logout(){
        window.localStorage.clear();
        $.ajax({
            type:"GET",
            url:"<?php echo site_url() ;?>Welcome/logout",
            dataType:'json',
            success:function (res) {
                console.log(res);
                if(res.code == 0){
                    window.location.href='<?php echo site_url() ;?>welcome/login';
                    console.log("注销成功");
                } else {
                    console.log('注销失败');
                }
            }
        })
    }

    $("#write").click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/issue_artical';
    })
    $('#sort').click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/sort_management';
    })
    $('#atical').click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/artical_management';
    })

</script>

</body>
</html>