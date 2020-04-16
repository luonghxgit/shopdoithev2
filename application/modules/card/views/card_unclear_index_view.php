<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Quản lý thẻ không xác định</h3>
        </div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                <form action="" method="get">


                    <div class="input-group">
                        <input type="text" class="form-control" name="k" value="<?php echo isset($k) ? $k : ''; ?>"
                               placeholder="Tìm theo mã hoặc Seri thẻ ...   ">
                        <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Go!</button>
                    </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_content">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>#</th>
                        <th>Tài khoản</th>
                        <th>Seri</th>
                        <th>Mã thẻ</th>
                        <th>Loại thẻ</th>
                        <th>Mệnh giá gửi</th>
                        <th>Mệnh giá thực</th>
                        <th>Mệnh giá chốt</th>
                        <th>Phí</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th colspan="2"></th>
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
                                <td <?php echo ($item->date_created == date('Y-m-d')) ? 'style ="background:#ccc;"' : ''; ?>><?php echo $i; ?></td>
                                <td><a target="_blank"
                                       href="<?php echo base_url('api/reCallTocms/' . $item->id) ?>"><?php echo $item->id; ?></a>
                                </td>
                                <td><?php echo $item->username; ?></td>
                                <td><?php echo $item->cardseri ?></td>
                                <td><?php echo $item->cardcode ?></td>
                                <td><?php echo $item->cardtype ?></td>
                                <td><?php echo number_format($item->cardvalue); ?></td>
                                <td><?php echo number_format($item->realvalue); ?></td>
                                <td><?php echo number_format($item->receivevalue); ?></td>
                                <td><?php echo number_format($item->rate); ?>%</td>
                                <td><?php echo date('H:i d/m/Y', strtotime($item->created_on)); ?></td>


                                <td>
                                    <?php
                                    $res = json_decode($item->responsed);
                                    echo $res->ResponseCode;
                                    ?>


                                </td>
                                <td><input type="text" value="Thẻ sai" class="btn btn-danger"
                                           onclick="falseCard(<?php echo $item->id; ?>)">
                                </td>
                                <td><input type="text" value="Thẻ đúng" class="btn btn-primary"
                                           onclick="trueCard(<?php echo $item->id; ?>)"></td>
                            </tr>
                        <?php }
                    } else { ?>

                        <tr>
                            <td colspan="12" style="text-align: center">Hiện không có kết quả nào!</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script>


    var base_url = '<?php echo base_url()?>';

    function f() {
        var dateRanger = $('#daterange').val().split(' - ');
        var fdate = dateRanger[0].split('/');
        var tdate = dateRanger[1].split('/');
        var fromdate = fdate[2] + '-' + fdate[0] + '-' + fdate[1];
        var todate = tdate[2] + '-' + tdate[0] + '-' + tdate[1];

        var type = $('#type').val();
        var status = $('#status').val();
        var price = $('#price').val();
        var url = '?fromdate=' + fromdate + '&todate=' + todate + '&type=' + type + '&price=' + price + '&status=' + status;

        return url;
    }

    var exportEx = () => {
        window.location.href = base_url + 'report/ajaxEx' + f();
    }

    function paging(page) {
        window.location.href = base_url + 'card/all' + f() + '&page=' + page;
    }


    function getData() {
        window.location.href = f();
    }

    function recall(cId) {
        //    if (confirm('Thẻ đúng?')) {
        $.get("<?php echo base_url('api/reCallTocms')?>/" + cId, function (data, status) {
            //       alert('Đã cập nhật thẻ này là đúng. tiền đã được cộng vào tài khoản khách hàng');
            //    location.reload();
        });
        //    }
    }

    function falseCard(cId) {
        //  if (confirm('Thẻ sai?')) {
        $.get("<?php echo base_url('card/updateCardFalse')?>/" + cId, function (data, status) {
            //      alert('Đã cập nhật trạng thái thẻ sai');
            location.reload();
        });
        //  }
    }

    function trueCard(cId) {
        //  if (confirm('Thẻ sai?')) {
        $.get("<?php echo base_url('card/updateGarenaTrue')?>/" + cId, function (data, status) {
            //      alert('Đã cập nhật trạng thái thẻ sai');
            location.reload();
        });
        //  }
    }
    <?php
    if(isset($fdate) && isset($tdate)){
    ?>
    $('#daterange').val('<?php echo date('m/d/Y', strtotime($fdate))?> - <?php echo date('m/d/Y', strtotime($tdate))?>');
    <?php }?>
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

    .label-waitting {
        padding: 5px;
        background: yellow;
        font-weight: bold;
        text-align: center;
        color: #FF0000;
    }
</style>
