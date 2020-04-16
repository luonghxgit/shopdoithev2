<div class="wrapper">
    <div class="hot-zone">
        <div class="container">

        </div>
    </div>
    <div class="main">
        <div class="container">

            <div class="row">

                <div class=" clearfix">

                    <div class="col-md-12">
                        <marquee behavior="" direction="">
                            <b>Thông báo</b>: <span style="color: red;">Chiết khấu Viettel, Mobi, Vina tăng 1% từ ngày 01/04/2020. Xin cảm ơn!</span>
                        </marquee>
                    </div>
                    <div class="col-md-5">
                        <div class="box-header">
                            <h2>Đổi thẻ cào thành tiền mặt</h2>
                        </div>
                        <div class="boxx">

                            <form class="form-horizontal" action="" method="post" id="homeSendCard">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="">Loại thẻ</label>
                                        <select name="cardType" id="cardType" class="form-control">
                                            <option value=""> - Chọn loại thẻ -</option>

                                            <option value="VTT">Viettel</option>

                                            <option value="VMS">Mobifone</option>
                                            <option value="VNP">Vinaphone</option>
                                            <option value="ZING">Zing</option>
                                            <option value="VCOIN">Vcoin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="">Mệnh giá</label>
                                        <select name="cardValue" id="cardValue" class="form-control">
                                            <option value=""> - Chọn mệnh giá -</option>
                                            <option value="10000">10.000đ</option>
                                            <option value="20000">20.000đ</option>
                                            <option value="30000">30.000đ</option>
                                            <option value="40000">40.000đ</option>
                                            <option value="50000">50.000đ</option>
                                            <option value="100000">100.000đ</option>
                                            <option value="200000">200.000đ</option>
                                            <option value="500000">500.000đ</option>
                                            <option value="1000000">1.000.000đ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="col-sm-12">
                                        <label for="">Seri</label>
                                        <input type="text" class="form-control" name="cardSeri" id="cardSeri"
                                               placeholder="Nhập seri">
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="col-sm-12">
                                        <label for="">Mã thẻ</label>
                                        <input name="cardCode" type="text" class="form-control" id="cardCode"
                                               placeholder="Nhập mã thẻ">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success">Đổi thẻ</button>
                                    </div>
                                </div>
                                <div class="msg-show">
                                    <div id="errorMssShow" class="alert alert-danger alert-dismissible "
                                         style="display:none;">

                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="col-md-7">
                        <div class="boxx bg-white">

                            <table class="table table-bordered table2">
                                <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>Loại thẻ
                                    </th>
                                    <th>Biểu phí
                                    </th>
                                    <th>Trạng thái
                                    </th>
                                    <th>Thời gian xử lý
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                if (isset($allCardtypes[0])) {
                                    foreach ($allCardtypes as $item) {
                                        ?>
                                        <tr>
                                            <td>
                                                1
                                            </td>
                                            <td>
                                                <?php echo $item->name; ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?php echo $item->discount; ?>%
                                            </td>
                                            <td style="text-align:center;">
                                                <?php
                                                if ($item->status == 1 && $item->code != 'GARENA') {
                                                    ?>
                                                    <span style="color: green;font-weight:bold;">Hoạt động</span>
                                                <?php } else {
                                                    ?>
                                                    <span style="color: red;font-weight:bold;">Bảo trì</span>
                                                <?php } ?>
                                            </td>
                                            <td>1 Giây Auto 24/24h</td>

                                        </tr>
                                    <?php }
                                } ?>

                                </tbody>

                            </table>
                            <table border="1" style="border-radius:10px; border:1px solid red; width:100%">
                                <tbody>
                                <tr>
                                    <td style="text-align:center;padding:5px;">
                                        <p>
                                            <span style="font-size:18px"><strong>Hotline : 0981.371.661 - Doãn Thanh Facebook <a
                                                            href="https://www.facebook.com/iken.official">Bấm Vào Đây</a></strong></span>
                                        </p>

                                        <p><strong>Lưu ý 1:</strong>&nbsp;Bank tiền sau 5 phút. Api và mã nhúng tích hợp
                                            website</p>

                                        <p><strong>Lưu ý 2</strong>: Chạy Tự Động Ổn Định 24/24h. Chiết khấu đều 30 ngày
                                            Thẻ Sai Mệnh Giá</p>

                                        <p><strong>Mệnh Giá Khai Báo &gt; Mệnh Giá Thật : Tính&nbsp;Mệnh Giá
                                                Thật</strong></p>

                                        <p><strong>Mệnh Giá Khai Báo &lt; Mệnh Giá Thật : Tính Mệnh Giá Khái
                                                Báo</strong></p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="partner bg-white">
        <div class="container">
            <div class="partner">

            </div>
        </div>
    </div>
    <div class="home-news bg-white">
        <div class="container">
            <h2 class="module-title">
                Tin tức
            </h2>
            <div class="slider-news">
                <div class="row">

                    <div class="col-md-4">
                        <div class="news-item">
                            <div class="thumb"><a href=""><img
                                            src="<?php echo base_url('publics/images/dia-chi-doi-the-cao-thanh-tien.png') ?>"
                                            alt=""></a>
                            </div>
                            <div class="title"><a href=""> lợi ích khi khi sử dụng dịch vụ đổi thẻ cào thành tiền mặt
                                </a></div>
                            <div class="desc">Bạn đang có nhu cầu kiểm tra các loại thẻ game hay thẻ điện thoại xem
                                đã sử dụng hay chưa, Như kiểm tra thẻ vcoin đã sử dụng hay chưa mà không biết tra
                                cứu kiểm tra bằng cách nào cho chính xác và an toàn tránh bị mất thẻ, Bài viết này
                                sẽ hướng dẫn các bạn cách kiểm tra thẻ đã sử dụng hay chưa .
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="news-item">
                            <div class="thumb"><a href=""><img
                                            src="<?php echo base_url('publics/images/thumb_avatar_dcimg.png') ?>"
                                            alt=""></a>
                            </div>
                            <div class="title"><a href="">Có những cách nạp tiền điện thoại nào cho thuê bao
                                    Viettel? </a></div>
                            <div class="desc">Viettel là một trong các nhà mạng lớn nhất, chính vì vậy số lượng thẻ cào
                                điện thoại dành cho cá thuê bao của Viettel cũng là khổng lồ. Hiện nay, nhà mạng Viettel
                                đã có 2 hình thức nạp thẻ cho điện thoại đó là nạp thẻ cào giấy truyền thống và nạp thẻ
                                cào online.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="news-item">
                            <div class="thumb"><a href=""><img
                                            src="<?php echo base_url('publics/images/cachkt.png') ?>" alt=""></a>
                            </div>
                            <div class="title"><a href="">Hướng dẫn kiểm tra thẻ Vcoin, Gate , Zing vinagame đã sử
                                    dụng hay chưa
                                </a></div>
                            <div class="desc">Nạp thẻ cào online không còn quá xa lạ đối với người dùng điện thoại di
                                động hiện nay. Rất người khách hàng, nhất là các game thủ, khi có quá nhiều thẻ cào dư
                                và không dùng đến đã sử dụng cách nạp thẻ cào để tăng số dư tài khoản trong ví online
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="partner">
        <div class="container">
            <div class="row">
                <div class="brand-slider">

                    <ul id="brandslider">
                        <li><img src="https://cdn.fing.io/images/isp/VN/logo/viettel_logo.png" alt=""></li>
                        <li><img src="https://vnreview.vn/image/33/40/334017.jpg" alt=""></li>
                        <li><img src="https://blog.topcv.vn/wp-content/uploads/2018/04/mobifone-logo.png" alt=""></li>
                        <li><img src="https://upload.wikimedia.org/wikipedia/vi/5/5e/Zing_official_logo.png" alt="">
                        </li>
                        <li><img src="https://ngaothien.gamota.com/static/uploads/content/vcoin-icon.jpg" alt=""></li>
                        <li><img src="https://cdn.fing.io/images/isp/VN/logo/viettel_logo.png" alt=""></li>
                        <li><img src="https://vnreview.vn/image/33/40/334017.jpg" alt=""></li>
                        <li><img src="https://blog.topcv.vn/wp-content/uploads/2018/04/mobifone-logo.png" alt=""></li>
                        <li><img src="https://upload.wikimedia.org/wikipedia/vi/5/5e/Zing_official_logo.png" alt="">
                        </li>
                        <li><img src="https://ngaothien.gamota.com/static/uploads/content/vcoin-icon.jpg" alt=""></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?php echo base_url()?>';
    $('#brandslider').slick({
        slidesToShow: 5,
        arrows: false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 1000,

    });

    $("#homeSendCard").submit(function (e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        $('#errorMssShow').show().html('Thẻ đang xử lý. Xin vui lòng chờ trong giây lát').css('font-weight', 'bold').css('background-color', '#efefef');
        var form = $(this);
        var url = base_url + 'home/ajx_sendcard';

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                var msg = JSON.parse(data);
                if (msg.status == -1) {

                    $('#errorMssShow').show().html(msg.msg).css('font-weight', 'bold');

                }
            }
        });


    });
</script>