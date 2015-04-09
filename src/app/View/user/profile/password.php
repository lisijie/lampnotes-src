<?php $this->layout('common/header') ?>

<div class="row">
    <div class="col-md-12">
        <div class="content">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"><a href="<?=URL('user/profile/index')?>">基本资料</a></li>
                <li role="presentation" class="active"><a href="<?=URL('user/profile/password')?>">密码修改</a></li>
            </ul>

            <br />

            <form class="form-horizontal" role="form" method="post" action="<?=URL('user/profile/password')?>">
                <?php if ($errMsg):?>
                <div class="alert alert-danger" role="alert"><?=$errMsg?></div>
                <?php endif;?>
                <?php if ($sucMsg):?>
                    <div class="alert alert-success" role="alert"><?=$sucMsg?></div>
                <?php endif;?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-5">
                        <?=$userInfo['user_name']?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-password" class="col-sm-2 control-label">当前密码</label>
                    <div class="col-sm-5">
                        <input type="password" name="password" class="form-control" id="setting-password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-newpassword" class="col-sm-2 control-label">新密码</label>
                    <div class="col-sm-5">
                        <input type="password" name="newpassword" class="form-control" id="setting-newpassword" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-newpassword2" class="col-sm-2 control-label">密码确认</label>
                    <div class="col-sm-5">
                        <input type="password" name="newpassword2" class="form-control" id="setting-newpassword2" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-5">
                        <button type="submit" class="btn btn-primary">保存设置</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

</div>


<?php $this->layout('common/footer') ?>
