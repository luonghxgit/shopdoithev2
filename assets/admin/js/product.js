var __TEST = false;
(function(){
    var load_ali_info = function($btn){

        $.ajax({
            type: 'get',
            dataType: 'json',
            url: 'http://103.29.69.126:3000/ali_detail?url=' + encodeURI($btn.attr('href')),
            success: function(result){
                var $modal = $('#modal_info_ali');
                $modal.find('.modal-title').html('Aliexpress Info (SKU: '+result.productId+')');
                var modal_body_html = '';
                modal_body_html += '<h3>'+result.name+'</h3>';
                modal_body_html += '<p><b>ProductUrl: </b><a href="'+result.url+'" target="_blank">Here</a></p>';
                modal_body_html += '<p><b>Price: </b>'+result.price+'</p>';
                modal_body_html += '<p><b>In stock: </b>'+result.instock+'</p>';
                modal_body_html += '<p><b>orderCount: </b>'+result.orderCount+'</p>';
                $modal.find('.modal-body').html(modal_body_html);
                $modal.modal();
                console.log(result);
            },
            error: function(err){
                console.log(err);
            }
        });
    };
    var $images_gallery = $('#gallery_group').find('img');
    if($images_gallery.length>0){
        $images_gallery.click(function(){
            var html = '<img src="'+$(this).attr('src')+'">';
            CKEDITOR.instances['description'].insertHtml(html);
        });
    }
    var load_template = function($select){
        var $message = $('#message');
        var template_id = $select.val();
        $.ajax({
            url: base_url + 'product/get_template',
            type: 'post',
            dataType: 'json',
            data: {'template_id': template_id, 'product_id': $('input[name="id"]').val()},
            success: function(result){
                if(result.status){
                    CKEDITOR.instances['description'].setData(result.data.content);
                    $message.hide();
                }else{
                    $message.removeClass('alert-info').addClass('alert-danger').show();
                    $message.find('#message-content').html(result.message);
                }
            },
            error: function(err){
                console.log(err);
            }
        });
    };
    $(document).ready(function(){
        $("#template").change(function(){
            load_template($(this));
        });

        $( "#sortable" ).sortable();

        $('#free_shipping').on('ifChanged', function(){
            console.log( $(this).is(':checked') );
            if($(this).is(':checked') == true){
                $('#shipping_cost').attr('disabled', 'disabled');
            }else{
                $('#shipping_cost').removeAttr('disabled');
            }
        });
    });
}());

/* save product */
(function(){
    var save_product = function($form){
        $.ajax({
            url: base_url + 'product/ajx_save',
            data: $form.serializeArray(),
            type: 'post',
            dataType: 'json',
            beforeSend: function(){
                $form.addClass('loading-v2');
            },
            success: function(result){
                $form.removeClass('loading-v2');
                show_message(result.message, result.status);
                if(result.status===true){
                    $('#tab_variants').find('.box-body').html(result.html_tab_variant);
                }
            },
            error: function(err){
                console.log(err);
                $form.removeClass('loading-v2');
            }
        });
    };
    var save_gallery = function(){

    };
    $(document).ready(function(){
        $('#form_edit_product').submit(function(e){
            e.preventDefault();
            save_product( $(this) );
            return false;
        });
    });
}());

