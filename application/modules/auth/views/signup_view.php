<form action="<?php echo base_url('auth/signup')?>" method="post">
    <div class="container">
        <div class="col-md-2"></div>
        <div class="col-md-8">

                <h1>Đăng ký thành viên</h1>
                <hr>
            <?php if (isset($message) && $message) { ?>
                <!-- alert alert-info alert-dismissible -->
                <div style="display: block;"
                     class="alert <?php echo $message['success'] ? 'alert-info ' : 'alert-danger '; ?>alert-dismissible"
                     id="message">
                    <button type="button" id="btn-close-msg" class="close" data-dismiss="alert"
                            aria-hidden="true">×
                    </button>
                    <p id="message-content"><?php echo $message['msg']; ?></p>
                </div>
            <?php } ?>
                <p>Thông tin tài khoản</p>


                <label for="username"><b>Tên đăng nhập</b> <span data-toggle="popover" data-placement="bottom"
                                                              title="Quy định"
                                                              data-content="Bao gồm các kí tự a-z,A-Z,0-9, tối thiểu 6 ký tự"><i class="glyphicon glyphicon-info-sign"></i></span></label>
                <input type="text" placeholder="Tên đăng nhập" name="username" required>

                <label for="psw"><b>Mật khẩu</b></label>
                <input type="password" placeholder="Mật khẩu" name="password" required>

                <label for="psw-repeat"><b>Nhắc lại mật khẩu</b></label>
                <input type="password" placeholder="Nhập lại mật khẩu" name="re_password" required>
                <hr>
                <!-- <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p> -->
                <p>Thông tin cá nhân</p>
                <div class="row">
                    <div class="col-md-6">
                        <label for="name"><b>Họ và tên</b></label>
                        <input type="text" placeholder="Họ và Tên" name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone"><b>Điện thoại</b></label>
                        <input type="text" placeholder="Điện thoại" name="phone" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email"><b>Email</b></label>
                        <input type="text" placeholder="Email" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="address"><b>Địa chỉ</b></label>
                        <input type="text" placeholder="Địa chỉ" name="address" required>
                    </div>
                </div>
            <input type="hidden" name="status" value="1">
                <button type="submit" class="registerbtn">Đăng ký</button>


            <div class="container signin">
                <p>Bạn đã có tài khoản? <a href="#">Đăng nhập ngay</a>.</p>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        //   $('[data-toggle="popover"]').popover();

        $('[data-toggle="popover"]').popover({trigger: "hover"});
    });
</script>
<style>

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit button */
    .registerbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity: 1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {

        text-align: left;
    }
</style>