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
</head>
<body>
<!--顶部-->
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
<!--            <img height="22px" src="https://djingle.cn/templates/themes/default/static/img/logo.png" alt="">-->
            <a class="navbar-brand" href="welcome/index">玳玳花的亲嘴烧</a>
        </div>
        <ul class="nav navbar-nav navbar-right"></ul>
    </div>
</nav>

<div class="bigbox">
<!--左侧-->
    <div class="left-nav">
        <div class="box">
            <div class="list-group">
                <a class="list-group-item active" id="sortall">全部</a>
            </div>
        </div>
    </div>
<!--右侧-->
    <div class="right-artical">
        <div class="container">
        </div>

    </div>
</div>
<!--<button id="aaa" style="margin-left: 50rem">aaaaaaa</button>-->

<script>
    var ARTICAL = {};
    var SORT = {};
    var username = window.localStorage.getItem('username');
    //console.log(<?php //echo isset($_SESSION['user_id'])==null?true:false;?>//);/
    window.onload= function(){
        if(localStorage.getItem("username")==null){
            window.location.href='<?php echo site_url() ;?>welcome/login';
        } else {
            if(window.localStorage.getItem('username')){
                var item =
                    '<li><a> 欢迎' + window.localStorage.getItem('username') + ' </a></li>' +
                    '<li><a href="welcome/issue_artical"><span class="glyphicon glyphicon-user"></span> 个人中心</a></li>' +
                    '<li onclick="logout()"><a href="welcome/to_index"><span class="glyphicon glyphicon-log-in"></span>  &nbsp;&nbsp;注销 </a></li>';                $(".navbar-right").append(item);
            } else {
                var item = '<li><a href="welcome/regist"><span class="glyphicon glyphicon-user"></span> 注册 </a></li><li><a href="welcome/login"><span class="glyphicon glyphicon-log-in"></span> 登录 </a></li>';
                $(".navbar-right").append(item);
            }
            // 请求所有文章
            $.ajax({
                type:"GET",
                url:"<?php echo site_url() ;?>Artical/get_artical_by_userid",
                dataType:'json',
                success:function(res){
                    if(res.code == 0){
                        ARTICAL = res.data;
                        var item = '<div class="row item-list"><a class="card"><div class="card-heading"><h3></h3><hr></div><div class="card-content text-muted"></div><div class="card-actions"><button type="button" class="btn btn-danger" style="padding-top: 10px;"></i>查看文章</button><div class="pull-right text-danger"> 520 人喜欢</div></div></a></div>'
                        for(var i=0; i<res.data.length; i++){
                            $("div.container").append(item);
                            $(".card-heading:eq("+i+") h3")[0].innerHTML = res.data[i].title;
                            $(".item-list:eq("+i+") .text-muted")[0].innerHTML = res.data[i].content;
                            $(".item-list:eq("+i+") .btn-danger").attr('id',res.data[i].article_id);
                            $(".item-list:eq("+i+") .btn-danger").click(function () {
                                window.location.href='<?php echo site_url() ;?>/artical/artical_item?articalId='+$(this).attr('id');
                            });
                        }
                    } else {
                        alert('fail');
                    }
                    console.log(res);
                },
                error:function(err){
                    alert(err);
                }
            });
            // 请求分类
            $.ajax({
                type:'GET',
                url:"<?php echo site_url() ;?>/Sort/get_sort_by_userid",
                dataType:'json',
                success:function (res) {
                    if(res.code == 0){
                        SORT = res.data;
                        for(var i=0; i<res.data.length; i++) {
                            var item = '<a class="list-group-item" id="sort' + i + '"></a>';
                            $('.list-group').append(item);
                            $('.list-group').children('.list-group-item')[i + 1].innerText = res.data[i].type_name;
                            // 给每个分类绑定事件
                            $('.list-group .list-group-item:eq(' + (i+1) + ')').attr('i',i+1);
                            $('.list-group .list-group-item:eq(' + (i+1) + ')').attr('sortid',res.data[i].type_id);
                            $('.list-group .list-group-item:eq(' + (i+1) + ')').click(function () {
                                $(".list-group-item").removeClass('active');
                                $("#" + this.id).addClass('active');
                                // console.log($(this).attr('i'));
                                get_artical_by_sortId($(this).attr('sortid'));
                            });
                            $('.list-group .list-group-item:eq(0)').click(function () {
                                get_artical_by_sortId(0);
                            });
                            $("#sortall").click(function () {
                                $(".list-group-item").removeClass('active');
                                $("#sortall").addClass('active');
                            });
                        }
                    } else {
                        alert('fail');
                    }
                    console.log(res);
                },
                error:function (err) {
                    console.log(err);
                    alert(err);
                }
            })
        }


    };

    // 注销
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

    // 请求分类文章
    function get_artical_by_sortId(type_id){
        //全部分类文章
        if(type_id == 0){
            $.ajax({
                type:"POST",
                url:"<?php echo site_url() ;?>Artical/get_artical_by_userid",
                dataType:'json',
                success:function(res){
                    if(res.code == 0){
                        $("div.container").empty();
                        var item = '<div class="row item-list"><a class="card"><div class="card-heading"><h3></h3><hr></div><div class="card-content text-muted"></div><div class="card-actions"><button type="button" class="btn btn-danger"></i>查看文章</button><div class="pull-right text-danger"> 520 人喜欢</div></div></a></div>'
                        for(var i=0; i<res.data.length; i++){
                            $("div.container").append(item);
                            $(".card-heading:eq("+i+") h3")[0].innerHTML = res.data[i].title;
                            $(".item-list:eq("+i+") .text-muted")[0].innerHTML = res.data[i].content;
                            $(".item-list:eq("+i+") .btn-danger").attr('id',res.data[i].article_id);
                            $(".item-list:eq("+i+") .btn-danger").click(function () {
                                window.location.href='<?php echo site_url() ;?>/artical/artical_item?articalId='+$(this).attr('id');
                            });
                        }
                    } else {
                        alert('fail');
                    }
                    console.log(res);
                },
                error:function(err){
                    console.log(err);
                }
            });
        } else {
            // 某一分类文章
            $.ajax({
                type:"POST",
                url:"<?php echo site_url() ;?>/Artical/get_Artical_by_sortid_userid",
                dataType:'json',
                data:{'sortId':type_id},
                success:function(res){
                    if(res.code == 0){
                        $("div.container").empty();
                        var item = '<div class="row item-list"><a class="card"><div class="card-heading"><h3></h3><hr></div><div class="card-content text-muted"></div><div class="card-actions"><button type="button" class="btn btn-danger"></i>查看文章</button><div class="pull-right text-danger"> 520 人喜欢</div></div></a></div>'
                        for(var i=0; i<res.data.length; i++){
                            $("div.container").append(item);
                            $(".card-heading:eq("+i+") h3")[0].innerHTML = res.data[i].title;
                            $(".item-list:eq("+i+") .text-muted")[0].innerHTML = res.data[i].content;
                            $(".item-list:eq("+i+") .btn-danger").attr('id',res.data[i].article_id);
                            $(".item-list:eq("+i+") .btn-danger").click(function () {
                                window.location.href='<?php echo site_url() ;?>/artical/artical_item?articalId='+$(this).attr('id');
                            });
                        }
                    } else {
                        alert('fail');
                    }
                    console.log(res);
                },
                error:function(err){
                    alert(err);
                }
            });
        }
    }



    $("#aaa").click(function () {
        $("div.item-list").append("<p>aaaa<p>");
    });

</script>

</body>
</html>