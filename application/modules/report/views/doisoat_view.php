<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Đối soát</h3>
        </div>


        <div class="x_panel">
            <div class="x_content">

                <div class="filter" style="padding: 20px 0">

                    <div class="col-md-2">
                        <select name="filluser" id="filluser" class="form-control select2">
                            <option value="0" <?php echo ($user == 100) ? 'selected' : ''; ?>>Tất cả
                                người
                                dùng
                            </option>
                            <?php
                            foreach ($users as $item) {
                                ?>
                                <option value="<?php echo $item->id ?>"<?php echo ($user == $item->id) ? 'selected' : '' ?>><?php echo $item->username ?></option>
                            <?php } ?>


                        </select>
                    </div>
                    <form action="" method="get">
                        <div class="col-md-2">
                            <input type="text" name="fromdate" class="form-control datepicker" value="<?php echo $fromdate; ?>"
                                   placeholder="Từ ngày">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="todate" class="form-control datepicker" value="<?php echo $todate; ?>"
                                   placeholder="Đến ngày">
                        </div>
                        <div class="col-md-2">
                            <input type="submit" class="btn btn-primary" value="Đối soát" placeholder="Đến ngày">
                        </div>
                    </form>
                </div>
                <table class="table " style="margin-top: 20px;">

                    <tbody>
                    <?php
                    $all = $i = 0;
                    foreach ($arrayCardType as $cardItem) {
                        $i++;
                        if (isset($data[$cardItem])) {
                            ?>
                            <tr>
                                <td style="text-align: center;vertical-align: middle;"
                                "> <?php echo $cardItem; ?></td>
                                <td colspan="">
                                    <table style="width: 100%;" class="table-striped">
                                        <?php if ($i == 1) { ?>
                                            <tr>
                                                <td style="text-align: right;">Mệnh giá</td>
                                                <td style="text-align: right;">Số lượng</td>
                                                <td style="text-align: right;">Tổng</td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        $total = 0;

                                        foreach ($data[$cardItem] as $item) {
                                            $to = $item->receivevalue * $item->total;
                                            $total += $to;
                                            ?>
                                            <tr>
                                                <td style="width: 20%;text-align: right;"><?php echo number_format($item->receivevalue); ?></td>
                                                <td style="width: 20%;text-align: right;"><?php echo $item->total; ?></td>
                                                <td style="width: 20%;text-align: right;"><?php echo number_format($to); ?></td>
                                            </tr>
                                        <?php }
                                        $all += $total;
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right;font-weight: bold;color: blue;"><?php echo number_format($total); ?></td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php
                    } ?>
                    <tr>
                        <td colspan="2" style="text-align: right">
                            <span style="border: 1px #ff0000 solid;padding: 10px 20px;font-weight: bold;color: red;"><?php echo number_format($all); ?></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#filluser').change(function () {
        window.location.href = base_url + '/report/doisoat/' + $(this).val()
    })
    $(".select2").select2({});
</script>