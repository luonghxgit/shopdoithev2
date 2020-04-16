<?php if (!isset($user) || !$user) die;
$username = post_data('username', $user, '');
$type = isset($_POST['type']) ? $_POST['type'] : (isset($type)?$type:'');
?>
<div class="row">
    <div class="col-xs-6">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Account information</h3>
            </div>
            <div class="box-body">
                <form action="" method="post">
                    <?php if (isset($message) && $type==='account') { ?>
                        <!-- alert alert-info alert-dismissible -->
                        <div style="display: block;"
                             class="alert <?php echo $message['success'] ? 'alert-info ' : 'alert-danger '; ?>alert-dismissible"
                             id="message">
                            <button type="button" id="btn-close-msg" class="close" data-dismiss="alert"
                                    aria-hidden="true">×
                            </button>
                            <p id="message-content"><?php echo $message['msg']; ?></p>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input name="username" class="form-control"<?php echo $username ? ' readonly' : '';?> value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="re_password">Password retype:</label>
                        <input type="password" name="re_password" id="re_password" class="form-control">
                    </div>
                    <input type="hidden" name="type" value="account">
                    <button type="submit" class="btn btn-info">Save</button>
                    <?php $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    );?>
                    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" />
                </form>
            </div>
        </div><!-- box account information -->


    </div>
    <div class="col-xs-6">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Thông tin cơ bản</h3>
            </div>
            <div class="box-body">
                <form action="" method="post">
                    <?php if (isset($message) && $type==='info') { ?>
                        <!-- alert alert-info alert-dismissible -->
                        <div style="display: block;"
                             class="alert <?php echo $message['success'] ? 'alert-info ' : 'alert-danger '; ?>alert-dismissible"
                             id="message">
                            <button type="button" id="btn-close-msg" class="close" data-dismiss="alert"
                                    aria-hidden="true">×
                            </button>
                            <p id="message-content"><?php echo $message['msg']; ?></p>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="name">Fullname:</label>
                        <input type="text" name="name" id="name" value="<?php echo post_data('name', $user, ''); ?>"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" name="email" id="email" value="<?php echo post_data('email', $user, ''); ?>"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" name="phone" id="phone" value="<?php echo post_data('phone', $user, ''); ?>"
                               class="form-control">
                    </div>


                    <input type="hidden" name="type" value="info">
                    <button type="submit" class="btn btn-info">Save</button>
                    <?php $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    );?>
                    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" />
                </form>
            </div>
        </div>
    </div>
</div>