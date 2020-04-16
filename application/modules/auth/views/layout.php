<?php $asset = base_url('assets/admin/');
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edrop-Dropshipping tool | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo $asset.'bootstrap/css/bootstrap.min.css'; ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $asset.'css/font-awesome.min.css'; ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $asset.'dist/css/AdminLTE.min.css'; ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo $asset.'dist/css/skins/_all-skins.min.css'; ?>">

    <link rel="stylesheet" href="<?php echo $asset.'css/login.css'; ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
        ul.errors{
            display: block;
            list-style-type: disc;
            -webkit-margin-before: 0;
            -webkit-margin-after: 0;
            -webkit-margin-start: 0;
            -webkit-margin-end: 0;
            -webkit-padding-start: 15px;
            margin-bottom: 10px;
        }
        .login-box{
            width: 374px;
        }
        form .btn-login{
            margin-top: 15px;
        }
    </style>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $asset.'/plugins/jQuery/jQuery-2.1.4.min.js' ?>"></script>
</head>
<body class="hold-transition login-page">
<?php if(isset($template)){
    $this->load->view($template);
}?>

<!-- Bootstrap 3.3.5 -->
<script src="<?php echo $asset.'/bootstrap/js/bootstrap.min.js' ?>"></script>
<!-- iCheck -->
<script src="<?php echo $asset.'/plugins/iCheck/icheck.min.js' ?>"></script>

</body>
</html>
