<?php
$user_data = $this->session->userdata('user_data');
$user_id = $this->session->userdata('user_id');
$_CI = &get_instance();
$_CI->load->model('user/User_model');
$_CI->load->model('banking/Banking_model');
$_CI->load->model('card/Card_model');
   $userInfo = $_CI->User_model->find_by('id',$user_id);
   $waitBank = $_CI->Banking_model->getBankingWait();
   $totalUnclear = $_CI->Card_model->getCardByCMSType_total('"ResponseCode":-326');
?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo base_url()?>" class="site_title"><i class="fa fa-paw"></i> <span></span></a>
        </div>

        <div class="clearfix"></div>
        <div class="profile clearfix">

            <div class="profile_info">
                <span>Tài khoản:</span>
                <h2 style="font-weight: bold;">TKC: <?php echo number_format($userInfo->balance)?> VNĐ</h2>
                <h2 style="font-weight: bold;">Khóa: <?php echo number_format($userInfo->waitbank)?> VNĐ</h2>
            </div>
        </div>
        <br/>
        <style>
            .profile_info {
                padding: 10px;
                width: 100%;
                float: left;
                background: rgba(0,0,0,.1);
            }
        </style>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Thông tin</h3>
                <ul class="nav side-menu">
                    <li><a href="<?php echo base_url('member')?>"><i class="fa fa-user"></i>Thông tin cá nhân</a></li>
                    <li><a href="<?php echo base_url('member/api')?>"><i class="fa fa-code"></i> Thông tin kết nối API</a></li>
                    <li><a href="<?php echo base_url('bank')?>"><i class="fa fa-bank"></i> Danh sách ngân hàng</a></li>
                    <li><a href="<?php echo base_url('member/changepassword')?>"><i class="fa fa-barcode"></i> Đổi mật khẩu</a></li>
                </ul>
            </div>
            <?php
            if ($user_data['role'] == 2) {
            ?>
            <div class="menu_section">
                <h3>Công việc</h3>
                <ul class="nav side-menu">
                    <li><a href="<?php echo base_url('card') ?>"><i class="fa fa-desktop"></i> Lịch sử thẻ</a></li>
                    <li><a href="<?php echo base_url('transaction') ?>"><i class="fa fa-renren"></i> Lịch sử dòng tiền</a></li>
                    <li><a href="<?php echo base_url('revenue') ?>"><i class="fa fa-table"></i>Doanh thu</a></li>
                    <li><a href="<?php echo base_url('banking')?>"><i class="fa fa-money"></i>Rút tiền</a></li>
                    <li><a href="<?php echo base_url('report/doisoat')?>"><i class="fa fa-desktop"></i> Đối soát</a></li>
                </ul>
            </div>
            <?php }?>
            <?php
            if ($user_data['role'] == 1) {
                ?>
                <div class="menu_section">
                    <h3>Kế toán</h3>
                    <ul class="nav side-menu">
                        <li><a href="<?php echo base_url('revenue/dashboard')?>"><i class="fa fa-home"></i> Thống kê doanh số</a></li>
                        <li><a href="<?php echo base_url('card/all')?>"><i class="fa fa-home"></i> Lịch sử thẻ</a></li>
                        <li><a href="<?php echo base_url('card/unclear')?>"><i class="fa fa-home"></i> Thẻ không xác định<?php if($totalUnclear > 0){ ?><span class="badge badge-danger"><?php echo $totalUnclear;?></span><?php }?></a></li>
                        <li><a href="<?php echo base_url('banking/all')?>"><i class="fa fa-home"></i> Quản lý giao dịch rút tiền <?php if($waitBank > 0){ ?><span class="badge badge-danger"><?php echo $waitBank;?></span><?php }?></a></li>
                    </ul>
                </div>
                <div class="menu_section">
                    <h3>Quản lý hệ thống</h3>
                    <ul class="nav side-menu">
                        <li><a href="<?php echo base_url('member/all')?>"><i class="fa fa-home"></i> Quản lý thành viên</a></li>
                        <li><a href="<?php echo base_url('cardtype')?>"><i class="fa fa-desktop"></i> Danh sách loại thẻ</a></li>
                        <li><a href="<?php echo base_url('report/doisoat')?>"><i class="fa fa-desktop"></i> Đối soát</a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>