<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.ico">
    <title>哎呀…您访问的页面不存在 - <?= $site['name'] ?></title>
    <style>
        * {
            margin: 0;
            padding: 0
        }

        body {
            font-family: "微软雅黑";
            background: #DAD9D7
        }

        img {
            border: none
        }

        a * {
            cursor: pointer
        }

        a {
            text-decoration: none;
            outline: none
        }

        a:hover {
            text-decoration: underline
        }

        .bg {
            width: 100%;
            background: url("/static/404/01.jpg") no-repeat center top #DAD9D7;
            position: absolute;
            top: 0;
            left: 0;
            height: 600px;
            overflow: hidden
        }

        .cont {
            margin: 0 auto;
            width: 500px;
            line-height: 20px;
        }

        .c1 {
            height: 360px;
            text-align: center
        }

        .c1 .img1 {
            margin-top: 180px
        }

        .cont h2 {
            text-align: center;
            color: #555;
            font-size: 18px;
            font-weight: normal;
            height: 35px
        }

        .c2 {
            height: 35px;
            text-align: center
        }

        .c2 a {
            display: inline-block;
            margin: 0 4px;
            font-size: 14px;
            height: 23px;
            color: #626262;
            padding-top: 1px;
            text-decoration: none;
            text-align: left
        }

        .c2 a:hover {
            color: #626262;
            text-decoration: none;
        }

        .c2 a.home {
            width: 66px;
            background: url("/static/404/02.png");
            padding-left: 30px
        }

        .c2 a.home:hover {
            background: url("/static/404/02.png") 0 -24px
        }

        .c2 a.home:active {
            background: url("/static/404/02.png") 0 -48px
        }

        .c2 a.re {
            width: 66px;
            background: url("/static/404/03.png");
            padding-left: 30px
        }

        .c2 a.re:hover {
            background: url("/static/404/03.png") 0 -24px
        }

        .c2 a.re:active {
            background: url("/static/404/03.png") 0 -48px
        }

        .c2 a.sr {
            width: 153px;
            background: url("/static/404/04.png");
            padding-left: 28px
        }

        .c2 a.sr:hover {
            background: url("/static/404/04.png") 0 -24px
        }

        .c2 a.sr:active {
            background: url("/static/404/04.png") 0 -48px
        }

        .c3 {
            height: 180px;
            text-align: center;
            color: #999;
            font-size: 12px
        }
    </style>
</head>
<body>

<div class="bg">
    <div class="cont">
        <div class="c1"><img src="/static/404/01.png" class="img1"></div>
        <h2>哎呀…您访问的页面不存在</h2>

        <div class="c2">
            <a href="<?= $site['url'] ?>" class="re">返回</a>
            <a href="<?= $site['url'] ?>" class="home">网站首页</a>
            <a href="<?= $site['url'] ?>" class="sr">搜索一下页面相关信息</a>
        </div>
        <div class="c3"><a href="<?= $site['url'] ?>" class="c3">[<?= $site['name'] ?>]</a>提醒您 - 您可能输入了错误的网址，或者该网页已删除或移动
        </div>
    </div>
</div>

</body>
</html>