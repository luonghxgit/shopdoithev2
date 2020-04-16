<div class="wrapper">
    <div class="hot-zone">
        <div class="container">

        </div>
    </div>
    <div class="main">
        <div class="container">

            <div class="row">

                <div class=" clearfix">


                    <div class="col-md-5">
                        <div class="box-header">
                            <h2>Ưu điểm khi kết nối vào hệ thống đổi thẻ cào của chúng tôi</h2>
                        </div>
                        <div class="boxx bg-white">

                            <p style="color: red;font-weight: bold;text-align: justify;">
                                Đối với các đơn vị có sản lượng tốt, luôn luôn ưu đãi tặng thêm 2% chiết khấu nếu kết
                                nối
                                API ổn định 30 ngày trong tháng. Các bạn cũng có thể giới thiệu các đầu thẻ để nhận 2%
                                chiết khấu hoa hồng
                                chêch lệch nhé
                            </p>
                            <ul>
                                <li>Hệ thống xử lí tự động, không bao giờ lỗi, luôn có người trực hệ thống 24/24</li>
                                <li>Chiết khấu tốt nhất trên thị trường</li>
                                <li>Kết nối API bảo mật, có mã nhúng, link rút gọn cho đổi thẻ cào</li>
                                <li>Duyệt tiền sau 5 phút đặt lệch</li>
                                <li>Chạy ổn định 365 ngày trong năm, kể cả tết</li>
                                <li>Thẻ sai mệnh giá vẫn tính tiền bình thường</li>
                            </ul>
                            <p style="text-align: justify;">
                                Trải qua hơn 3 năm ShopDoiThe làm cổng thanh toán trung gian cho các game, webshop, web
                                acc hay web thanh toán tự động bằng thẻ cào, hệ thống của chúng tôi rất ổn định và hỗ
                                trợ các bạn 24/24. Luôn luôn có kĩ thuật và hỗ trợ viên trực cả ngày lẫn đêm qua
                                hotline, telegram hoặc qua facebook
                            </p>
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
    $('#brandslider').slick({
        slidesToShow: 5,
        arrows: false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 1000,

    });
</script>