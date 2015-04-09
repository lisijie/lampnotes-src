<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?=$header['description']?>">
	<meta name="keywords" content="<?=$header['keywords']?>" />
	<meta name="author" content="lsj86@qq.com">
	<link rel="icon" href="favicon.ico">

	<title><?=$header['title']?></title>

	<link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<link href="/static/css/main.css" rel="stylesheet">

	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="/static/js/ie-emulation-modes-warning.js"></script>

	<!--[if lt IE 9]>
	<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
    <script>
        var login_url = '<?=URL('user/account/login')?>';
        var vote_url = '<?=URL('api/topic/vote')?>';
    </script>
</head>


<body>

<div class="blog-masthead">
	<div class="container">
		<nav class="top-nav">
			<h1><a class="top-nav-item" href="http://www.lampnotes.com" title="Web开发技术分享平台">LAMP Notes</a></h1>
			<a class="top-nav-item <?=(CUR_ROUTE == 'main/main/index' ? 'active' : '')?>" href="<?=URL('main/main/index')?>" title="最近热门的文章">热门</a>
			<a class="top-nav-item <?=(CUR_ROUTE == 'main/main/newest' ? 'active' : '')?>" href="<?=URL('main/main/newest')?>" title="查看最新投递的文章">最新</a>
            <a class="top-nav-item <?=(CUR_ROUTE == 'main/main/discuss' ? 'active' : '')?>" href="<?=URL('main/main/discuss')?>" title="话题讨论">讨论</a>
            <a class="top-nav-item <?=(CUR_ROUTE == 'main/main/jobs' ? 'active' : '')?>" href="<?=URL('main/main/jobs')?>" title="由企业发布的招聘信息">招聘</a>
			<a class="top-nav-item <?=(CUR_ROUTE == 'main/submit/index' ? 'active' : '')?>" href="<?=URL('main/submit/index')?>" title="投递新文章">投递</a>

			<span style="float: right">
			<?php if (isset($userInfo['user_id']) && $userInfo['user_id'] > 0) :?>
				<a class="top-nav-item " href="<?=URL('user/profile/index')?>"><?=$userInfo['user_name']?></a> | <a class="top-nav-item" href="<?=URL('user/account/logout')?>">退出</a>
			<?php else :?>
				<a class="top-nav-item" href="<?=URL('user/account/register')?>">注册</a> |
				<a class="top-nav-item" href="<?=URL('user/account/login')?>">登录</a>
			<?php endif;?>
			</span>
		</nav>
	</div>
</div>

<div class="container main-content">
