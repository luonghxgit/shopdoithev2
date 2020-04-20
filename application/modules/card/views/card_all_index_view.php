<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Quản lý thẻ nạp [Root only]</h3>
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
                        <div class="col-md-9">
                            <div class="clearfix" style="margin-bottom: 10px">
                                <div class="col-md-4">

                                    <i class="icon-calendar"></i>
                                    <input id="daterange" class="form-control" value="">
                                </div>
                                <div class="col-md-4">
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Nhà mạng</option>
                                        <option value="VTT" <?php echo ($type == 'VTT') ? 'selected' : ''; ?>>Viettel
                                        </option>
                                        <option value="VNP" <?php echo ($type == 'VNP') ? 'selected' : ''; ?>>Vinaphone
                                        </option>
                                        <option value="VMS" <?php echo ($type == 'VMS') ? 'selected' : ''; ?>>Mobifone
                                        </option>
                                        <option value="ZING" <?php echo ($type == 'ZING') ? 'selected' : ''; ?>>Zing
                                        </option>
                                        <option value="GARENA" <?php echo ($type == 'GARENA') ? 'selected' : ''; ?>>
                                            Garena
                                        </option>
                                        <option value="VCOIN" <?php echo ($type == 'VCOIN') ? 'selected' : ''; ?>>
                                            VCOIN
                                        </option>
                                        <option value="GATE">GATE</option>
                                    </select>
                                </div>
                                <div class="col-md-4">

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
                            </div>
                            <div class="col-md-4">
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
                                    <option value="100000" <?php echo ($price == '100000') ? 'selected' : ''; ?>>
                                        100.000
                                    </option>
                                    <option value="200000" <?php echo ($price == '200000') ? 'selected' : ''; ?>>
                                        200.000
                                    </option>
                                    <option value="300000" <?php echo ($price == '300000') ? 'selected' : ''; ?>>
                                        300.000
                                    </option>
                                    <option value="500000" <?php echo ($price == '500000') ? 'selected' : ''; ?>>
                                        500.000
                                    </option>
                                    <option value="1000000" <?php echo ($price == '1000000') ? 'selected' : ''; ?>>
                                        1.000.000
                                    </option>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="status" id="status" class="form-control">
                                    <option value="100" <?php echo ($status == 100) ? 'selected' : ''; ?>>Tình trạng
                                    </option>
                                    <option value="-1" <?php echo ($status == -1) ? 'selected' : ''; ?>>Thẻ sai</option>
                                    <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>Thẻ đúng</option>


                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="button" class="btn btn-primary" onclick="getData()" value="Lọc thông tin">
                            </div>
                        </div>
                        <div class="col-md-3" id="totalcount">

                            <div class="tile-stats">
                                <div class="count"><span class="totaltoday"><?php echo number_format($todayAmonut->realvalue); ?></span></div>
                                <p>Tổng thẻ cào hôm nay</p>
                            </div>

                            <div class="tile-stats">
                                <div class="count"><span class="totaltodayafterfee"><?php echo number_format($todayAmonutAfterFee->realvalue); ?></span></div>
                                <p>Tổng tiền hôm nay</p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

        


                <div class="col-md-8">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination" style="margin:0">
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
                <table id="viewdata" class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tài khoản</th>
                        <th>Seri</th>
                        <th>Mã thẻ</th>
                        <th>Loại thẻ</th>
                        <th>Mệnh giá gửi</th>
                        <th>Mệnh giá thực</th>
                        <th>Mệnh giá chốt</th>
                        <th>Phí</th>
                        <th>Code SV</th>
                        <th>Thời gian XL</th>
                        <th>Thời gian</th>
                        <th></th>
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
                            <tr >
                                <td><?php echo $item->id; ?></td>
                                <td><?php echo $item->username; ?></td>
                                <td><?php echo $item->cardseri ?></td>
                                <td><?php echo $item->cardcode ?></td>
                                <td><?php echo $item->cardtype ?></td>
                                <td><?php echo number_format($item->cardvalue); ?></td>
                                <td><?php echo number_format($item->realvalue); ?></td>
                                <td><?php echo number_format($item->receivevalue); ?></td>
                                <td><?php echo number_format($item->rate); ?>%</td>
                                <td><?php echo number_format($item->http_code); ?></td>
                                <td><?php echo khoangcach2ngay($item->created_on,$item->modified_on); ?>%</td>
                                <td><?php echo date('H:i d/m/Y', strtotime($item->created_on)); ?></td>
                                <td ><?php
                                    $s = json_decode($item->responsed);
                                  
                                  if(isset($s->ResponseCode)){
                                      echo $s->ResponseCode;
                                  }
                                  if(isset($s->status)){
                                      echo $s->status;
                                  }
                                    ?></td>
                                <td  class="trCardInfo" data-card-id="<?php echo $item->id; ?>">
                                    <?php
                                    switch ($item->status) {
                                        case -1:
                                            $stt = '<div class="label-error">Thẻ sai</div>';
                                            break;
                                        case 1:
                                            $stt = '<div class="label-success">Thẻ đúng</div>';
                                            break;
                                        default:
                                            $stt = '<div class="label-waitting">Đang xử lý</div>';
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
    function antiSpam() {
        $.ajax({
            url: "https://shopdoithe.com/card/spam",

            success: function () {
                console.log('clear');
            } // sets timeout to 3 seconds
        });
    }

    setInterval(antiSpam, 60000);
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
        var filluser = $('#filluser').val();
        var url = '?fromdate=' + fromdate + '&todate=' + todate + '&type=' + type + '&price=' + price + '&status=' + status + '&filluser=' + filluser;

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
    <?php
    if(isset($fdate) && isset($tdate)){
    ?>
    $('#daterange').val('<?php echo date('H:i m/d/Y', strtotime($fdate))?> - <?php echo date('H:i m/d/Y', strtotime($tdate))?>');
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

    .label-waitting {
        padding: 5px;
        background: yellow;
        font-weight: bold;
        text-align: center;
        color: #FF0000;
    }
</style>
<script>
    $(".select2").select2({});
</script>


<script src="http://localhost:3000/socket.io/socket.io.js"></script>
<script>

$(document).ready(function(){
    var socketcall = io.connect( 'http://localhost:3000' );
    socketcall.emit('call_data','success');
});

var socket = io.connect( 'http://localhost:3000' );
socket.on( 'send_data', function( data ) {
    var html = '';
    for (var i = 0; i <=  data.length - 1; i++) {

        html += '<tr>';
        html += '<td>'+data[i]['id']+'</td>';
            html += '<td>'+data[i]['username']+'</td>';
            html += '<td>'+data[i]['cardseri']+'</td>';
            html += '<td>'+data[i]['cardcode']+'</td>';
            html += '<td>'+data[i]['cardtype']+'</td>';
            html += '<td>'+ number_format(data[i]['cardvalue'], 0, '.', ',') +'</td>';
            html += '<td>'+ number_format(data[i]['realvalue'], 0, '.', ',') +'</td>';
            html += '<td>'+ number_format(data[i]['receivevalue'], 0, '.', ',') +'</td>';
            html += '<td>'+ number_format(data[i]['rate'], 0, '.', ',') +'%</td>';

            html += '<td>'+data[i]['http_code']+'</td>';
            if(data[i]['modified_on']){
                html += '<td>'+ khoangcach2ngay(data[i]['created_on'],data[i]['modified_on']) +' giây</td>';
            }else{
                html += '<td>Chưa xử lý</td>';
            }

            html += '<td>'+ formatDate(data[i]['created_on'])+'</td>'; 
            html += '<td>';
            if(data[i]['responsed']){
                var objresponsed = JSON.parse(data[i]['responsed']);
                if(objresponsed.ResponseCode){
                     html += objresponsed.ResponseCode;
                }
                if(objresponsed.status){
                     html += objresponsed.status;
                }
            }

        html += '</td>';
        html += '<td>';
         var stt = '';
        if(data[i]['status'] == -1){
           stt = '<div class="label-error">Thẻ sai</div>'; 
        }else if(data[i]['status'] == 1){
            stt = '<div class="label-success">Thẻ đúng</div>';
        }else{
            stt = '<div class="label-waitting">Đang xử lý</div>';
        }
        if (data[i]['realvalue'] != data[i]['cardvalue'] && data[i]['realvalue'] > 0){
            stt = '<div class="label-smg">Sai mệnh giá</div>';
        }
        html += stt;               
        html += '</td>';
        html += '</tr>';
    }

    $("#viewdata tbody").html(html);

});


socket.on( 'send_totaltoday', function( data ) {
    if(data){
        if(data[0]['realvalue'] > 0 ){
             $("#totalcount .totaltoday").html(number_format(data[0]['realvalue'], 0, '.', ','));
         }else{
             $("#totalcount .totaltoday").html('0');
         }
       
    }
});
socket.on( 'send_totaltodayfee', function( data ) {
    if(data){
        if(data[0]['realvalue'] > 0 ){
            $("#totalcount .totaltodayafterfee").html(number_format(data[0]['realvalue'], 0, '.', ','));
        }else{
             $("#totalcount .totaltodayafterfee").html('0');
        }
    }
});


</script>
<script type="text/javascript">
    function khoangcach2ngay(date1,date2) {
        var d1 = new Date(date1);
        var d2 = new Date(date2);
        var t2 = d2.getTime();
        var t1 = d1.getTime();
        return parseInt((t2-t1)/(1000));
    }

    function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
        hour = d.getHours();
        second = d.getSeconds();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;
    return hour +':'+second+' '+[day, month, year].join('/');
}

function number_format(number, decimals, dec_point, thousands_point) {

    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }

    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }

    if (!dec_point) {
        dec_point = '.';
    }

    if (!thousands_point) {
        thousands_point = ',';
    }

    number = parseFloat(number).toFixed(decimals);

    number = number.replace(".", dec_point);

    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);

    return number;
}
</script>