<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Quản lý thẻ nạp</h3>
        </div>
        <div class="title_right">

            <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                <form action="" method="get">


                    <div class="input-group">
                        <input type="text" class="form-control" name="k" value="<?php echo ($k) ? $k : ''; ?>"
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
                <div class="filter clearfix">
                    <div class="row">
                        <div class="col-md-2">

                            <i class="icon-calendar"></i>
                            <input id="daterange" class="form-control" value="">

                        </div>
                        <div class="col-md-2">
                            <select name="type" id="type" class="form-control">
                                <option value="">Nhà mạng</option>
                                <option value="VTT" <?php echo ($type == 'VTT') ? 'selected' : ''; ?>>Viettel</option>
                                <option value="VNP" <?php echo ($type == 'VNP') ? 'selected' : ''; ?>>Vinaphone</option>
                                <option value="VMS" <?php echo ($type == 'VMS') ? 'selected' : ''; ?>>Mobifone</option>
                                <option value="ZING" <?php echo ($type == 'ZING') ? 'selected' : ''; ?>>Zing</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="price" id="price" class="form-control">
                                <option value="">Mệnh giá</option>
                                <option value="10000" <?php echo ($price == '10000') ? 'selected' : ''; ?>>10.000
                                </option>
                                <option value="20000" <?php echo ($price == '20000') ? 'selected' : ''; ?>>20.000
                                </option>
                                <option value="30000" <?php echo ($price == '30000') ? 'selected' : ''; ?>>30.000
                                </option>
                                <option value="50000" <?php echo ($price == '50000') ? 'selected' : ''; ?>>50.000
                                </option>
                                <option value="100000" <?php echo ($price == '100000') ? 'selected' : ''; ?>>100.000
                                </option>
                                <option value="200000" <?php echo ($price == '200000') ? 'selected' : ''; ?>>200.000
                                </option>
                                <option value="300000" <?php echo ($price == '300000') ? 'selected' : ''; ?>>300.000
                                </option>
                                <option value="500000" <?php echo ($price == '500000') ? 'selected' : ''; ?>>500.000
                                </option>
                                <option value="1000000" <?php echo ($price == '1000000') ? 'selected' : ''; ?>>
                                    1.000.000
                                </option>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" id="status" class="form-control">
                                <option value="100" <?php echo ($status == 100) ? 'selected' : ''; ?>>Tình trạng
                                </option>
                                <option value="-1" <?php echo ($status == -1) ? 'selected' : ''; ?>>Thẻ sai</option>
                                <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>Thẻ đúng</option>


                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="button" class="btn btn-primary" onclick="getData()" value="Lọc thông tin">
                        </div>
                        <div class="col-md-2">

                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-8">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link"
                                                     href="javascript:paging(<?php echo $page - 1 ?>)">Trang
                                    trước</a></li>
                            <?php
                            for ($i = 1; $i <= $numPage; $i++) {
                                if ($i > $page - 3 && $i < $page + 3) {
                                    ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a
                                                class="page-link"
                                                href="javascript:paging(<?php echo $i ?>)"><?php echo $i; ?></a>
                                    </li>
                                <?php }
                            } ?>

                            <li class="page-item"><a class="page-link"
                                                     href="javascript:paging(<?php echo $page + 1 ?>)">Trang
                                    sau</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-4">
                    <div class="right" style="text-align: right">
                        <button class="btn btn-primary" onclick="exportEx();">Xuất Excel</button>
                        <span class="btn btn-warning"
                              style="background-color: orangered;color: #fff;">Tổng chốt: <?php echo number_format($totalMoneyReceive->total_receivalue); ?></span>
                    </div>
                </div>
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th>#</th>

                        <th>Seri</th>
                        <th>Mã thẻ</th>
                        <th>Loại thẻ</th>
                        <th>Mệnh giá gửi</th>
                        <th>Mệnh giá thực</th>
                        <th>Mệnh giá chốt</th>
                        <th>Phí</th>
                        <th>Thực nhận</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    if (isset($allCards[0])) {
                        foreach ($allCards as $item) {
                            $i++;
                            ?>
                            <tr  >
                                <td><?php echo $i; ?></td>

                                <td><?php echo $item->cardseri ?></td>
                                <td><?php echo $item->cardcode ?></td>
                                <td><?php echo $item->cardtype ?></td>
                                <td><?php echo number_format($item->cardvalue); ?></td>
                                <td><?php echo number_format($item->realvalue); ?></td>
                                <td><?php echo number_format($item->receivevalue); ?></td>
                                <td><?php echo number_format($item->rate); ?>%</td>
                                <td style="text-align: right;font-weight: bold;color: green;"><?php echo number_format($item->money_after_rate); ?></td>
                                <td><?php echo date('H:i d/m/Y', strtotime($item->created_on)); ?></td>
                                <td>
                                    <?php
                                    switch ($item->status) {
                                        case -1:
                                            $stt = '<div class="label-error">Thẻ sai</div>';
                                            break;
                                        case 1:
                                            $stt = '<div class="label-success">Thẻ đúng</div>';
                                            break;
                                        default:
                                            $stt = '<div class="label-success">Không xác định</div>';
                                            break;
                                    }
                                    if ($item->realvalue != $item->cardvalue && $item->realvalue > 0) $stt = '<div class="label-smg">Sai mệnh giá</div>';

                                    echo $stt;
                                    ?></td>
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
                                                 href="javascript:paging(<?php echo $page - 1 ?>)">Trang
                                trước</a></li>
                        <?php
                        for ($i = 1; $i <= $numPage; $i++) {
                            if ($i > $page - 3 && $i < $page + 3) {
                                ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link"
                                                                                                      href="javascript:paging(<?php echo $i ?>)"><?php echo $i; ?></a>
                                </li>
                            <?php }
                        } ?>

                        <li class="page-item"><a class="page-link"
                                                 href="javascript:paging(<?php echo $page + 1 ?>)">Trang
                                sau</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<div id="showCardInfo"></div>
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
        var url = '?fromdate=' + fromdate + '&todate=' + todate + '&type=' + type + '&price=' + price + '&status=' + status + '&user_id=<?php echo $this->session->userdata('user_id');?>';

        return url;
    }

    var exportEx = () => {
        window.location.href = base_url + 'report/ajaxEx' + f();
    }

    function paging(page) {
        window.location.href = base_url + 'card' + f() + '&page=' + page;
    }


    function getData() {
        window.location.href = f();
    }
    <?php
    if(isset($fdate) && isset($tdate)){
    ?>
    $('#daterange').val('<?php echo date('m/d/Y', strtotime($fdate))?> - <?php echo date('m/d/Y', strtotime($tdate))?>');
    <?php }?>

    $(document).ready(function () {

        $('.trCardInfo').click(function () {

            var idCard = $(this).attr('data-card-id');

            $.ajax({
                url: base_url + 'card/infoCard',
                type: 'GET',
                data: {id: idCard},
                success: function (response) {

                    $('#showCardInfo').html(response);
                    $('#myModal2').modal();
                }
            });

        });
    });
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
