<?php $asset = base_url('assets/admin/');
?>
<div class="login-box">
    <!-- /.login-logo -->
    <div class="container">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="login-box-body">
                <div class="login-panel panel panel-default">
                    <div class="login-logo">
                        <h1>Đăng nhập</h1>
                    </div>
                    <div class="panel-body">
                        <?php if (isset($errors) && $errors != ''): ?>
                            <ul class="errors">
                                <li><?php echo $errors ?></li>
                            </ul>
                        <?php endif; ?>
                        <form method="post" action="">
                            <?php if (isset($message) && $message) { ?>
                                <p class="message error"><?php echo $message['msg']; ?></p>
                            <?php } ?>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password"
                                           value="">
                                </div>
                                <!--<div class="g-recaptcha" data-sitekey="6LeCai0UAAAAAGUcCKs00l0Z1TSiEusFbM2eNRw_"></div>-->
                                <input type="submit" class="btn btn-lg btn-success btn-block btn-login" value="Login"/>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
</div><!-- /.login-box -->
