<?php
$user = $this->session->userdata('user_data');
?>
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url()?>">
                    <?php
                    echo (!is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile")))?'Shopdoithe.com':'Trang chủ';
                    ?>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo base_url()?>">Trang chủ</a></li>
                    <li><a href="<?php echo base_url('doi-the-cao-thanh-tien-mat.html')?>">Giới thiệu</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if (isset($user)) {
                        ?>
                        <li><a href="<?php echo base_url('card') ?>"><span
                                        class="	glyphicon glyphicon-cog"></span>
                                <?php echo $user['username'];?></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="<?php echo base_url('register') ?>"><span
                                        class="glyphicon glyphicon-log-in"></span>
                                Đăng ký</a></li>
                        <li><a href="<?php echo base_url('login') ?>"><span class="glyphicon glyphicon-user"></span>
                                Đăng
                                nhập</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</nav>