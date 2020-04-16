<?php

?>
<div class="right_col" role="main" style="height: 1200px;">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Tổng hợp doanh số
                    </h2>
                    <div class="filter">

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-9 col-sm-12 clearfix">
                        <div class="tiles clearfix" style="margin-bottom: 20px;border-bottom: 1px #ccc solid;">
                            <div class="col-md-4 tile">
                                <span>Hôm nay</span>
                                <h2><?php echo number_format($total['today']->realvalue); ?> VNĐ</h2>

                                </span>
                            </div>
                            <div class="col-md-4 tile">
                                <span style="font-size: 14px;">Tháng <?php echo date('m/Y'); ?></span>
                                <h2><?php echo number_format($total['month']->total_realvalue); ?> VNĐ</h2>
                            </div>

                        </div>

                        <div class="demo-container">
                            <div id="canvas"></div>
                        </div>

                    </div>

                    <div class="col-md-3 col-sm-12 ">
                        <div>
                            <div class="x_title">
                                <h2> </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                     
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <ul class="list-unstyled top_profiles scroll-view">
                               <!-- <li class="media event">
                                    <a class="pull-left border-aero profile_thumb">
                                        <i class="fa fa-user aero"></i>
                                    </a>
                                    <div class="media-body">
                                        <a class="title" href="#">Ms. Mary Jane</a>
                                        <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                        <p>
                                            <small>12 Sales Today</small>
                                        </p>
                                    </div>
                                </li>-->
                                 
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
    <?php
            $arrDay = $arrMoney  = array();
            $datear = array_reverse($datear,true);
    foreach ($datear as $item){
        $arrDay[] =  '"'.date('d/m/Y',strtotime($item->date_created)).'"';
        $arrMoney[] =$item->realvalue;
    }
    ?>
    Highcharts.chart('canvas', {
        chart: {
            type: 'line',
            height:500
        },
        title: {
            text: 'Doanh thu thẻ'
        },
        subtitle: {
            text: 'Từ ... đến ...'
        },
        xAxis: {
            categories: [<?php echo implode(',',$arrDay)?>]
        },
        yAxis: {
            title: {
                text: 'Tiền'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: '',
            data: [<?php echo implode(',',$arrMoney)?>]
        }]
    });
</script>