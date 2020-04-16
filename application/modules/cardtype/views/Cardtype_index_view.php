<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Quản lý loại thẻ</h3>
        </div>

        <div class="title_right">
            <div class="pull_right" style="text-align: right">
                <a href="<?php echo base_url('cardtype/create')?>" class="btn btn-primary">Thêm mới</a>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_content">

                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã thẻ</th>
                        <th>Tên thẻ</th>
                        <th>Giá chấp nhận</th>
                        <th>Rate(%)</th>
                        <th>Trạng thái</th>
                        <th>Cổng thanh toán</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($types as $item) {
                        ?>
                        <tr>
                            <td></td>
                            <td><?php echo $item->code ?></td>
                            <td><?php echo $item->name ?></td>
                            <td><?php echo $item->allow_money ?></td>
                         <!--   <td>
                                <?php
                                if ($item->code == 'ZING') {
                                    ?>
                                    <div class="col-md-12">
                                        <label for="">Zing cookie</label>
                                        <textarea name="" id="" cols="30" rows="2"
                                                  class="form-control"><?php echo $item->zing_cookie ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Zing config</label>
                                        <input type="text" value="<?php echo $item->config ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Zing game</label>
                                        <input type="text" value="<?php echo $item->zing_game ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Zing account</label>
                                        <input type="text" value="<?php echo $item->zing_account ?>"
                                               class="form-control">
                                    </div>
                                <?php } ?>
                            </td> -->
                            <td><?php echo $item->discount;?></td>
                            <td>
                                <?php
                                if ($item->status == 1) {
                                    ?>
                                    <span style="color: green;font-weight:bold;">Hoạt động</span>
                                <?php } else {
                                    ?>
                                    <span style="color: red;font-weight:bold;">Bảo trì</span>
                                <?php } ?>
                            </td>
                            <td><b><?php echo $item->gate;?></b></td>
                            <td><a class="btn btn-success" href="<?php echo base_url('cardtype/update/' . $item->id) ?>">Cài đặt</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>