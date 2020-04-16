<!DOCTYPE html>
<html lang="en">
<?php
$user_data = $this->session->userdata('user_data');
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CMS quản lý hệ thống gạch thẻ | <?php echo base_url();?> </title>

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

    <!-- jQuery -->
    <script src="<?php echo base_url('assets/gentelella/') ?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url('assets/gentelella/') ?>vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script>
        var base_url = '<?php echo base_url();?>';
    </script>
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <?php $this->load->view('admin/sidebar'); ?>

        <!-- top navigation -->

        <?php $this->load->view('admin/header'); ?>
        <!-- /top navigation -->

        <!-- page content -->
        <?php $this->load->view($template); ?>
    </div>
    <!-- /page content -->

    <!-- footer content -->
    <footer>
        <div class="pull-right">
            Hệ thống quản lý thẻ cào. Phiên bản 1.0
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->
</div>
</div>

<!-- FastClick -->
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/nprogress/nprogress.js"></script>

<script src="<?php echo base_url('assets/gentelella/') ?>vendors/raphael/raphael.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/morris.js/morris.min.js"></script>
<!-- gauge.js -->
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- Skycons -->
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/skycons/skycons.js"></script>

<!-- DateJS -->
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/DateJS/build/date.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/moment/min/moment.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/jszip/dist/jszip.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo base_url('assets/gentelella/') ?>vendors/pdfmake/build/vfs_fonts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<!-- Custom Theme Scripts -->
<script src="<?php echo base_url('assets/gentelella/') ?>build/js/custom.min.js"></script>
<script type="text/javascript">$(document).ready(function () {
        $('#daterange').daterangepicker({
            "locale": {

                "applyLabel": "Áp dụng",
                "cancelLabel": "hủy bỏ",
                "fromLabel": "từ",
                "toLabel": "đến",
                "customRangeLabel": "Khoảng tùy chọn",
                "daysOfWeek": [
                    "CN",
                    "Hai",
                    "Ba",
                    "Tư",
                    "Năm",
                    "Sáu",
                    "Bảy"

                ],
                "monthNames": [
                    "Tháng 1",
                    "Tháng 2",
                    "Tháng 3",
                    "Tháng 4",
                    "Tháng 5",
                    "Tháng 6",
                    "Tháng 7",
                    "Tháng 8",
                    "Tháng 9",
                    "Tháng 10",
                    "Tháng 11",
                    "Tháng 12"

                ],
                "firstDay": 0
            },
            ranges: {
                'Hôm nay': [new Date(), new Date()],
                'Hôm qua': [moment().subtract('days', 1), moment().subtract('days', 1)],
                '7 ngày trước': [moment().subtract('days', 6), new Date()],
                '30 ngày trước': [moment().subtract('days', 29), new Date()],
                'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                'Tháng trước': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            opens: 'right',
            format: 'DD-MM-YYYY h:mm',
            timePicker: true,
            timePicker24Hour: true,

            startDate: '<?php echo isset($fdate)?date('m-d-Y H:i', strtotime($fdate)):date('m-d-Y H:i', strtotime('-7 days'))?>',
            endDate: '<?php  echo isset($tdate)?date('m-d-Y H:i', strtotime($tdate)):date('m-d-Y H:i')?>'
        }, function (start, end) {
console.log(start);
            $('#daterange').val(start.format('DD-MM-YYYY  h:mm') + ' - ' + end.format('DD-MM-YYYY h:mm'));

        });
        $(".form_datetimepicker").datetimepicker({
            format: 'Y-MM-DD HH:mm'
        });
    });

</script>
<script type="text/javascript">



</script>
</body>
</html>