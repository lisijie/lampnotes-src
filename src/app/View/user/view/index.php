<?php $this->layout('common/header') ?>

<div class="row">
	<div class="col-sm-12">
        <dl class="dl-horizontal">
            <dt>用户名：</dt>
            <dd><?=$profile['user_name']?></dd>
            <dt>昵称：</dt>
            <dd><?=$profile['nick_name']?></dd>
            <dt>性别：</dt>
            <dd><?=$profile['gender'] ? ($profile['gender']==1?'男':'女') : '保密'?></dd>
            <dt>一句话介绍：</dt>
            <dd><?=$profile['headline']?></dd>
            <dt>注册时间：</dt>
            <dd><?=$this->time($profile['reg_time'])?></dd>
            <dt>个人简介：</dt>
            <dd><?=$profile['resume']?></dd>
        </dl>
	</div>
</div>

<?php $this->layout('common/footer') ?>