<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Giao dịch</h3>
        </div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" name="key" value="<?php echo $key; ?>" class="form-control"
                               placeholder="seri hoặc code hoặc mã giao dịch  ...   ">
                        <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                    </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_content">

                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link"
                                                 href="<?php echo base_url('transaction?page=') . ($page - 1) ?>">Trang
                                trước</a></li>
                        <?php
                        for ($i = 1; $i <= $numPage; $i++) {
                            if ($i > $page - 5 && $i < $page + 5) {
                                ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a
                                            class="page-link"
                                            href="transaction?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php }
                        } ?>

                        <li class="page-item"><a class="page-link"
                                                 href="<?php echo base_url('transaction?page=') . ($page + 1) ?>">Trang
                                sau</a>
                        </li>
                    </ul>
                </nav>
                <div class="filter">
                    <input type="text" class="form-control form_datetimepicker" style="width: auto;float: left;"><span style="float: left;padding: 0 20px;">  to </span> <input class="form-control form_datetimepicker" style="width: auto;float: left;" type="text" value="<?php echo date('H:i d/m/Y')?>">

                </div>
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã giao dịch</th>
                        <th>Trước giao dịch</th>
                        <th>Sau giao dịch</th>
                        <th>Tăng</th>
                        <th>Giảm</th>
                        <th>Thời gian</th>

                        <th>Nội dung</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    if (isset($allCards[0])) {
                        foreach ($allCards as $item) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $item->id; ?></td>
                                <td style="text-align: right"><?php echo number_format($item->before_change); ?></td>
                                <td style="text-align: right"><?php echo number_format($item->after_change); ?></td>
                                <td style="text-align: right;color: green;font-weight: bold;">
                                    +<?php echo number_format($item->money_add); ?></td>
                                <td style="text-align: right;color: red;font-weight: bold;"><?php echo number_format($item->money_down); ?></td>

                                <td style="text-align: center"><?php echo date('H:i d/m/Y', strtotime($item->created_on)); ?></td>
                                <td><?php echo $item->note ?></td>
                            </tr>
                        <?php }
                    } else { ?>

                        <tr>
                            <td colspan="9" style="text-align: center">Hiện không có kết quả nào!</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link"
                                                 href="<?php echo base_url('transaction?page=') . ($page - 1) ?>">Trang
                                trước</a></li>
                        <?php
                        for ($i = 1; $i <= $numPage; $i++) {
                            if ($i > $page - 5 && $i < $page + 5) {
                                ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a
                                            class="page-link"
                                            href="transaction?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php }
                        } ?>

                        <li class="page-item"><a class="page-link"
                                                 href="<?php echo base_url('transaction?page=') . ($page + 1) ?>">Trang
                                sau</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<style>
    td {
        padding: 6px !important;
    }

    .label-error {
        padding: 5px;
        background: #FF0000;
        font-weight: bold;
        text-align: center;
        color: #fff;
    }

    .label-success {
        padding: 5px;
        background: #00A000;
        font-weight: bold;
        text-align: center;
        color: #fff;
    }

    .label-smg {
        padding: 5px;
        background: blueviolet;
        font-weight: bold;
        text-align: center;
        color: #fff;
    }
</style>

