<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Thông tin kết nối API</h3>
        </div>
        <div class="title_right">

        </div>
        <div class="x_panel">
            <div class="x_content">
                <div class="form-group clearfix">
                    <div class="col-md-2">Tài khoản</div>
                    <div class="col-md-9"><input value="<?php echo $info->username; ?>" readonly type="text"
                                                 class="form-control"></div>
                </div>

                <div class="form-group clearfix">
                    <div class="col-md-2">Merchant Key</div>
                    <div class="col-md-9"><input type="text" class="form-control" readonly
                                                 value="<?php echo $info->key; ?>"></div>
                </div>
                <div class="form-group clearfix">
                    <div class="col-md-2">Tài liệu tích hợp</div>
                    <div class="col-md-9"><a style="font-weight: bold;" href="<?php echo base_url('publics/shopdoithe_tailieutichhop.docx')?>">download</a></div>
                </div>
                <div class="form-group clearfix">
                    <div class="col-md-2">Mô tả</div>
                    <div class="col-md-9">

                        <!-- start accordion -->
                        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">

                            <div class="panel">
                                <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse"
                                   data-parent="#accordion" href="#collapseThree" aria-expanded="false"
                                   aria-controls="collapseThree">
                                    <h4 class="panel-title">API Gạch thẻ - GET</h4>
                                </a>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <ul>
                                            <li><span>URL</span>: https://shopdoithe.com/api/sendCard_v2</li>
                                            <li><span>Method</span>: GET</li>
                                            <li><span>Param</span>:
                                                <ul>
                                                    <li><strong>key</strong>: <?php echo $info->key; ?> </li>
                                                    <li><strong>cardType</strong>: Loại thẻ VTT, VMS, VNP, ZING</li>
                                                    <li><strong>cardSeri</strong>: Seri thẻ</li>
                                                    <li><strong>cardCode</strong>: Mã thẻ</li>
                                                    <li><strong>cardValue</strong>:Giá trị thẻ.</li>
                                                    <li><strong>Signature</strong>: Mã khóa giao dịch.
                                                        md5(key+cardCode+cardSeri)
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><span>Kết quả</span>
                                                <ul>
                                                    <li>1 : Nạp thẻ thành công</li>
                                                    <li>-1 : Thẻ lỗi hoặc đã được sử dụng</li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end of accordion -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>