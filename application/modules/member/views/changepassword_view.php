<div class="right_col" role="main" style="height: 1200px;">
 
        
		 <div class="x_panel">
            <div class="x_title">
                    <h2>Thông tin cá nhân</h2>
                    <div class="clearfix"></div>
            </div>
			<?php
		//	print_r($info);
			?>
            <div class="x_content">
				<?php
				if(isset($mess)){
				?>
				<div class="alert alert-success">
					<?php echo $mess?>
				</div>
				<?php }?>
				<form action="" method="post" onsubmit="return chk();" class="form-horizontal form-label-left">
					<input type="hidden" name="id" value="<?php echo $info->id?>"/>
						<div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Tên đăng nhập <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <input  class="form-control" readonly value="<?php echo $info->username;?>" type="text">
                        </div>
                      </div>
                     
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Mật khẩu mới <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <input type="password" id="password" name="password" required  value=""  class="form-control">
                        </div>
                      </div>
                       
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="number">Nhắc lại mật khẩu <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <input type="password" id="repassword" name="repassword" required  value="" class="form-control">
                        </div>
                      </div>
                       
                       
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 offset-md-3">
                           
                          <button id="send" type="submit" class="btn btn-success">Cập nhật dữ liệu</button>
                        </div>
                      </div>
                    </form>
				</div>
				</div>
	 
</div>
<script>
	var chk = () =>{
		let id = $('#id').val();
		let password = $('#password').val();
		let repassword = $('#repassword').val();
		if(password != repassword){
			  Swal.fire(
                        'Thông báo',
                        'Mật khẩu không trùng khớp',
                        'error'
                      )
			  return false;
		}
		return true;
	}
</script>