/* product gallery */
(function(){
    var csdkImageEditor = new Aviary.Feather({
        apiKey: 'beda3f93a6d9483291268b275aa1c77b',
        apiVersion: 3,
        theme: 'light', // Check out our new 'light' and 'dark' themes!
        tools: ['crop', 'resize', 'orientation', 'blemish', 'color', 'lighting', 'draw', 'text', 'whiten', 'effects'],
        language: 'en',
        onSave: function(imageID, newURL) {
            var img = $('#' + imageID);
            img.attr('src', newURL);
            img.closest('.ui-state-default').find('input').val(newURL);
            csdkImageEditor.close();
        },
        onClose: function() {
            $('#imgToEdit').attr('id', '');
        },
        onError: function(errorObj) {
            //console.log(errorObj.message);
            $.fn.message({
                type: 'error',
                msg: errorObj.message
            });
        }
    });
    var launchEditor = function(obj) {
        //console.log(obj[0].id);
        //console.log(obj[0].src);
        csdkImageEditor.launch({
            image: obj[0].id,
            url: obj[0].src
        });
        return false;
    };
    var cloud_init = function(){
        // Initialize the AdobeCreativeSDK object
        AdobeCreativeSDK.init({
            clientID: 'cda5b0ee-40bf-46e8-ad84-bdb0f0ece846',
            API: ["Asset"],
            onError: function(error) {
                // Handle any global or config errors here
                if (error.type === AdobeCreativeSDK.ErrorTypes.AUTHENTICATION) {
                    // Note: this error will occur when you try and launch the asset browser without checking if the user has authorized your app. From here, you can trigger AdobeCreativeSDK.loginWithRedirect().
                    console.log('You must be logged in to use the Creative SDK');
                } else if (error.type === AdobeCreativeSDK.ErrorTypes.GLOBAL_CONFIGURATION) {
                    console.log('Please check your configuration');
                } else if (error.type === AdobeCreativeSDK.ErrorTypes.COMPONENT_CONFIGURATION) {
                    console.log('Please check your component configuration');
                } else if (error.type === AdobeCreativeSDK.ErrorTypes.SERVER_ERROR) {
                    console.log('Oops, something went wrong');
                }
            }
        });
    };
    /* Make a helper function */
    function uploadFile() {

        AdobeCreativeSDK.getAuthStatus(function(csdkAuth) {

            /* 1) If the user is logged in AND their browser can upload */
            if (csdkAuth.isAuthorized) {
                if (AdobeCreativeSDK.API.Files.canUpload()) {

                    /* 2) Get the first element from the FileList */
                    var file = document.getElementById("fileItem").files[0];

                    /* 3) Make a params object to pass to Creative Cloud */
                    var params = {
                        data: file,
                        folder: "My CSDK App test", // defaults to root if not set
                        overwrite: false
                    }

                    /* 4) Upload, handling error and success in your callback */
                    AdobeCreativeSDK.API.Files.upload(params, function(result) {
                        if (result.error) {
                            console.log(result.error);
                            return;
                        }

                        // Success
                        console.log(result.data); 
                    });
                }
                else {
                    console.log("Can't upload from this browser!");
                }
            } else if (!csdkAuth.isAuthorized) {
                // User is not logged in, trigger a login
                handleCsdkLogin();
            }
        });
    }
    var init_gallery_event = function(){
        $('#product_gallery .btn-edit').unbind().click(function(e){
            e.preventDefault();
            $('#imgToEdit').attr('id', '');
            var img = $(this).closest('.ui-state-default').find('img');
            img.attr('id', 'imgToEdit');
            launchEditor(img);
            return false;
        });
        $('#product_gallery .btn-delete').unbind().click(function(e){
            e.preventDefault();
            $(this).closest('.ui-state-default').remove();
            return false;
        });
    };
    $(document).ready(function(){
        //init_gallery_event();
        init_gallery_event();
        $('[data-toggle="dropdown"]').click(function(){
            var $parent = $(this).parent();
            if($parent.hasClass('open')){
                $parent.removeClass('open');
            }else{
                $parent.addClass('open');
            }
        });

        cloud_init();
        $('#fileItem').change(function(){
            uploadFile();
        });
    });
}());

