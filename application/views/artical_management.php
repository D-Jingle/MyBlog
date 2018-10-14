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
                <a class="list-group-item active" id="atical">文章管理</a>
                <a class="list-group-item" id="sort">分类管理</a>
                <a class="list-group-item" id="info">个人信息</a>
            </div>
        </div>
    </div>
    <!--右侧-->
    <div class="right-artical">
        <div class="box">
            <fieldset>
                <legend style="padding: 10px;">文章管理</legend>
                <div class="box2">
                    <table class="table table-striped" style="text-align: center">
                        <thead>
                            <tr>
                                <th style="text-align: center">序号</th>
                                <th style="text-align: center">标题</th>
                                <th style="text-align: center">分类</th>
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
    var SORT = {};
    var ARTICAL = {};
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
                        SORT = res.data;
                    } else {
                        alert('fail');
                    }
                    // 请求所有文章
                    $.ajax({
                        type: "GET",
                        url: "<?php echo site_url();?>Artical/get_artical_by_userid",
                        dataType: 'json',
                        success: function (res) {
                            if (res.code == 0) {
                                ARTICAL = res.data;
                                var item = '<div class="row item-list"><a class="card"><img src="" alt=""><div class="card-heading"><strong></strong></div><div class="card-content text-muted"></div><div class="card-actions"><button type="button" class="btn btn-danger"></i>查看文章</button><div class="pull-right text-danger"> 520 人喜欢</div></div></a></div>'
                                for (var i = 0; i < res.data.length; i++) {
                                    var item = '<tr> <td>' + (i + 1) + '</td> <td>' + res.data[i].title + '</td> <td>' + get_sortname(res.data[i].type_id) + '</td> <td style="padding: 0;"><button class="btn btn-danger delete_artical" type="button" id="' + res.data[i].article_id + '">删除</button> <button class="btn btn-info edit_artical" type="button" id="' + res.data[i].article_id + '">编辑</button> </td> </tr>';
                                    $('tbody').append(item);
                                }
                                $('.edit_artical').click(function () {
                                    window.location.href = '<?php echo site_url();?>/artical/edit_artical?articalId=' + $(this).attr('id');
                                })


                                $('.delete_artical').click(function () {
                                    // console.log($(this).attr('id'));
                                    var confirm = window.confirm('确定删除？');
                                    if (confirm) {
                                        $.ajax({
                                            type: "GET",
                                            url: '<?php echo site_url();?>Artical/delete_artical_by_id?artical_id=' + $(this).attr('id'),
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
                            console.log(res);
                        },
                        error: function (err) {
                            alert(err);
                        }
                    });
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

    // 根据分类id获取分类名称
    function get_sortname(id){
        for(var i=0; i<SORT.length; i++){
            if(SORT[i].type_id == id){
                return SORT[i].type_name;
            }
        }
    }

    $("#write").click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/issue_artical';
    })
    $("#info").click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/user_info';
    })
    $('#sort').click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/sort_management';
    })





    </script>

</body>
</html>