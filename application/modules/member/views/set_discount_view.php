<div class="right_col" role="main" style="height: 1200px;">
    <div class="title_left">
        <h3>Quản lý chiết khấu thẻ</h3>
    </div>

    <div class="col-md-6">

        <div class="x_panel">
            <div class="x_title">Thông tin đối tác</div>
            <div class="x_content">
                <table>
                    <tr>
                        <td><strong>Tài khoản: </strong></td>
                        <td> <?php echo $user->username; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <form action="<?php echo base_url('member/ajax_savediscount')?>" method="post" id="saveFormDiscount">
            <div class="x_panel">
                <div class="x_title">Thông tin chiết khấu</div>
                <div class="x_content">
                    <div class="form-group">
                        <label for="" class="">Loại thẻ</label>
                        <select name="cardtype" id="" class="form-control">
                            <?php
                            foreach ($cardType as $item) {
                                ?>
                                <option value="<?php echo $item->code;?>"><?php echo $item->code.' - '.$item->name;?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="">Mệnh giá chấp nhận</label>
                        <input type="text" name="allowmoney" value="10000,20000,30000,50000,100000,200000,300000,500000,1000000" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="">Phí (%)</label>
                        <input type="text" value="" name="discount" class="form-control" placeholder="%">
                    </div>
                    <div class="form-group"><input type="submit" class="btn btn-primary" value="Cập nhật"></div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12">
        <div class="page-title">

            <div class="x_panel">
                <div class="x_content">

                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã thẻ</th>

                            <th>Giá chấp nhận</th>
                            <th>Rate(%)</th>
                            <th>Trạng thái</th>
                            <th></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($cardTypePrivate[0])) {
                            foreach ($cardTypePrivate as $item) {
                                ?>
                                <tr>
                                    <td></td>

                                    <td><?php echo $item->type_code ?></td>
                                    <td><?php echo $item->allow_money ?></td>

                                    <td><input type="text" value="<?php echo $item->discount; ?>" class="form-control"
                                               style="width: 100px;"></td>
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
                                    <td><a class="btn btn-success"
                                           href="<?php echo base_url('cardtype/update/' . $item->id) ?>">Cài đặt</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#saveFormDiscount").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                alert(data); // show response from the php script.
            }
        });


    });
</script>