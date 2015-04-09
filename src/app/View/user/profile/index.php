<?php $this->layout('common/header') ?>

<div class="row">
    <div class="col-md-12">
        <div class="content">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="<?= URL('user/profile/index') ?>">基本资料</a></li>
                <li role="presentation"><a href="<?= URL('user/profile/password') ?>">密码修改</a></li>
            </ul>

            <br/>

            <form class="form-horizontal" method="post" role="form" action="<?= URL('user/profile/index') ?>">

                <?php if ($errMsg): ?>
                    <div class="alert alert-danger" role="alert"><?= $errMsg ?></div>
                <?php endif; ?>
                <?php if ($sucMsg): ?>
                    <div class="alert alert-success" role="alert"><?= $sucMsg ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">用户名</label>

                    <div class="col-sm-8">
                        <?= $userInfo['user_name'] ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">性别</label>

                    <div class="col-sm-8">
                        <label class="radio-inline"><input name="gender" type="radio" id="sex-none"
                                                           value="0" <?= ($profile['gender'] == 0 ? 'checked' : '') ?> />
                            保密</label>
                        <label class="radio-inline"><input name="gender" type="radio" id="sex-male"
                                                           value="1" <?= ($profile['gender'] == 1 ? 'checked' : '') ?> />
                            男</label>
                        <label class="radio-inline"><input name="gender" type="radio" id="sex-female"
                                                           value="2" <?= ($profile['gender'] == 2 ? 'checked' : '') ?> />
                            女</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-headline" class="control-label col-sm-2">一句话介绍</label>

                    <div class="col-sm-8">
                        <input type="text" name="headline" class="form-control" id="setting-headline" placeholder=""
                               value="<?= $profile['headline'] ?>"/>
                        <span class="help-block">例如：软件工程师 / 硬件爱好者 / 美术设计师</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-birthday" class="control-label col-sm-2">生日</label>

                    <div class="col-sm-8">
                        <input type="text" name="birthday" class="form-control" id="setting-birthday"
                               placeholder="格式 YYYY-MM-DD" value="<?= $profile['birthday'] ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-qq" class="control-label col-sm-2">QQ号码</label>

                    <div class="col-sm-8">
                        <input type="text" name="qq" class="form-control" id="setting-qq" placeholder=""
                               value="<?= $profile['qq'] ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-wechat" class="control-label col-sm-2">微信帐号</label>

                    <div class="col-sm-8">
                        <input type="text" name="wechat" class="form-control" id="setting-wechat" placeholder=""
                               value="<?= $profile['wechat'] ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-weibo" class="control-label col-sm-2">微博地址</label>

                    <div class="col-sm-8">
                        <input type="text" name="weibo" class="form-control" id="setting-weibo" placeholder=""
                               value="<?= $profile['weibo'] ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-city" class="control-label col-sm-2">所在城市</label>

                    <div class="col-sm-8">
                        <input type="text" name="city" class="form-control" autocomplete="off" id="setting-city"
                               placeholder="如：杭州市" value="<?= $profile['city_name'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-address" class="control-label col-sm-2">通讯地址</label>

                    <div class="col-sm-8">
                        <input type="text" name="address" id="setting-address" maxlength="32" placeholder="详细通讯地址"
                               class="form-control" value="<?= $profile['address'] ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="setting-homepage" class="control-label col-sm-2">个人网站</label>

                    <div class="col-sm-8">
                        <input type="url" name="homepage" id="setting-homepage" placeholder="http://example.com"
                               value="<?= $profile['homepage'] ?>" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="setting-resume" class="control-label col-sm-2">自我简介</label>

                    <div class="col-sm-8">
                        <textarea name="resume" id="setting-resume" class="form-control"
                                  rows="6"><?= $profile['resume'] ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">保存设置</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

</div>


<?php $this->layout('common/footer') ?>
