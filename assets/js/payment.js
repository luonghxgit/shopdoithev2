(function(){
    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
    //Store credit card
    var store_credit_card = function($form){
        $.ajax({
            url: base_url + 'landing/payment/auth',
            data: $form.serializeObject(),
            type: 'post',
            dataType: 'json',
            success: function(result){
                console.log(result);
            },
            error: function(err){
                console.log(err);
            }
        });
    };
    var init = function(){
        $('#form_payment').submit(function(e){
            e.preventDefault();
            store_credit_card( $(this) );
            return false;
        });
    };
    $(document).ready(function(){
        init();
    });
}());