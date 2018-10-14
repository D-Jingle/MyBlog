<!doctype html>
<html lang="en">
<head>
    <base href="<?php echo site_url() ;?>">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="static/css/zui.css">
    <link rel="stylesheet" href="static/css/zui-theme.css">
    <link rel="stylesheet" href="static/css/zui.lite.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="static/js/zui.js"></script>
    <script src="static/js/zui.lite.js"></script>
    <link rel="stylesheet" href="static/css/index.css">
    <title>Document</title>
</head>
<body>


<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">玳玳花的亲嘴烧</a>
        </div>
        <ul class="nav navbar-nav navbar-right">

        </ul>
    </div>
</nav>


<div class="container">
    <div class="row item-list">
        <article class="article">
            <header>
                <h1 class="text-center" id="title" style="border: none;"></h1>
                <dl class="dl-inline">
                    <dt>发布于</dt>
                    <dd id="publish-date">维基百科</dd>
                    <dt>最后更改：</dt>
                    <dd id="change-data2"></dd>
                    <dt></dt>
                    <dd class="pull-right"><span class="label label-success">HTML</span> <span class="label label-warning">网页设计</span> <span class="label label-info">W3C</span> <span class="label label-danger"><i class="icon-eye-open"></i> 235</span></dd>
                </dl>
                <section class="abstract">
                    <p><strong>摘要：</strong>HTML5是HTML最新的修订版本，2014年10月由万维网联盟（W3C）完成标准制定。目标是替换1999年所制定的HTML 4.01和XHTML 1.0标准，以期能在互联网应用迅速发展的时候，使网络标准达到匹配当代的网络需求。广义论及HTML5时，实际指的是包括HTML、CSS和JavaScript在内的一套技术组合。</p>
                </section>
            </header>
            <section class="content">
                <p></p>
                <footer>
                    <p class="pull-right text-muted">本文在知识共享 署名-相同方式共享 3.0协议之条款下提供。</p>
                    <p class="text-important">本文节选自 Wikipedia HTML5 词条。</p>
                    <ul class="pager pager-justify">
                        <li class="previous"><a target="_blank" href="https://zh.wikipedia.org/wiki/Category:HTML"><i class="icon-arrow-left"></i> HTML</a></li>
                        <li class="next disabled"><a target="_blank" href="https://zh.wikipedia.org/wiki/Category:W3C%E6%A0%87%E5%87%86">W3C 标准 <i class="icon-arrow-right"></i></a></li>
                    </ul>
                </footer>
        </article>
    </div>
</div>

<script>
    window.onload = function(){
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

            var id = GetRequest();
            $.ajax({
                type: 'GET',
                url: "<?php echo site_url();?>Artical/get_artical_by_id?articalId=" + id.articalId,
                dataType: 'json',
                success: function (res) {
                    if (res.code == 0) {
                        console.log($('#title'));
                        $('#title')[0].innerHTML = res.data.title;
                        $('.content p')[0].innerHTML = res.data.content;
                    }
                    console.log(res);
                },
                error: function (err) {
                    alert(err);
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

    function GetRequest() {
        var url = location.search; //获取url中"?"符后的字串
        var theRequest = new Object();
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            strs = str.split("&");
            for (var i = 0; i < strs.length; i++) {
                theRequest[strs[i].split("=")[0]] = decodeURIComponent(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    }


</script>



</body>
</html>