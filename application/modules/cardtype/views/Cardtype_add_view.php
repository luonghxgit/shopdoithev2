<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Thêm mới thẻ</h3>
        </div>

        <div class="x_panel">
            <div class="x_content">
                <br>
                <div class="col-md-8">
                    <form class="form-label-left input_mask" method="post" action="">
                        <?php if (isset($mess)) { ?>
                            <div class="alert alert-success"><?php echo $mess ?></div>
                        <?php } ?>
                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger"><?php echo $error ?></div>
                        <?php } ?>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Loại thẻ</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" name="name" class="form-control" value=""
                                       placeholder="Loại thẻ">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Mã thẻ </label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" class="form-control" name="code" value=""
                                       placeholder="Mã thẻ">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Mệnh giá chấp nhận</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" class="form-control" name="allow_money" value=""
                                       placeholder="Mệnh giá, cách nhau dấu phẩy (,)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Phí thu thẻ (%)</label>
                            <div class="col-md-3 col-sm-3 ">
                                <input type="text" class="form-control" name="discount" value=""
                                       placeholder="Tỉ lệ thu (%)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Trạng thái <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-3 col-sm-3 ">
                                <select name="status" id="" class="form-control">
                                    <option value="0">Kích hoạt</option>
                                    <option value="1">Không</option>
                                </select>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <div class="form-group row">
                                <h2>Zing</h2>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 ">Game <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-3 col-sm-3 ">
                                    <input type="text" name="zing_game" value="" class="form-control">
                                </div>
                                <label class="col-form-label col-md-3 col-sm-3 ">Tài khoản <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-3 col-sm-3 ">
                                    <input type="text" name="zing_account" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 ">config <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 ">
                                    <input type="text" name="config" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 ">Zing Cookie <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 ">
                                    <textarea name="zing_cookie" id="" cols="30" rows="10"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="ln_solid"></div>
                        <div class="form-group row">
                            <div class="col-md-9 col-sm-9  offset-md-3">


                                <button type="submit" class="btn btn-success">Cập nhật</button>
                                <a href="<?php echo base_url('cardtype') ?>" class="btn btn-primary"
                                   type="reset">Thoát</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>