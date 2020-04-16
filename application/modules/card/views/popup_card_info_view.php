<?php
$user_data = $this->session->userdata('user_data');
?>
<div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document" style="width: 40%;max-width: none;">
        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="myModalLabel2"><strong>Chi tiết thẻ</strong></h4>
            </div>

            <div class="modal-body">
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Mã giao dịch</label>

                    <div class="col-sm-9">
                        <?php echo $card->request_id; ?>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Thời gian gửi</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly
                               value="<?php echo date('H:i:s d/m/Y', strtotime($card->created_on)); ?>">
                    </div>

                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Thời gian gạch thẻ</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly
                               value="<?php echo date('H:i:s d/m/Y', strtotime($card->modified_on)); ?>">
                    </div>

                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Seri thẻ</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly style="color: red;font-weight: bold;"
                               value="<?php echo $card->cardseri; ?>">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Mã thẻ</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly style="color: red;font-weight: bold;"
                               value="<?php echo $card->cardcode; ?>">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Loại thẻ</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly style="color: blue;font-weight: bold;"
                               value="<?php echo $card->cardtype; ?>">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Mệnh giá gửi</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly
                               value="<?php echo number_format($card->cardvalue); ?>">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Mệnh giá thực</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly
                               value="<?php echo number_format($card->realvalue); ?>">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Mệnh giá chốt</label>
                    <div class="col-sm-9">
                        <select name="" id=""
                                class="form-control"<?php echo ($card->status == '-1') ? 'disabled' : ''; ?>>
                            <option value="<?php echo $card->receivevalue; ?>"><?php echo number_format($card->receivevalue); ?></option>

                        </select>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Trạng thái</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly value="<?php echo $card->status; ?>">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Đối tác</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" readonly
                               value="[ <?php echo $card->user_id . ' ] ' . $card->username; ?>">
                    </div>
                </div>
                <?php
                if ($user_data['role'] == 1) {
                ?>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">IP đối tác</label>

                    <div class="col-sm-9">
                        <?php
                        $request = json_decode($card->request_header);

                        ?>
                        <input type="text" class="form-control" readonly
                               value="<?php echo $request->REMOTE_ADDR; ?>">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">API</label>

                    <div class="col-sm-9">

                        <input type="text" class="form-control" readonly
                               value="<?php echo $card->api; ?>">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Thông tin</label>

                    <div class="col-sm-9">
                        <div class="label label-default">
                            <?php
                            if (isset($card->responsed)) {
                                $response = json_decode($card->responsed);
                                echo '[' . $response->status . '] ' . $response->result;
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label for="kpi_request" class="control-label col-sm-3">Thông tin</label>

                    <div class="col-sm-9">
                        <?php
                        if (isset($card->responsed)) {
                            $response = json_decode($card->responsed);
                            echo '[' . $response->ResponseCode . '] ' . $response->Description;
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group clearfix">


                    <?php
                    if (isset($callbackSend->http_code)) {

                    ?>

                    <div class="alert alert-info" style="word-break: break-all;">
                        <b><?php
                            echo '[' . date('H:i:s d/m/Y', strtotime($callbackSend->created_on)) . ' - code: ' . $callbackSend->http_code . '] ==> ' . $callbackSend->url;
                            ?></b>
                        <hr>

                        <?php echo $callbackSend->data; ?></div>

                </div>
            <?php } ?>

                <?php
                if (isset($callbacklog->created_on)) {

                ?>

                <div class="alert alert-warning" style="word-break: break-all;">
                    <b><?php
                        echo '[' . date('H:i:s d/m/Y', strtotime($callbacklog->created_on)) . ']'
                        ?></b>
                    <hr>

                    <?php echo $callbacklog->content; ?></div>

            </div>
            <?php } ?>
            <?php } ?>


            <div class="modal-footer">
                <?php

                if ($card->status != 1 && $user_data['role'] == 1) {
                    ?>
                    <div class="text-left inline-block">
                        <span class="modal-notice text-danger bold ver-middle marleft10"></span>
                        <button id="btnCardTrue" class="btn btn-sm btn-primary"
                                onclick="trueCard(<?php echo $card->id; ?>)" type="button"
                        >
                            Thẻ đúng
                        </button>
                    </div>
                    <div class="text-left inline-block">
                        <span class="modal-notice text-danger bold ver-middle marleft10"></span>
                        <a class="btn btn-sm btn-warning" target="_blank" href="<?php echo base_url('api/reCalltocms/'.$card->id); ?>">
                            Đẩy thẻ sang CMS
                        </a>
                    </div>
                <?php } ?>
                <div class="text-left inline-block">
                    <span class="modal-notice text-danger bold ver-middle marleft10"></span>
                    <button id="booking_save" type="submit" class="btn btn-success btn-sm" data-dismiss="modal"
                            aria-label="Close">
                        Đóng
                    </button>

                </div>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
<?php
if ($card->status != 1 && $user_data['role'] == 1) {
    ?>
    <script>
        var trueCard = (cardId) => {
            if (confirm('Bạn có chắc chắn thực hiện thao tác này không?')) {
                $.get("<?php echo base_url('card/updateGarenaTrue/')?>" + cardId, function (data, status) {
                    $('#btnCardTrue').hide();
                    window.location.reload();
                });
            }
            if (confirm('Bạn có chắc chắn thực hiện thao tác này không?')) {
                $.get("<?php echo base_url('card/updateCardFalse/')?>" + cardId, function (data, status) {
                    $('#btnCardTrue').hide();
                    window.location.reload();
                });
            }
        }
    </script>
<?php } ?>
<style>
    .modal h4 {
        font-size: 18px;
    }

    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 320px;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    /*Left*/
    .modal.left.fade .modal-dialog {
        left: -320px;
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.in .modal-dialog {
        left: 0;
    }

    /*Right*/
    .modal.right.fade .modal-dialog {
        right: 0;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }

    /* ----- MODAL STYLE ----- */
    .modal-content {
        border-radius: 0;
        border: none;
    }

    .modal-header {
        border-bottom-color: #EEEEEE;
        background-color: #FAFAFA;
    }

</style>