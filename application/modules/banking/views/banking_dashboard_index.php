<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">


        <div class="col-md-7">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Quản lý yêu cầu rút tiền</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="filter">
                    <select name="" id=""
                            onchange="location.href='<?php echo base_url('banking/all') ?>?status='+this.value"
                            class="form-control col-md-6">
                        <option value="0" <?php echo ($status == 0) ? 'selected' : ''; ?>>Chờ chuyển tiền</option>
                        <option value="1"<?php echo ($status == 1) ? 'selected' : ''; ?>> Đã chuyển</option>
                    </select>
                </div>
                <div class="x_content">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                        <tr>
                            <th>Mã giao dịch</th>
                            <th>Thành viên</th>

                            <th>Ngày</th>
                            <th>Số tiền rút</th>
                            <th>Tài khoản nhận tiền</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 0;
                        if (isset($listBankings[0])) {
                            $total = 0;
                            foreach ($listBankings as $item) {
                                $i++;
                                $total += $item->money;
                                ?>
                                <tr style="cursor: pointer;"
                                    onclick="window.location.href = '<?php echo base_url('banking/all/' . $item->id) ?>';">
                                    <td><?php echo $item->code; ?></td>
                                    <td><?php echo $item->username; ?></td>
                                    <td><?php echo date('H:i d/m/Y', strtotime($item->created_on)) ?></td>
                                    <td><?php echo number_format($item->money); ?></td>
                                    <td><b>CTK:</b><?php echo $item->bank_name; ?>
                                        <br>
                                        <b>STK:</b><?php echo $item->bank_number; ?>
                                        <br>
                                        <b>NH:</b><?php echo $item->bank_bankname; ?>
                                        <br>
                                        <b>CN:</b><?php echo $item->bank_chinhanh; ?></td>

                                    <td>
                                        <?php
                                        $stt = '';
                                        switch ($item->status) {
                                            case -1:
                                                $stt = '<div class="label-error">Từ chối!</div>';
                                                break;
                                            case 0:
                                                $stt = '<div class="label-warning">Chờ chuyển tiền!</div>';
                                                break;
                                            case 1:
                                                $stt = '<span class="label-success">Thành công!</span>';
                                                break;
                                            default:
                                                $stt = '<span class="label-info">Lỗi</span>';
                                                break;
                                        }
                                        ?>
                                        <?php echo $stt; ?>

                                    </td>
                                </tr>
                                <?php
                            }?>
                            <tr>
                                <td colspan="3" style="background: #00a7d0;font-weight: bold; text-align: right;">Tổng tiền:</td>
                                <td colspan="3" style="color: #ffffff;font-size: 15px;background: #00a7d0;font-weight: bold;"><?php echo number_format($total)?></td>
                             
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr>
                                <td colspan="4" style="text-align:center;">Không tìm thấy kế quả nào!</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        if (isset($bill->id)) {
            ?>
            <div class="col-md-5">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Chi tiết giao dịch rút tiền</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <table class="table">
                            <tr>
                                <th>Tài khoản</th>
                                <td><?php echo $bill->username; ?></td>
                            </tr>
                            <tr>
                                <th>Số tiền rút</th>
                                <td>
                                    <span style="font-weight: bold;color: #ff0000;font-size: 16px;"><?php echo number_format($bill->money); ?> VNĐ</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Trạng thái giao dịch</th>
                                <td>
                                    <?php
                                    $stt = '';
                                    switch ($bill->status) {
                                        case -1:
                                            $stt = '<div class="label-error">Giao dịch đã bị từ chối!</div>';
                                            break;
                                        case 0:
                                            $stt = '<div class="label-warning">Chờ chuyển tiền!</div>';
                                            break;
                                        case 1:
                                            $stt = '<span class="label-success">Thành công!</span>';
                                            break;
                                        default:
                                            $stt = '<span class="label-info">Lỗi</span>';
                                            break;
                                    }
                                    ?>
                                    <?php echo $stt; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Thông tin rút</th>
                                <td>
                                    <div class="label label-info">
                                        <ul>
                                            <li><label for="">Chủ tk:</label> <?php echo $bill->bank_name; ?></li>
                                            <li><label for="">Số tk:</label> <?php echo $bill->bank_number; ?></li>
                                            <li><label for="">NH:</label> <?php echo $bill->bank_bankname; ?></li>
                                            <li><label for="">Chi nhánh:</label> <?php echo $bill->bank_chinhanh; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2"><textarea name="" id="" cols="30" rows="10" placeholder="Ghi chú"
                                                          class="form-control"><?php echo $bill->note;?></textarea></td>
                            </tr>
                            <?php
                            if ($bill->status == 0) {
                                ?>
                                <tr>
                                    <td colspan="2">
                                        <input type="button" id="reject" onclick="reject();" class="btn btn-danger"
                                               value="Từ chối">
                                        <input type="button" id="done" onclick="approve();" class="btn btn-primary"
                                               value="Đã chuyển tiền">
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    var redir = (id) => {

    }
    var reject = () => {
        if (confirm('Bạn có chắc chắn từ chối giao dịch này không?')) {
            var bankingId = <?php echo $bill->id?>;

            $.ajax({
                url: base_url + 'banking/reject',
                type: 'POST',
                dataType: 'JSON',
                data: {bankingId: bankingId},
                success: function (res) {
                    alert('Giao dịch đã bị từ chối');
                }
            });
        }
    }
    var approve = () => {
        if (confirm('Bạn đã chuyển tiền rồi?')) {
            var bankingId = <?php echo $bill->id?>;

            $.ajax({
                url: base_url + 'banking/approve',
                type: 'POST',
                dataType: 'JSON',
                data: {bankingId: bankingId},
                success: function (res) {
                    alert('Giao dịch thành công.');
                }
            });
        }
    }
</script>
<style>
    .label-success {
        padding: 5px;
        background: #00A000;
        font-weight: bold;
        text-align: center;
        color: #fff;
    }

    .label-error {
        padding: 5px;
        background: #FF0000;
        font-weight: bold;
        text-align: center;
        color: #fff;
    }

    .label-warning {
        padding: 5px;
        background: #ffc107;
        font-weight: bold;
        text-align: center;
        color: #fff;
    }
</style>
<script>
    $("#idBankingForm").submit(function (e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');
        sendData(form.serialize());


    });
    var getBankingInfo = (id) => {
        $.ajax({
            url: base_url + 'bank/ajxGetBank',
            type: 'GET',
            dataType: 'JSON',
            data: {id: id},
            success: function (res) {

                $('#name').val(res.name);
                $('#bank_number').val(res.bank_number);

            }
        })
    };

    var sendData = (data) => {
        $.ajax({
            url: base_url + 'banking/ajxInsertBanking',
            type: 'POST',
            dataType: 'JSON',
            data: data,
            success: function (res) {
                if (res.status == 1) {
                    Swal.fire(
                        'Thông báo',
                        'Hãy kiểm tra email và xác thực để hoàn tất giao dịch rút tiền!',
                        'success'
                    )
                    window.location.reload();
                } else {
                    Swal.fire(
                        'Thông báo',
                        'Giao dịch thất bại',
                        'error'
                    )
                }

            }
        })
    }

</script>
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
