
    <div class="row">
        <div class="col-sm-12">
            <form method="post" class="form-horizontal" role="form" action="<?= URL('user/account/register') ?>">
                <fieldset>
                    <legend>注册</legend>

                    <?php if ($errMsg): ?>
                        <div class="alert alert-danger" role="alert"><?= $errMsg ?></div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="username" class="control-label col-sm-2">用户名</label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" value="<?= $userName ?>" required="" name="username"
                                   id="username"/>
                            <span class="help-block">3-15个字符, 只允许包含英文、数字和下划线</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label col-sm-2">邮箱</label>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" value="<?= $email ?>" required="" name="email"
                                   id="email"/>
                            <span class="help-block">请填写真实有效的电子邮箱</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="control-label col-sm-2">密码</label>

                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="password" required="" name="password"
                                   placeholder=""/>
                            <span class="help-block">密码长度必须在6个字符以上</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password2" class="control-label col-sm-2">确认密码</label>

                        <div class="col-sm-5">
                            <input type="password" class="form-control" id="password2" required="" name="password2"
                                   placeholder=""/>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">提交注册</button>
                        </div>
                    </div>

                </fieldset>
                <hr>
                <h2 style="font-size:24px">注册须知</h2>

                <p>
                <ol>
                    <li>请使用真实有效的E-Mail注册，注册后密码将发送到您所填写的邮箱。</li>
                    <li>您注册的帐号需要激活后才能使用。</li>
                    <li>遗失密码时需要用到。</li>
                </ol>
                </p>
            </form>
        </div>
    </div>