/* validate */
(function(){
    this.validate_product_title = function(){
        var title = $('#name').val();
        var $group_error = $('#name').closest('.group-error');
        if(title.length>80){
            $group_error.addClass('has-error');
            $group_error.find('.input-message')
            .show()
            .html('Titles should not exceed 80 characters in length ('+title.length+'/80)');
            return false;
        }else{
            $group_error.removeClass('has-error');
            $group_error.find('.input-message').hide();
            return true;
        }
    };
    this.check_lenght_title = function(){
        var title = $('#name').val();
        var $group_error = $('#name').closest('.group-error');
        var total_character = 80 - title.length;
        total_character = total_character < 0 ? 0 : total_character;
        $group_error.find('.total-character').html( total_character );
    };
    this.check_item_location = function(){
        var $elm = $('#item-location');
        var val = $elm.val();
        var $group_error = $elm.closest('.group-error');
        if(val == ''){
            $group_error.addClass('has-error');
            $group_error.find('.input-message')
            .show()
            .html('Item location is required');
            return false;
        }else{
            $group_error.removeClass('has-error');
            $group_error.find('.input-message').hide();
            return true;
        }
    };
    var activate_tab = function(elm){
        console.log(elm);
        $('a[data-toggle="tab"]').parent().removeClass('active');
        $('a[data-tab="'+elm+'"]').parent().addClass('active');
        $('.tab-pane').removeClass('active');
        $(elm).addClass('in active');
    };
    this.check_validate_form = function(){
        if( !validate_product_title() ){
            activate_tab('#tab_product_info');
            return false;
        }
        if(! check_item_location() ){
            activate_tab('#tab_shipping');
            return false;
        }
        return true;

    };
    var remove_special_character = function(){
        $.ajax({
            url: base_url + 'dashboard/remove_special_character',
            data: {'str': $('#name').val()},
            type: 'post',
            dataType: 'text',
            success: function(result){
                $('#name').val(result);
            }
        });
    };
    $(document).ready(function(){
        //validate_product_title();
        $('#name').val( $('#name').val().substring(0, 80) );
        check_lenght_title();
        $('#name').keydown(function(){
            check_lenght_title();
        }).keyup(function(){
            check_lenght_title();
        });

        $('#remove-all-signs').click(function(e){
            e.preventDefault();
            remove_special_character();
            return false;
        });
    });
}());

