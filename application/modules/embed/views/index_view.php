<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Danh sách mã nhúng</h3>
        </div>

        <div class="title_right">
            <div class="pull_right" style="text-align: right">
                <a href="<?php echo base_url('embed/create') ?>" class="btn btn-primary">Thêm mới</a>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_content">

                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên mã nhúng</th>
                        <th>Nội dung trả về</th>
                        <th>Số tiền</th>
                        <th>đã nạp</th>
                        <th>Link mã nhúng</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($embeds as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item->id?></td>
                            <td><?php echo $item->name; ?></td>
                            <td><?php echo $item->success_msg; ?></td>
                            <td><?php echo number_format($item->balance_limit); ?></td>
                            <td><?php echo number_format($item->balance); ?></td>
                            <td>
                                <input type="text" readonly style="font-size: 13px;" value="<?php echo base_url('embed/show/'.$item->code)?>" class="form-control">
                                <br>
                                <textarea readonly name="" id="codeEmbed<?php echo $item->id?>" style="width: 100%;height: 80px;font-size: 13px;" class="form-control"><iframe src="<?php echo base_url('embed/show/'.$item->code)?>" width="100%" height="100%" marginwidth="0" marginheight="0" frameborder="0"></iframe>
</textarea></td>
                            <td>
                                <a href="" class="">Thống kê</a> |
                                <a href="" class="">Sửa</a> |
                                <a href="" class="">Xóa</a>

                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>