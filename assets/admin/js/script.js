(function(){
    this.string_to_slug = function(str) {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
        var to   = "aaaaaeeeeeiiiiooooouuuunc------";
        for (var i=0, l=from.length ; i<l ; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

        return str;
    };
    this.slugEvent = function($title, $slug){
        $title.change(function(){
            slug( $title.val(), $slug )
        });
        $title.click(function(){
            if($slug.val().trim()===''){
                slug( $title.val(), $slug )
            }
        });
        $title.blur(function(){
            if($slug.val().trim()===''){
                slug( $title.val(), $slug );
            }
        });
    };
    this.slug = function(str, $slug){
        if(str.length===0) return false;
        $.ajax({
            url: base_url + 'admin/slug',
            data: {'title':str},
            type: 'post',
            dataType : "html",
            beforeSend: function(){
                $slug.attr('readonly', 'true');
            },
            success: function(result){
                console.log(result);
                $slug.val(result);
                $slug.removeAttr('readonly');
            },
            error: function(err){
                console.log(err);
                $slug.removeAttr('readonly');
            }
        });
        return true;
    };
    var initList = function(){
        var $check_all = $('#check_all');
        if($check_all.length>0){
            $check_all.on('ifChanged', function (e) {
                if($(this).is(":checked")==true){
                    $('.input-id:not(:checked)').iCheck('toggle');
                }else{
                    $('.input-id:checked').iCheck('toggle');
                }
            });
        }
        /*var $delete = $('.delete');
        if($delete.length>0){
            $delete.click(function(e){
                e.preventDefault();
                console.log(e);
                var r = confirm("Bạn có chắc chắn muốn xóa dữ liệu này.");
                if(r==true){
                    window.location.href = $(this).attr('href');
                }
                return false;
            });
        }*/
    };
    var editorInit = function(){
        var $date_picker = $('.date-picker');
        if($date_picker.length>0){
            $date_picker.datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        }
        var $editor = $('.editor');
        if($editor.length>0){
            var settings = VccFinder.getConfigMedia();
            settings.toolbar = ["custom-media,forecolor,backcolor,fontselect,fontsizeselect | bold,italic,blockquote,bullist,numlist,alignleft,aligncenter,alignright,alignjustify,link,unlink,table,code"];
            tinymce.init(settings);
        }

        var $ckeditor = $('.ckeditor');
        if($ckeditor.length>0){
            CKEDITOR.replace( $ckeditor.attr('id'), {
                height: 500,
                language: 'en',
                allowedContent: true
            });
        }
        return true;
    };
    var review_thumbnail = function(){
        var $thumbnail = $('.thumbnail');
        if($thumbnail.length>0){
            $thumbnail.change(function(){
                var files = this.files;
                var $wrap_thumbnail = $(this).parent(),
                    $wrap_review = $wrap_thumbnail.find('.thumbnail-review'),
                    $review_thumbnail = $wrap_thumbnail.find('img');
                if(files && files[0]){
                    console.log(files[0]);
                    var url = URL.createObjectURL(event.target.files[0]);
                    $review_thumbnail.attr('src', url).show();
                    $wrap_review.show();
                }
            });
        }

        var $review = $('input.review');
        if($review.length>0){
            $review.unbind().on('change', function(){
                var $elm = $($review.attr('data-element'));
                if($elm.length>0){
                    $elm.attr('src', $review.val()).show();
                }
            });
        }
    };
    var initForm = function(){
        var $btnUploadThumbnail = $('.upload');
        if($btnUploadThumbnail.length>0){
            $btnUploadThumbnail.click(function (e) {
                e.preventDefault();
                var output = $(this).attr('data-output');
                var mime = $(this).attr('data-mime');
                console.log(output);
                VccFinder.openFrameUpload({
                    output : output ? output : 'thumbnail',
                    mime : mime ? mime : '',
                    multiple : false
                });
                return false;
            });
        }
        var $inputs = $('input[type="checkbox"].minimal, input[type="radio"].minimal');
        if($inputs.length>0){
            $inputs.iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue',
                cursor: true
            });
        }
        var $radio = $('input[type="checkbox"].flat-red, input[type="radio"].flat-red');
        if($radio.length>0){
            $radio.iCheck({
              checkboxClass: 'icheckbox_flat-green',
              radioClass: 'iradio_flat-green'
            });
        }
        var $select = $('select.select2');
        if($select.length>0){
            $select.each(function(){
                var $select_item = $(this);
                $select_item.select2({
                    placeholder: $select_item.attr('placeholder')
                });
            });
        }
        //Timepicker
        var $timePicker = $(".timepicker");
        if($timePicker.length>0){
            $timePicker.timepicker({
                showInputs: false,
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            });
        }
        var $timePicker_2 = $(".timepicker-2");
        if($timePicker_2.length>0){
            $timePicker_2.timepicker({
                showInputs: false,
                minuteStep: 1,
                secondStep: 1,
                disableMousewheel: true,
                showSeconds: true,
                showMeridian: false,
                defaultTime: '00:00:00'
            });
        }
        review_thumbnail();
        editorInit();
    };
    var formEvent = function(){
        var $name = $('#name,#title'),
            $slug = $('#slug');
        if($name.length>0 && $slug.length>0){
            slugEvent($name, $slug);
        }
    };
    $(document).ready(function(){
        initList();
        initForm();
        formEvent();
    });
}());

/* setting account */
(function(){
    this.save_paypal_email = function(dataInput){
        console.log( dataInput );
        $.ajax({
            url: base_url + 'auth/save-ebay-connection',
            type: 'post',
            data: dataInput,
            dataType: 'json',
            beforeSend: function(){
                $('#paypal_email').attr('disabled', 'disabled');
                $('#save_paypal_email').attr('disabled', 'disabled');
            },
            success: function(result){
                $('#paypal_email').removeAttr('disabled', 'disabled');
                $('#save_paypal_email').removeAttr('disabled', 'disabled');
                $('#save_paypal_connection_message').html(result.message);
                if(result.status==false){
                    $('#save_paypal_connection_message').addClass('error');
                }else{
                    $('#save_paypal_connection_message').removeClass('error');
                    if(result.redirect){
                        window.location.reload(result.redirect);
                    }
                }
            },
            error: function(err){
                console.log(err);
                $('#paypal_email').removeAttr('disabled', 'disabled');
                $('#save_paypal_email').removeAttr('disabled', 'disabled');
            }
        });
    };
    $(document).ready(function(){
        $('#steps_settings_paypal').submit(function(e){
            e.preventDefault();
            var $form = $(this);
            save_paypal_email( $form.serializeArray() );
            return false;
        });
    });
}());