/* import */
(function(){
    var ebay_suggest_category = function(){
        $.ajax({
            url: base_url + 'api/ebay-suggest-category',
            data: {
                'site_id' : $('#site_id').val(),
                'name': $('#name').val(),
                'product_id': $('#form_edit_product').find('input[name="id"]').val()
            },
            type: 'get',
            dataType: 'json',
            beforeSend: function(){
                $('#form_edit_product').addClass('loading-v2');
            },
            success: function(result){
                $('#form_edit_product').removeClass('loading-v2');
                $('#ebay_category').html(result.ebay_category_html);
                $('input[name="category_id"]').val(result.first_category_id);
                $('#ebay_category').unbind().change(function(){
                    ebay_category_specifics( $(this).val() );
                });
                $('#suggest_category_specifics').html(result.ebay_specifics_html);
                list_specifics_event();
            },
            error: function(err){
                console.log(err);
                $('#form_edit_product').removeClass('loading-v2');
            }
        });
    };
    var ebay_category_specifics = function(category_id){
        $('input[name="category_id"]').val(category_id);
        $.ajax({
            url: base_url + 'api/ebay-category-specifics',
            data: {'category_id': category_id, 'product_id': $('#form_edit_product').find('input[name="id"]').val()},
            type: 'get',
            dataType: 'json',
            beforeSend: function(){
                $('#form_edit_product').addClass('loading-v2');
            },
            success: function(result){
                $('#form_edit_product').removeClass('loading-v2');
                $('#suggest_category_specifics').html(result.ebay_specifics_html);
                list_specifics_event();
            },
            error: function(err){
                console.log(err);
                $('#form_edit_product').removeClass('loading-v2');
            }
        });
    };
    var list_specifics_event = function(){
        var $btn_remove = $('.btn-remove-specifics');
        if($btn_remove.length>0){
            $btn_remove.unbind().click(function(e){
                e.preventDefault();
                console.log(this);
                $(this).parents('.item-specifics').remove();
                return false;
            });
        }
    };
    var push_ebay = function(){
        var $form = $('#form_edit_product');
        $.ajax({
            url: base_url + 'api/ebay-listing',
            data: $form.serializeArray(),
            type: 'post',
            dataType: 'json',
            beforeSend: function(){
                //$form.addClass('loading-v2');
                $('#modal_verify_publish').modal();
                $('#modal_verify_loading').show();
                $('#modal_verify_finish').hide();
            },
            success: function(result){
                $form.removeClass('loading-v2');
                console.log(result);
                $('#modal_verify_loading').hide();
                $('#modal_verify_finish').show();
                if(result.success==true){
                    $('#verify_title').removeClass('error').html(result.message);
                    $('#verify_long_message').removeClass('error').html(result.long_message);
                }else{
                    $('#verify_title').addClass('error').html(result.message);
                    var long_message ='';
                    for(var key in result.errors){
                        long_message += result.errors[key] + '<br/>';
                    }
                    $('#verify_long_message').html(long_message);
                }
                /*if( result.hasOwnProperty('long_message') ){
                    $('#verify_long_message').html(result.long_message);
                }*/
            },
            error: function(err){
                console.log(err);
                $form.removeClass('loading-v2');
                $('#verify_title').addClass('error').html('Failure');
                $('#modal_verify_loading').hide();
                $('#modal_verify_finish').show();
            }
        });
    };
    var check_service_shipping = function(){
        var country = $('#country_code').val();
        if(country==='US'){
            $('#shipping_service_code').val('USPSPriority');
        }else{
            $('#shipping_service_code').val('EconomyShippingFromOutsideUS');
        }
    };
    $(document).ready(function(){
        if(__TEST){
            $('#form_edit_product').removeClass('loading-v2');
        }else{
            ebay_suggest_category();
        }

        $('#site_id').change(function(){
            ebay_suggest_category();
        });
        
        $('#btn_get_specifics').click(function(e){
            e.preventDefault();
            ebay_category_specifics($('#ebay_category_id').val());
            return false;
        });

        $('#btn_open_form_specific').unbind().click(function(e){
            e.preventDefault();
            $('#add_specific_modal').modal();
            return false;
        });

        $('#btn_add_specific').click(function(e){
            e.preventDefault();
            var name = $('#add_specific_name').val();
            var value = $('#add_specific_value').val();
            var $message = $('#add_specific_message');
            if(name == ''){
                return false;
            }
            if($('input[name="specifics['+name+']"]').length > 0){
                return false;
            }
            var key = string_to_slug(name);

            $('#suggest_category_specifics').append('<div class="col-sm-12 col-md-6 item-specifics">'+
                '<div class="form-group">'+
                    '<label for="'+key+'" class="col-sm-4 control-label">'+name+'</label>'+
                    '<div class="col-sm-8">'+
                        '<div class="input-group">'+
                            '<input id="'+key+'" value="'+value+'" type="text" class="form-control" name="specifics['+name+']">'+
                            '<a href="javascript:void(0)" class="input-group-addon btn-remove-specifics" title="Remove specifics">'+
                                '<i class="fa fa-times"></i>'+
                            '</a>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>');
            $message.html('');
            list_specifics_event();
            $('#add_specific_modal').modal('hide');
            $('#add_specific_name').val('');
            $('#add_specific_value').val('');
            return false;
        });

        $('.btn-push-ebay').unbind().click(function(e){
            e.preventDefault();
            var validate = check_validate_form();
            console.log(validate);
            if(validate){
                push_ebay();
            }
            return false;
        });
        $('input').on('ifChanged', function (event) {
            console.log();
            if( $(this).is(':checked') === true ){
                $('input[name="shipping_cost"]').attr('disabled', "disabled");
            }else{
                $('input[name="shipping_cost"]').removeAttr('disabled');
            }
        });

        check_service_shipping();
    });
}());