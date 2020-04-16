<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        <div class="title_left">
            <h3>Cài đặt thẻ</h3>
        </div>

        <div class="x_panel">
            <div class="x_content">
                <br>
                <div class="col-md-8">
                    <form class="form-label-left input_mask" method="post" action="">
                        <?php if(isset($mess)){?>
                        <div class="alert alert-success"><?php echo $mess?></div>
                        <?php }?>
                        <?php if(isset($error)){?>
                            <div class="alert alert-danger"><?php echo $error?></div>
                        <?php }?>
                        <input type="hidden" name="id" value="<?php echo $type->id?>">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Loại thẻ</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" name="name" class="form-control" value="<?php echo $type->name; ?>" readonly
                                       placeholder="Default Input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Mã thẻ </label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" class="form-control" name="code" value="<?php echo $type->code; ?>"
                                       placeholder="Disabled Input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Mệnh giá chấp nhận</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" class="form-control" name="allow_money" value="<?php echo $type->allow_money; ?>"
                                       placeholder="Read-Only Input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Phí thu thẻ (%)</label>
                            <div class="col-md-3 col-sm-3 ">
                                <input type="text" class="form-control" name="discount" value="<?php echo $type->discount; ?>"
                                       placeholder="Read-Only Input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Trạng thái <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-3 col-sm-3 ">
                                <select name="status" id="" class="form-control">
                                    <option value="1" <?php echo ($type->status == 1)?'selected':'';?>>Kích hoạt</option>
                                    <option value="0" <?php echo ($type->status == 0)?'selected':'';?>>Không</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Cổng thanh toán <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-3 col-sm-3 ">
                                <select name="gate" id="" class="form-control">
                                    <option value="sdtvn" <?php echo ($type->gate == 'sdtvn')?'selected':'';?>>sdtvn</option>
                                    <option value="cms" <?php echo ($type->gate == 'cms')?'selected':'';?>>cms</option>
                                </select>
                            </div>
                        </div>
                        <?php
/*                        if ($type->code == 'ZING') {
                            */?><!--
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 ">Game <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-3 col-sm-3 ">
                                    <input type="text" name="zing_game" value="<?php /*echo $type->zing_game*/?>" class="form-control">
                                </div>
                                <label class="col-form-label col-md-3 col-sm-3 ">Tài khoản <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-3 col-sm-3 ">
                                    <input type="text" name="zing_account" value="<?php /*echo $type->zing_account*/?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 ">config <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 ">
                                    <input type="text" name="config" value="<?php /*echo $type->config*/?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3 col-sm-3 ">Zing Cookie <span
                                            class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 ">
                                    <textarea name="zing_cookie" id="" cols="30" rows="10" class="form-control"><?php /*echo $type->zing_cookie*/?></textarea>
                                </div>
                            </div>
                        --><?php /*} */?>

                        <div class="ln_solid"></div>
                        <div class="form-group row">
                            <div class="col-md-9 col-sm-9  offset-md-3">


                                <button type="submit" class="btn btn-success">Cập nhật</button>
                                <a href="<?php echo base_url('cardtype')?>" class="btn btn-primary" type="reset">Thoát</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>