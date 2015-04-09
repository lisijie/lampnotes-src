<?php $this->layout('common/header') ?>

<div class="row">
	<div class="col-sm-12">
    <form method="post" class="form-horizontal" role="form" action="<?=URL('user/account/login')?>">
        <input type="hidden" name="refer" value="<?=$refer?>">
        <fieldset>
            <legend>登录</legend>

                <?php if ($errMsg):?>
                <div class="alert alert-danger" role="alert"><?=$errMsg?></div>
                <?php endif;?>

                <div class="form-group">
                    <label for="account" class="control-label col-sm-2">用户名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="account" required="" id="account" placeholder="" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="control-label col-sm-2">密码</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" id="password" required="" name="password" placeholder="" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label><input type="checkbox" name="remember" value="1" /> 记住我一周</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">登录</button>
                    </div>
                </div>

        </fieldset>
        <p>&nbsp;</p>
    </form>
	</div>
</div>

<?php $this->layout('common/footer') ?>