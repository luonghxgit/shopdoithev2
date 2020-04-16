<div class="right_col" role="main" style="height: 1200px;">

    <div class="page-title">
        
           <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title">
                    <h2>Rút tiền về tài khoản ngân hàng / Ví</h2>
                    <div class="clearfix"></div>
            </div>
            <div class="x_content">
              
                <form action="" method="post" id="idBankingForm" class="form-label-left input_mask">
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Tài khoản có</label>
                        <div class="col-md-5 col-sm-9 ">
                          <input type="text" readonly value="<?php echo number_format($userinfo->balance);?> VNĐ" class="form-control" required placeholder="Tên ngân hàng hoặc ví momo">
                        </div>
                      </div>
                        <div class="form-group row">
                                         <label class="col-form-label col-md-3 col-sm-3 ">Ngân hàng/ Ví</label>
                                         <div class="col-md-5 col-sm-8 ">
                                            <select class="form-control" required name="bank_id" id="bank_id" onchange="getBankingInfo(this.value)">
                        <option value="">- Chọn ngân hàng -</option>
                            <?php
                            $i = 0;
                            if (isset($listBanks[0])) {
                                foreach ($listBanks as $item) {
                                    $i++;
                                    ?>
                          <option value="<?php echo $item->id;?>"><?php echo $item->name;?> - Chi nhánh: <?php echo $item->chinhanh;?></option>
                          <?php
                                } }?>
                        </select>
                        </div>
                              <div class="col-md-4">
                               <a href="<?php echo base_url('bank')?>"><i class="fa fa-plus-circle"></i> &nbsp;Thêm tài khoản ngân hàng</a>
                              </div>
                      </div>
                       <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Số tiền rút</label>
                         
                        <div class="col-md-5 col-sm-9 ">
                          <input type="number" max="<?php echo $userinfo->balance;?>" min="100000" name="money" class="form-control" required placeholder="">
                        </div>
                      </div>
                       <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Chủ tài khoản</label>
                        <div class="col-md-5 col-sm-9 ">
                          <input type="text" name="name" id="name" readonly class="form-control" required placeholder="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3">Số tài khoản</label>
                        <div class="col-md-5 col-sm-9 ">
                          <input type="text" name="bank_number" id="bank_number" readonly class="form-control" required placeholder="">
                        </div>
                      </div>
					  <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3">Email xác thực giao dịch</label>
                        <div class="col-md-5 col-sm-9 ">
                          <input type="text" name="email" value="<?php echo $userinfo->email;?>" readonly class="form-control" required placeholder="">
                        </div>
                      </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3">Ghi chú</label>
                        <div class="col-md-5 col-sm-9 ">
                            <textarea name="note" id="" class="form-control" rows="3" placeholder=""></textarea>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                      <div class="form-group row">
                        <div class="col-md-9 col-sm-9  offset-md-3">
                          <button type="reset" class="btn btn-default">Làm lại</button>
						   <button class="btn btn-primary" type="submit">Xác nhận</button>
                         
                        </div>
                      </div>
 
                    </form>
            </div>
           
           
            </div>
        </div>
           <div class="col-md-4">
         <div class="x_panel">
          
            <div class="x_content">
            
                    <ul>
						<li>Rút tiền về tài khoản hoàn toàn miễn phí 	</li>
						<li>Số tiền rút phải nhỏ hơn hoặc bằng số dư hiện có</li>
					</ul>
                
            </div>
        </div>
    </div>
           <div class="col-md-12">
            <div class="x_panel">
            <div class="x_title">
                    <h2>Giao dịch rút tiền</h2>
                    <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th>Mã giao dịch</th>
                        <th>Số tiền rút</th>
                        <th>Chủ tài khoản</th>
                         <th>Số tài khoản</th>
                        <th>Ngân hàng</th>
                        <th>Chi nhánh</th>
                        <th>Email xác thực</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($listBankings[0])){
                        foreach($listBankings as $item){
                        ?>
                        <tr>
                            <td><?php echo $item->code;?></td>
                            <td><?php echo number_format($item->money);?></td>
                            <td><?php echo $item->bank_name;?></td>
                            <td><?php echo $item->bank_number;?></td>
                            <td><?php echo $item->bank_bankname;?></td>
                            <td><?php echo $item->bank_chinhanh;?></td>
                            <td><?php echo $item->email;?></td>
                            <td>
                                <?php
                                $stt = '';
                                switch($item->status){
                                    case -1:  $stt = '<div class="label-error">Thất bại!</div>';break;
                                    case 0:  $stt = '<div class="label-warning">Chờ chuyển tiền!</div>';break;
                                    case 1:  $stt = '<span class="label-success">Thành công!</span>';break;
                                    default: $stt = '<span class="label-info">Lỗi</span>';break;
                                }
                                ?>
                                <?php echo $stt;?>
                            
                            </td>
                        </tr>
                        
                        <?php }}else{?>
                        <tr>
                         <td colspan="8" style="text-align:center;">Không tìm thấy kế quả nào!</td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
           </div>
           </div>
        </div>
    
    </div>
</div>
<style>
    .label-success {
    padding: 5px;
    background: #00A000;
    font-weight: bold;
    text-align: center;
    color: #fff;
}
.label-error {
    padding: 5px;
    background: #FF0000;
    font-weight: bold;
    text-align: center;
    color: #fff;
}
.label-warning {
    padding: 5px;
    background:#ffc107 ;
    font-weight: bold;
    text-align: center;
    color: #fff;
}
</style>
 <script>
    $("#idBankingForm").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');
sendData(form.serialize());


});
   var getBankingInfo = (id) =>{
        $.ajax({
            url : base_url + 'bank/ajxGetBank',
            type: 'GET',
            dataType:'JSON',
            data: {id:id},
            success:function(res){
            
               $('#name').val(res.name);
               $('#bank_number').val(res.bank_number);
              
            }
        })
    };
    
    var sendData = (data) =>{
        $.ajax({
            url : base_url + 'banking/ajxInsertBanking',
            type: 'POST',
            dataType:'JSON',
            data: data,
            success:function(res){
                if(res.status == 1){
                    Swal.fire(
                        'Thông báo',
                        'Lệnh rút tiền thành công. Chúng tôi sẽ xử lý trong thời gian sớm nhất!',
                        'success'
                      )
                    window.location.reload();
                }else{
                     Swal.fire(
                        'Thông báo',
                        'Giao dịch thất bại',
                        'error'
                      )
                }
        
            }
        })
    }
    
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
