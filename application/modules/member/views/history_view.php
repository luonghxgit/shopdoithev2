<div class="right_col" role="main" style="height: 1200px;">

    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>Thông tin cá nhân</h2>
                <div class="clearfix"></div>
            </div>
            <?php
            //	print_r($info);
            ?>
            <div class="x_content">
                <?php
                if (isset($mess)) {
                    ?>
                    <div class="alert alert-success">
                        <?php echo $mess ?>
                    </div>
                <?php } ?>

                <input type="hidden" name="id" value="<?php echo $info->id ?>"/>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Tên đăng nhập <span
                                class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6">
                        <input class="form-control" readonly value="<?php echo $info->username; ?>" type="text">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Họ và Tên <span
                                class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6">
                        <input id="name" name="name" class="form-control" value="<?php echo $info->name; ?>"
                               type="text">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span
                                class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6">
                        <input type="email" id="email" name="email" required value="<?php echo $info->email; ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="number">Điện thoại <span
                                class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6">
                        <input type="number" id="number" name="phone" required value="<?php echo $info->phone; ?>"
                               class="form-control">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="website">Địa chỉ <span
                                class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6">
                        <input type="text" id="address" name="address" required
                               value="<?php echo $info->address; ?>" class="form-control">
                    </div>
                </div>

                <div class="ln_solid"></div>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>Thông tin tài khoản</h2>
                <div class="clearfix"></div>
            </div>
            <?php
            //	print_r($info);
            ?>
            <div class="x_content">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Tài khoản hiện có <span
                                class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6">
                        <span style="color: #FF0000;font-size: 20px;"><?php echo number_format($info->balance); ?> VNĐ</span>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Chờ rút <span
                                class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6">
                        <span style="color: #FF0000;font-size: 20px;"><?php echo number_format($info->waitbank); ?> VNĐ</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Lịch sử dòng tiền</h2>
                <div class="clearfix"></div>
            </div>
            <?php
            //	print_r($info);
            ?>
            <div class="x_content">

                <div class="filter pull-right">
                    <form class="form-inline">

                        <div class="form-group">

                            <input type="text" name="key" class="form-control" placeholder="Từ khóa">

                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </div>

                    </form>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link"
                                                 href="<?php echo base_url('member/detail/'.$user_id.'?page=') . ($page - 1) ?>">Trang
                                trước</a></li>
                        <?php
                        for ($i = 1; $i <= $numPage; $i++) {
                            if ($i > $page - 5 && $i < $page + 5) {
                                ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a
                                            class="page-link"
                                            href="<?php echo base_url('member/detail/'.$user_id.'?page=') . ($i) ?>"><?php echo $i; ?></a>
                                </li>
                            <?php }
                        } ?>

                        <li class="page-item"><a class="page-link"
                                                 href="<?php echo base_url('member/detail/'.$user_id.'?page=') . ($page + 1) ?>">Trang
                                sau</a>
                        </li>
                    </ul>
                </nav>
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
                    if (isset($allTrans[0])) {
                        foreach ($allTrans as $item) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $item->id; ?></td>
                                <td style="text-align: right"><?php echo number_format($item->before_change); ?></td>
                                <td style="text-align: right"><?php echo number_format($item->after_change); ?></td>
                                <td style="text-align: right;color: green;font-weight: bold;">
                                    +<?php echo number_format($item->money_add); ?></td>
                                <td style="text-align: right;color: red;font-weight: bold;"> <?php echo ($item->money_down > 0) ? '-' . number_format($item->money_down) : 0; ?></td>

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
                                                 href="<?php echo base_url('member/detail/'.$user_id.'?page=') . ($page - 1) ?>">Trang
                                trước</a></li>
                        <?php
                        for ($i = 1; $i <= $numPage; $i++) {
                            if ($i > $page - 5 && $i < $page + 5) {
                                ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a
                                            class="page-link"
                                            href="<?php echo base_url('member/detail/'.$user_id.'?page=') . ($i) ?>"><?php echo $i; ?></a>
                                </li>
                            <?php }
                        } ?>

                        <li class="page-item"><a class="page-link"
                                                 href="<?php echo base_url('member/detail/'.$user_id.'?page=') . ($page + 1) ?>">Trang
                                sau</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>