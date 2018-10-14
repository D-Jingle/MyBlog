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
<!--    <link rel="stylesheet" href="static/css/zui.datagrid.css">-->
<!--    <script src="static/js/zui.datagrid.js"></script>-->
    <title>Document</title>
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
                <a class="list-group-item active" id="sort">分类管理</a>
                <a class="list-group-item" id="info">个人信息</a>
            </div>
        </div>
    </div>
    <!--右侧-->
    <div class="right-artical">
        <div class="box">
            <fieldset>
                <legend style="padding: 10px;">分类管理</legend>
                <div class="box2">
                    <table class="table table-striped" style="text-align: center">
                        <thead>
                            <tr>
                                <th style="text-align: center">序号</th>
                                <th style="text-align: center">分类名称</th>
                                <th style="text-align: center">文章数</th>
                                <th style="text-align: center">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        if(localStorage.getItem("username")==null){
            window.location.href='<?php echo site_url() ;?>welcome/login';
        } else {
            if (window.localStorage.getItem('username')) {
                var item =
                    '<li><a> 欢迎' + window.localStorage.getItem('username') + ' </a></li>' +
                    '<li><a href="welcome/issue_artical"><span class="glyphicon glyphicon-user"></span> 个人中心</a></li>' +
                    '<li onclick="logout()"><a href="welcome/to_index"><span class="glyphicon glyphicon-log-in"></span>  &nbsp;&nbsp;注销 </a></li>';
                $(".navbar-right").append(item);
            } else {
                var item = '<li><a href="welcome/regist"><span class="glyphicon glyphicon-user"></span> 注册 </a></li><li><a href="welcome/login"><span class="glyphicon glyphicon-log-in"></span> 登录 </a></li>';
                $(".navbar-right").append(item);
            }

            // 请求分类
            $.ajax({
                type: 'GET',
                url: "<?php echo site_url();?>/Sort/get_sort_by_userid",
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if (res.code == 0) {
                        for (var i = 0; i < res.data.length; i++) {
                            var item = '<tr> <td>' + (i + 1) + '</td> <td>' + res.data[i].type_name + '</td> <td>3</td> <td style="padding: 0;"><button class="btn btn-danger delete_sort" type="button" id="' + res.data[i].type_id + '">删除</button> </td> </tr>';
                            $('tbody').append(item);
                        }
                        $('.delete_sort ').click(function () {
                            // console.log($(this).attr('id'));
                            var confirm = window.confirm('此分类下的文章都将删除！');
                            console.log(confirm);
                            if (confirm) {
                                $.ajax({
                                    type: "GET",
                                    url: '<?php echo site_url();?>/Sort/delete_sort_by_sortid?sortid=' + $(this).attr('id'),
                                    dataType: 'json',
                                    success: function (res) {
                                        console.log(res);
                                        if (res.code == 0) {
                                            alert('删除成功!');
                                        } else {
                                            alert('删除失败！');
                                        }
                                    },
                                    error: function (err) {
                                        alert('删除失败!');
                                        console.log(err);
                                    }
                                })
                            }
                        })
                    } else {
                        alert('fail');
                    }
                },
                error: function (err) {
                    alert('fail');
                    console.log(err);
                }
            })
        }
    };

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
    $("#info").click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/user_info';
    })
    $('#atical').click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/artical_management';
    })





</script>

</body>
</html>