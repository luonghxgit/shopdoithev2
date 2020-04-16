<?php $asset = base_url('assets/admin/');
?><div class="login-box">
    <div class="login-logo">
        <a href="<?php echo base_url();?>" style="width:100%;">
            <img src="<?php echo $asset.'images/logo.png';?>" alt="log Admicro" style="width:100%;">
            <b><?php echo isset($page_title) ? $page_title : 'Tool drop ship';?></b>
        </a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <div class="login-panel panel panel-default">

            <div class="panel-body">
                <form method="post" action="">
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" name="password" type="password" value="">
                        </div>
                        <!--<div class="g-recaptcha" data-sitekey="6LeCai0UAAAAAGUcCKs00l0Z1TSiEusFbM2eNRw_"></div>-->
                        <input type="submit" class="btn btn-lg btn-success btn-block btn-login" value="Login" />
                    </fieldset>
                </form>
            </div>
        </div>
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog" style="width:300px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="text-align: center">
                    <?php if(isset($message) && $message){?>
                        <p class="message error"><?php echo $message['msg'];?></p>
                    <?php }?></h4>
            </div>
            <div class="modal-footer">
                <a id="return_back" href="<?php echo base_url('auth/login')?>" type="button" class="btn btn-primary" style="display:block;margin:0 auto;" data-dismiss="modal">Return login</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            var $modal = $('#modal-default');
            $modal.modal('show');
            $modal.click(function(e){
                if(e.target == $modal[0] || $('#return_back')[0]){
                    console.log('window.location');
                    window.location = '<?php echo base_url('auth/login')?>';
                }
            });

        });
    }(jQuery));
</script>