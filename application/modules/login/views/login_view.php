<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <!-- Bootstrap -->
    <link href="<?php echo base_url('assets/gentelella/') ?>vendors/bootstrap/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('assets/gentelella/') ?>vendors/font-awesome/css/font-awesome.min.css"
          rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url('assets/gentelella/') ?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url('assets/gentelella/') ?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css"
          rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url('assets/gentelella/') ?>vendors/bootstrap-daterangepicker/daterangepicker.css"
          rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('assets/gentelella/') ?>build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form action="" method="post">
                    <h1>Đăng nhập hệ thống</h1>
                    <?php if (isset($message) && $message) { ?>
                        <p class="message error"><?php echo $message['msg']; ?></p>
                    <?php } ?>
                    <div>
                        <input name="username" type="text" class="form-control" placeholder="Username" required=""/>
                    </div>
                    <div>
                        <input name="password" type="password" class="form-control" placeholder="Password" required=""/>
                    </div>
                    <div>
                        <button class="btn btn-primary submit" type="submit">Đăng nhập</button>

                    </div>
                    <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
<style>
    .login {
        background: url('<?php echo base_url('publics/images')?>/login_bg.jpg') 100% 100% fixed no-repeat;
    }

    .login_wrapper {
        max-width: 500px;
    }

    .login_form {
        padding: 50px;
        border: 1px #ccc solid;
        background: rgba(255, 255, 255, .9);
        border-radius: 30px;
    }

    .login_content h1 {
        color: brown;
    }
    .error{
        color: red;
        font-size: 16px;
    }
</style>
</body>
</html>
