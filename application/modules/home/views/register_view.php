<div class="module-header">
    <div class="container">
        <h1>Đăng ký thành viên</h1>
    </div>
</div>
<div class="wrapper bg-white">
    <div class="container">
        <div class="border-ra clearfix">
            
            <div class="label label-error">
                
            </div>
            <div class="col-md-6 bdr-green">
                <form class="form-horizontal" id="idForm" method="post" action="">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="">Họ và Tên <span class="noted">*</span></label>
                            <input type="text" required name="name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="">Số điện thoại <span class="noted">*</span></label>
                            <input type="text" required name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="">Email <span class="noted">*</span></label>
                            <input type="email" required name="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="">Tên đăng nhập <span class="noted">*</span></label>
                            <input type="text" required name="username" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-sm-12">
                            <label for="">Mật khẩu <span class="noted">*</span></label>
                            <input type="password" required class="form-control" name="password" id="email"
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-sm-12">
                            <label for="">Nhắc lại mật khẩu <span class="noted">*</span></label>
                            <input type="password" required class="form-control" name="repassword" id="pwd"
                                   placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success">Đăng ký thành viên</button>
                            <div class="error"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </div>
</div>
<style>
    .bdr-green{
        border: 1px green solid;
    padding: 20px 10px;
    margin-bottom: 20px;
    }
</style>
<script>
    var base_url = '<?php echo base_url()?>';
    $("#idForm").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var url = base_url + '/home/ajx_register';
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function (data) {
                data = JSON.parse(data);
                if (data.status == 1) {
                    swal({
                        title: "Thông báo!",
                        text: "Chúc mừng bạn đăng ký thành công!",
                        icon: "success",
                        button: "Đăng nhập ngay",
                    }).then((value) => {
                        window.location.href = base_url + '/login';
                    });
                }else{
                    swal({
                        title: "Thông báo!",
                        text: data.msg,
                        icon: "error",
                        button: "Đóng",
                    })
                }
            }
        });


    });
</script>