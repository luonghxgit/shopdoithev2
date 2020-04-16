<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Quản lý tài khoản</h3>
        </div>

        <div class="title_right">
            <div class="pull_right" style="text-align: right">
                <a href="<?php echo base_url('cardtype/create')?>" class="btn btn-primary">Thêm mới</a>
            </div>
        </div>
         
        <div class="x_panel">
            <div class="x_content">
                <div class="col-md-12">
                <div class="row">
                  <div class="tile_count" style="width:100%; ">
                    <div class="col-md-3 col-sm-4  tile_stats_count">
                      <span class="count_top"><i class="fa fa-user"></i> Tổng số người dùng</span>
                      <div class="count" ><?php echo $total_users;?></div>
                    </div>
                    <div class="col-md-3 col-sm-4  tile_stats_count">
                      <span class="count_top"><i class="fa fa-clock-o"></i> Tổng tiền dư</span>
                      <div class="count"><?php echo number_format($total_balance['total']);?> VNĐ</div>
                       </div>
                    <div class="col-md-3 col-sm-4  tile_stats_count">
                      <span class="count_top"><i class="fa fa-user"></i> Tổng tiền chờ duyệt</span>
                       <div class="count"><?php echo number_format($total_waitbank['total']);?> VNĐ</div>
                       </div>

                  </div>
                </div>
                <hr/>
                <div class="row">
                    <form method="get" action="" style="width:100%;">
                        <div class="col-md-6">
 
                            <input value="<?php echo ($k)?$k:'';?>" name="k"  placeholder="Tìm kiếm theo tên, username, số điện thoại" class="form-control" value="">

                        </div>
                         
                         <div class="col-md-2"><input type="submit" class="btn btn-success" value="Tìm kiếm"/></div>
                         </form>
                    </div>
                </div>
                
                <table  class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tài khoản</th>
                        <th>Họ và Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th style="text-align:right;">Số dư</th>
                        <th style="text-align:right;">Chờ duyệt</th>
                        <th></th>

                    </tr>
                    <tbody>
                    </thead>
                    <?php
                    $i=0;
                    $total['users'] = $total['balance'] = $total['waitbank'] = 0;
                    foreach ($users as $item) {
                        $i++;
                         $total['users']=$i;
                         $total['balance'] +=$item->balance;
                         $total['waitbank']+=$item->waitbank;
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><b><?php echo $item->username;?></b></td>
                            <td><?php echo $item->name;?></td>
                            <td><?php echo $item->email;?></td>
                            <td><?php echo $item->phone;?></td>
                            <td style="text-align:right;"><?php echo number_format($item->balance);?></td>
                            <td style="text-align:right;"><?php echo number_format($item->waitbank);?></td>
                            <td style="text-align:right;"><a href="<?php echo base_url('member/detail/'.$item->id)?>"><i class="glyphicon glyphicon-eye-open"></i> Xem lịch sử</a> |
                            <a href=""><i class="glyphicon glyphicon-setting"></i> Sửa</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 