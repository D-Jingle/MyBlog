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

    <!--富文本编辑器-->
    <script type="text/javascript" src="static/js/wangEditor.min.js"></script>

    <style>
        .title{
            margin-bottom: 20px;
        }
    </style>

</head>
<body>
<!--顶部-->
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
                <a class="list-group-item active" id="write">写文章</a>
                <a class="list-group-item" id="atical">文章管理</a>
                <a class="list-group-item" id="sort">分类管理</a>
                <a class="list-group-item" id="info">个人信息</a>
            </div>
        </div>
    </div>
    <!--右侧-->
    <div class="right-artical">
        <fieldset>
            <legend style="padding: 10px;">发布文章</legend>
            <div class="box2">

            </div>
        </fieldset>
        <div class="title">
            <input id="title" class="form-control input-lg" type="text" placeholder="文章标题" style="width: 83%;display: inline-block">
            <select class="form-control" id="sortList" style="width: 15%;height:46px;display: inline-block"></select>
        </div>
        <div id="editor"></div>
        <button class="btn btn-primary" style="float: right;margin: 10px;" type="primary" id="issue">发布文章</button>
        <button class="btn" style="float: right;margin: 10px;" type="primary" id="clear">清空内容</button>
    </div>
</div>

<script>
    var listGroupLength = $(".list-group-item").length;
    var E = window.wangEditor
    var editor = new E('#editor');
    editor.create();

    // 发布文章
    $("#issue").click(function () {
        var sortid = $("#sortList").val();
        var content = editor.txt.html();
        var title = $('#title').val();
        $.ajax({
            type:"POST",
            url:"<?php echo site_url() ;?>Artical/issue_artial",
            dataType:'json',
            data:{'sortId':sortid,'content':content,'title':title},
            success:function(res){
                console.log(res);
                if(res.code == 0){
                    alert('发布成功！');
                } else {
                    alert("发布失败");
                }
            },
            error:function (err) {
                console.log(err);
            }
        })
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
                    var item = '<option value="'+ res.data[i].type_id +'">'+ res.data[i].type_name +'</option>';
                    $('#sortList').append(item);

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
    });

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
        }
    };

    // for(var i=0; i<listGroupLength; i++){
    //     $('.list-group-item:eq(' + $(this).attr("i") + ')').attr('i',i);
    //     $(".list-group-item").click(function () {
    //         $(".list-group-item").removeClass('active');
    //         $('.list-group-item:eq(' + $(this).attr('i') + ')').addClass('active');
    //     })
    // }

    $('#sort').click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/sort_management';
    })
    $("#info").click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/user_info';
    })
    $('#atical').click(function () {
        window.location.href='<?php echo site_url() ;?>welcome/artical_management';
    })




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





</script>

</body>
</html>