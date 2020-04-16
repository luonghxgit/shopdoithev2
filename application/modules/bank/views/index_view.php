<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        
           <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title">
                    <h2>Danh sách tài khoản ngân hàng</h2>
                    <div class="clearfix"></div>
            </div>
            <div class="x_content">
              
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th>#</th>

                        <th>Tên ngân hàng</th>
                        <th>Chi nhánh</th>
                        <th>Chủ tài khoản</th>
                        <th>Số tài khoản</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    if (isset($listBanks[0])) {
                        foreach ($listBanks as $item) {
                            $i++;
                            ?>
                             <tr>
								<td></td>
								<td><?php echo $item->bankname?></td>
								<td><?php echo $item->chinhanh?></td>
								<td><?php echo $item->name?></td>
								<td><?php echo $item->bank_number?></td>
								 
								<td></td>
							 </tr>
                        <?php }
                    } else { ?>

                        <tr>
                            <td colspan="9" style="text-align: center">Hiện không có kết quả nào!</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
           
           
            </div>
        </div>
           <div class="col-md-4">
         <div class="x_panel">
            <div class="x_title">
                    <h2>Thêm mới tài khoản ngân hàng</h2>
                    <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="x_content">
                    <br>
                    <form action="" method="post" class="form-label-left input_mask">
 

                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Ngân hàng/ Ví</label>
                        <div class="col-md-9 col-sm-9 ">
                          <input type="text" name="bankname" class="form-control" required placeholder="Tên ngân hàng hoặc ví momo">
                        </div>
                      </div>
                       <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Chi nhánh</label>
                         
                        <div class="col-md-9 col-sm-9 ">
                          <input type="text" name="chinhanh" class="form-control" required placeholder="">
                        </div>
                      </div>
                       <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Chủ tài khoản</label>
                        <div class="col-md-9 col-sm-9 ">
                          <input type="text" name="name" class="form-control" required placeholder="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Số tài khoản</label>
                        <div class="col-md-9 col-sm-9 ">
                          <input type="text" name="bank_number" class="form-control" required placeholder="">
                        </div>
                      </div> 
                      <div class="ln_solid"></div>
                      <div class="form-group row">
                        <div class="col-md-9 col-sm-9  offset-md-3">
                          <button type="reset" class="btn btn-default">Làm lại</button>
						   <button class="btn btn-primary" type="submit">Thêm tài khoản</button>
                         
                        </div>
                      </div>

                    </form>
                  </div>
            </div>
        </div>
    </div>
        </div>
    
    </div>
</div>
 
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
