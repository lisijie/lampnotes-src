<?php $this->layout('common/header') ?>

<div class="row">
    <div class="col-sm-12">
	    <fieldset>
		    <legend>投递</legend>
            <form method="post" class="form-horizontal" role="form" action="<?=URL('main/submit/post')?>">
	            <?php if (isset($errMsg)) :?>
	            <div class="alert alert-warning" role="alert"><?=$errMsg?></div>
	            <?php endif; ?>
	            <div class="form-group">
		            <label for="title" class="col-sm-1 control-label">标题：</label>
		            <div class="col-sm-8">
			            <input type="text" name="title" class="form-control" id="title" placeholder="" required="" />
		            </div>
	            </div>
                <div class="form-group">
                    <label for="title" class="col-sm-1 control-label">URL：</label>
                    <div class="col-sm-8">
                        <input type="text" name="url" class="form-control" id="url" placeholder="" />
                    </div>
                </div>
	            <div class="form-group">
		            <label for="title" class="col-sm-1 control-label">内容：</label>
		            <div class="col-sm-8">
			            <textarea name="content" class="form-control" rows="5"></textarea>
		            </div>
	            </div>

                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-1">
                        <button type="submit" class="btn btn-primary">发布话题</button>
                    </div>
                </div>

	            <div>
		            <p class="text-muted">
			            说明：<br />
		            <ol class="text-muted">
			            <li>URL和内容至少填写一个</li>
			            <li>如果URL为空，则发表为讨论帖</li>
			            <li>内容长度不能超过255个字符</li>
                        <li>标题以“<strong>讨论:</strong>”开头则发表为讨论贴</li>
                        <li>标题以“<strong>招聘:</strong>”开头则发表为招聘信息</li>
		            </ol>
		            </p>
	            </div>
            </form>
		</fieldset>
    </div>
</div>


<?php $this->layout('common/footer') ?>
