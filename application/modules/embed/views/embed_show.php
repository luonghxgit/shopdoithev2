<?php
$generate = strtoupper(md5($token));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mã nhúng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">

    <script>
        var tk = '<?php echo $token;?>';
    </script>
</head>
<body>
<div class="ce_wrapper_<?php echo $token; ?>">
    <form method="post" id="form_<?php echo $token; ?>">
        <input type="hidden" name="code" value="<?php echo $token; ?>">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Loại thẻ</label>
            <select class="form-control"  id="T<?php echo $generate; ?>" name="T<?php echo $generate; ?>">
                <option value=""> - Loại thẻ -</option>
                <option value="VTT">Viettel</option>
                <option value="VNP">Vinaphone</option>
                <option value="VMS">Mobifone</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect2">Mệnh giá</label>
            <select class="form-control" id="V<?php echo $generate; ?>" name="V<?php echo $generate; ?>">
                <option value=""> - Chọn mệnh giá -</option>
                <option value="10000">10.000</option>
                <option value="20000">20.000</option>
                <option value="30000">30.000</option>
                <option value="50000">50.000</option>
                <option value="100000">100.000</option>
                <option value="200000">200.000</option>
                <option value="300000">300.000</option>
                <option value="500000">500.000</option>
                <option value="1000000">1.000.000</option>
            </select>
        </div>
        <div class="form-group"><label for="">Seri thẻ</label>
            <input type="text" name="S<?php echo $generate; ?>" id="S<?php echo $generate; ?>" class="form-control">
        </div>
        <div class="form-group"><label for="">Mã thẻ thẻ</label>
            <input type="text" class="form-control" name="C<?php echo $generate; ?>" id="C<?php echo $generate; ?>">
        </div>
        <div class="form-group">
            <div class="alert alert-danger" id="errorMsg" style="display: none;"></div>
            <div class="alert alert-success" id="errorSuccess" style="display: none;"></div>
            <div class="alert alert-warning" style="display: none;font-weight: bold;color: red;" id="alert"></div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success" style="width: 100%;">Nạp thẻ</button>
        </div>
    </form>
</div>
<style>
    .ce_wrapper_<?php echo $token;?> {
        padding: 10px;
    }

    .ce_wrapper_<?php echo $token;?> label {
        font-weight: bold;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="<?php echo base_url('publics/embedConfig.js') ?>"></script>
<script>
    $(document).ready(function () {
        $("#form_" + tk).submit(function (event) {
            var f = $(this);
            event.preventDefault();
            if ($('#T<?php echo $generate;?>').val() == '') {
                $('#alert').show().html('Bạn chưa chọn loại thẻ!');
                return false;
            }
            if ($('#V<?php echo $generate;?>').val() == '') {
                $('#alert').show().html('Bạn chưa chọn mệnh giá!');
                return false;
            }
            if ($('#S<?php echo $generate;?>').val() == '') {
                $('#alert').show().html('Bạn chưa nhập seri thẻ !');
                return false;
            }
            if ($('#C<?php echo $generate;?>').val() == '') {
                $('#alert').show().html('Bạn chưa nhập mã thẻ !');
                return false;
            }
            $.ajax({
                url: config.submitUrl,
                type: 'POST',
                data: f.serialize(),
                success: function (response) {
                        var res = JSON.parse(response);
                        if(res.status == -1){
                            $('#errorMsg').show().html(res.msg);
                        }else{
                            $('#errorSuccess').show().html(res.msg);
                        }
                }

            })
            console.log('submited');

        });
    });
</script>


</body>
</html>
