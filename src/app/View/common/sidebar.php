<div class="col-sm-3">
	<div class="sidebar-module sidebar-module-inset">
		<h4>关于</h4>
		<p><abbr title="Linux Apache MySQL PHP，本站泛指web开发技术">LAMP</abbr> Notes是一个Web开发技术的分享平台，我们希望为广大Web开发人员提供纯粹、高质的内容。任何人都可以在这里注册并投递文章、参与讨论、给文章投票，优秀的内容将会出现在首页。</p>
	</div>
	<div class="sidebar-module">
		<h4>贡献榜</h4>
		<ol class="list-unstyled">
            <?php foreach ($topUsers as $k => $r) : ?>
			<li><?=$k+1?>. <a href="<?=URL('user/view/index', array('id'=>$r['user_name']))?>" title=""><?=$r['nick_name']?></a> (<?=$r['score']?>)</li>
            <?php endforeach;?>
		</ol>
	</div>
	<div class="sidebar-module">
		<h4>优秀源站</h4>
		<ol class="list-unstyled">
            <?php foreach ($topSites as $k => $r) : ?>
                <li><?=$k+1?>. <a href="http://<?=$r['domain']?>" target="_blank" title=""><?=$r['domain']?></a> (<?=$r['score']?>)</li>
            <?php endforeach;?>
		</ol>
	</div>
</div>