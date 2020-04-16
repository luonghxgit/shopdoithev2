<?php $asset = base_url('assets/admin/');
?><div class="login-box">
    <div class="login-logo">
        <a href="<?php echo base_url();?>" style="width:100%;">
            <img src="<?php echo $asset.'images/logo.png';?>" alt="log Admicro" style="width:100%;">
        </a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <div class="login-panel panel panel-default">

            <div class="panel-body">
                <?php if(isset($errors) && $errors != ''): ?>
                    <ul class="errors">
                        <li><?php echo $errors ?></li>
                    </ul>
                <?php endif; ?>
                <form method="post" action="">
                    <?php if(isset($message) && $message){?>
                    <p class="message error"><?php echo $message['msg'];?></p>
                    <?php }?>
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" name="password" type="password" autofocus>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Retype password" name="re_password" type="password" value="">
                        </div>
                        <!--<div class="g-recaptcha" data-sitekey="6LeCai0UAAAAAGUcCKs00l0Z1TSiEusFbM2eNRw_"></div>-->
                        <input type="submit" class="btn btn-lg btn-success btn-block btn-login" value="Reset password" />
                    </fieldset>
                </form>
            </div>
        </div>
        <a href="<?php echo base_url('auth/login');?>" class="text-center">Return login</a>
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
