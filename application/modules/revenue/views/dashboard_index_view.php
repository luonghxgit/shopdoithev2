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
                    <div class="col-md-8 col-sm-12 clearfix">
                        <div class="tiles clearfix" style="margin-bottom: 20px;border-bottom: 1px #ccc solid;">
                            <div class="col-md-4 tile">
                                <span>Hôm nay</span>
                                <h2><?php echo number_format($total['today']->realvalue); ?> VNĐ</h2>
                            </div>
                            <div class="col-md-4 tile">
                                <span style="font-size: 14px;">Tháng <?php echo date('m/Y'); ?></span>
                                <h2><?php echo number_format($total['month']->total_realvalue); ?> VNĐ</h2>
                            </div>

                        </div>

                        <div class="demo-container">
                            <div id="canvas"></div>
                        </div>
                        <table class="table table-striped jambo_table bulk_action">
                            <tr>
                                <th>Ngày</th>
                                <th style="text-align:right;">Sản lượng</th>
                                <th style="text-align:right;">Doanh thu</th>
                            </tr>
                            <?php
                            if(isset($datear[0])){
                            foreach ($datear as $item) {
                                ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($item->date_created)); ?></td>
                                    <td style="text-align:right;"><?php echo number_format($item->realvalue) ?></td>
                                    <td style="text-align:right;"><?php echo number_format($item->money_after_rate); ?></td>
                                </tr>
                            <?php } }?>
                        </table>
                    </div>

                    <div class="col-md-4 col-sm-12 ">
                        <div>
                            <div class="x_title">
                                <h2>Top hôm nay</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>

                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <table class="table table-striped jambo_table bulk_action">
                                <tr>
                                    <th></th>
                                    <th style="text-align:right;">Sản lượng</th>
                                    <th style="text-align:right;">Doanh thu</th>
                                </tr>
                                <?php
                                $total_realmoney = $total_after_rate = 0;
                                if (@isset($usersToday[0])) {
                                    foreach ($usersToday as $item) {
                                        $total_after_rate += $item->money_after_rate;
                                        $total_realmoney += $item->realvalue;
                                        ?>
                                        <tr>
                                            <td><?php echo $item->username ?></td>
                                            <td style="text-align:right;"><?php echo number_format($item->realvalue); ?></td>
                                            <td style="text-align:right;"><?php echo number_format($item->money_after_rate); ?></td>
                                        </tr>
                                    <?php }
                                } ?>
                                <tr>
                                    <th></th>

                                    <th style="text-align:right;"><?php echo number_format($total_realmoney); ?></th>
                                    <th style="text-align:right;"><?php echo number_format($total_after_rate); ?></th>
                                </tr>
                            </table>
                        </div>

                        <div>
                            <div class="x_title">
                                <h2>Hôm qua</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>

                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <table class="table table-striped jambo_table bulk_action">
                                <tr>
                                    <th></th>
                                    <th style="text-align:right;">Sản lượng</th>
                                    <th style="text-align:right;">Doanh thu</th>
                                </tr>
                                <?php
                                $total_realmoney = $total_after_rate = 0;
                                if (isset($usersYesterday[0])) {
                                    foreach ($usersYesterday as $item) {
                                        $total_after_rate += $item->money_after_rate;
                                        $total_realmoney += $item->realvalue;
                                        ?>
                                        <tr>
                                            <td><?php echo $item->username ?></td>
                                            <td style="text-align:right;"><?php echo number_format($item->realvalue); ?></td>
                                            <td style="text-align:right;"><?php echo number_format($item->money_after_rate); ?></td>
                                        </tr>
                                    <?php }
                                } ?>
                                <tr>
                                    <th></th>

                                    <th style="text-align:right;"><?php echo number_format($total_realmoney); ?></th>
                                    <th style="text-align:right;"><?php echo number_format($total_after_rate); ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>





                            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Thống kê</h2>
                    <ul class="nav navbar-right panel_toolbox">
                     
                      <li style="float: right;"><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                      <li style="float: right;"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                       <div class="line_timkiem">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Tháng:</label>
                          <br>

                          <ul>
                            <?php for ($i=1; $i <= 12; $i++) { ?>
                              <?php if($m == $i) { ?>

                              <li><a href="<?php echo $cur_link.'?m='.$i.'&y='.$y;?>" class="acti"><?php echo $i;?></a></li>
                               <?php }else{ ?>
                                <li><a href="<?php echo $cur_link.'?m='.$i.'&y='.$y;?>"><?php echo $i;?></a></li>
                                <?php } ?>
                            <?php } ?>
                          </ul>
                        </div>


                         <div class="col-md-6">
                          <label>Năm:</label>
                          <br>

                          <ul class="year">
                            <?php for ($i=2017; $i <= 2025; $i++) { ?>
                              <?php if($y == $i) { ?>

                              <li><a href="<?php echo $cur_link.'?m='.$m.'&y='.$i;?>" class="acti"><?php echo $i;?></a></li>
                               <?php }else{ ?>
                                <li><a href="<?php echo $cur_link.'?m='.$m.'&y='.$i;?>"><?php echo $i;?></a></li>
                                <?php } ?>
                            <?php } ?>
                          </ul>
                        </div>


                      </div>

                    </div>
                    <br>
                    <br>

                    <table  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>NGÀY</th>  
                            <th>TỔNG Mệnh giá gửi</th>
                            <th>TỔNG Mệnh giá thực</th>
                            <th>TỔNG Mệnh giá chốt</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($reports as $value) { ?>  
                       
                        <tr>

                          <td><?php echo $value['date'];?></td>
                          <td><?php echo number_format($value['total_cardvalue']);?></td>
                          <td><?php echo number_format($value['total_realvalue']);?></td>
                          <td><?php echo number_format($value['total_receivevalue']);?></td>
                           </tr>
                        <?php } ?>
                       
                      </tbody>
                    </table>
                  
                    
                  </div>
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
        $arrDay = $arrMoney = array();
        $datear = array_reverse($datear, true);
        foreach ($datear as $item) {
            $arrDay[] = '"' . date('d/m/Y', strtotime($item->date_created)) . '"';
            $arrMoney[] = $item->realvalue;
        }
        ?>
        Highcharts.chart('canvas', {
            chart: {
                type: 'line',
                height: 500
            },
            title: {
                text: 'Doanh thu thẻ'
            },
            subtitle: {
                text: 'Từ ... đến ...'
            },
            xAxis: {
                categories: [<?php echo implode(',', $arrDay)?>]
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
                data: [<?php echo implode(',', $arrMoney)?>]
            }]
        });
    </script>

    <style type="text/css">
  
  .line_timkiem ul{
    list-style: none;
    padding: 0;
  }
  .line_timkiem ul li{
  width: 30px;
  height: 30px;
  float: left;
  margin-right: 5px;

    border: 1px solid #333;
  }
    .line_timkiem ul.year li{
  width:50px;

  }

  .line_timkiem ul li a{
    width: 100%;
    float: left;
    color: #333;
    text-align: center;
       padding-top: 5px;
       height: 100%;
  }
   .line_timkiem ul li a:hover{
    background: #26B99A;
    color: #fff;
   }
   .line_timkiem ul li a.acti{
    background: #26B99A;
    color: #fff;
   }
</style>