(function(_win, _doc){
    var obj = new function(){
        var me = this,
            _mime = '',
            _multiple = false;
        me.Config = {'base_path': 'finder/'};
        var progressDesktop = function (percent) {
            var $loading = $('#loading-progress');
            if ($loading.length == 0) {
                $('body').prepend('<div id="loading-progress" class="loading-progress"><div class="center-fixed progress"></div></div>');
            }
            var $progress = $loading.find('.progress');
            $progress.html(percent + '%');
            $progress.css({'background': 'linear-gradient(to right, #0077e8 0%,#0077e8 ' + percent + '%,#d9d9d9 ' + percent + '%,#d9d9d9 100%)'});
        };
        function filename(path){
            path = path.substring(path.lastIndexOf("/")+ 1);
            return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
        }
        var getHtmlFromUrl = function(file){
            var extension = file.substr( (file.lastIndexOf('.') +1)),
                html = '';
            if(extension==='jpg' || extension==='png' || extension==='gif' || extension==='jpge'){
                html = '<img src="'+file+'">';
            }else if(extension==='mp3' || extension==='wma'){
                html = '<br/><audio controls>' +
                    '<source src="'+ file + '" type="audio/mpeg">' +
                    '</audio>';
            }else if(extension==='mp4' || extension==='ogg'){
                html = '<br/><video width="320" height="240" controls>' +
                    '<source src="' + file +'" type="video/ogg">' +
                    '</video>';
            }else{
                html = '<a href="'+file+'">'+ filename(file) +'</a>'
            }
            return html;
        };
        var uploadMedia = function (callback, folder) {
            if (folder == undefined)folder = '';
            var $formUpload = $('#form_upload'),
                $message = $formUpload.find('.message'),
                $hash = $formUpload.find('.hash'),
                formData = new FormData(),
                browser = _doc.getElementById('btn-browse-media');
            if (browser.files.length == 0) return false;
            formData.append($hash.attr('name'), $hash.val());
            formData.append('folder', folder);
            $.each(browser.files, function(index, fileItem){
                formData.append('files[]', fileItem);
            });
            $.ajax({
                xhr: function () {
                    var xhrObj = $.ajaxSettings.xhr();
                    if (xhrObj.upload) {
                        xhrObj.upload.addEventListener('progress', function (event) {
                            var percent = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable) {
                                percent = Math.ceil(position / total * 100);
                            }
                            progressDesktop(percent);
                        }, false);
                    }
                    return xhrObj;
                },
                url: base_url +me.Config.base_path + 'upload_media',
                dataType: 'json',
                data: formData,
                method: 'post',
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $('body').addClass('no-scroll');
                    $message.html('').hide();
                },
                success: function (result) {
                    $('#loading-progress').remove();
                    $('body').removeClass('no-scroll');
                    if(!result.success){
                        $message.html(result.msg).show();
                    }
                    $hash.val(result.hash);
                    callback(result);

                },
                error: function (err) {
                    console.log(err);
                    $('#loading-progress').remove();
                    $('body').removeClass('no-scroll');
                }
            });
        };


        this.openFrameSuccess = function (option) {
            var output = typeof option.output !== typeof undefined ? option.output : '';
            var $parent_elm = typeof option.parent !== typeof undefined ? option.parent : '';
            var $block = $('#block-finder'),
                $btnClose = $block.find('.btn-close,.btn-cancel'),
                $btnOK = $('.btn-ok'),
                $btnBrowseMedia = $('#btn-browse-media'),
                $formAddFolder = $('#form-add-folder'),
                $formSearch = $('#form-search-file');
            $block.css({'display': 'block'}).animate({'opacity': 1}, {duration: 200});
            $btnClose.click(function () {
                me.closeFrame();
            });
            me.rendingDirEvent();
            if($btnOK.length>0) $btnOK.click(function (e) {
                e.preventDefault();
                var $block_files = $('#block-files'),
                    lis = $block_files.find('li.active'),
                    actives = $block_files.find('li.active a'),
                    actives_length = actives.length;
                if (actives_length > 0) {
                    $.each(actives, function(){
                        var active = $(this),
                            urlFile = active.attr("href"),
                            urlFileMin = urlFile.replace(base_url, '');
                        if (typeof(output) === 'string') {
                            var $input;
                            if($parent_elm){
                                $input = $parent_elm.find('input[name="' + output + '"]')
                            }else{
                                $input = $('form input[name="' + output + '"]');
                            }
                            var $img = $input.parent().find('img');
                            $input.val(urlFileMin);
                            if ($img.length > 0) {
                                $img.attr('src', urlFile).show();
                            }
                        } else if(typeof output === 'function'){
                            output(urlFileMin);
                        } else if (typeof(output) === 'object') {
                            output.insertContent(getHtmlFromUrl('/' + urlFileMin));
                        } else {

                        }
                    });
                    lis.removeClass('active');
                }
                me.closeFrame();
                return false;
            });
            if($btnBrowseMedia.length>0){
                $btnBrowseMedia.change(function () {
                    uploadMedia(function (result) {
                        $btnBrowseMedia.val('');
                        if (result.success && result.duplicate == undefined) {
                            var $list_file = $('#block-files');
                            $list_file.append(result.html);
                            me.eventListFiles();
                            $list_file.animate({ scrollTop: $list_file.prop("scrollHeight")}, 1000);
                            $(result.html).trigger('click');
                        }
                    }, me.findCurrentFolder());
                });
            }
            if($formAddFolder.length>0){
                $formAddFolder.submit(function(e){
                    e.preventDefault();
                    me.createFolder(base_url + me.Config.base_path + 'add_folder', {
                        'dir': me.findCurrentFolder(),
                        'name': $formAddFolder.find('input').val()
                    });
                    return false;
                });
            }
            if($formSearch.length>0) $formSearch.submit(function (e) {
                e.preventDefault();
                me.loadFiles(base_url + me.Config.base_path + 'render_file', {
                    'dir': me.findCurrentFolder(),
                    's': $formSearch.find('input').val(),
                    'mime': _mime
                });
                return false;
            });
            me.eventPaging();
        };
        this.closeFrame = function () {
            var block = $('#block-finder');
            if (block.length == 0) return false;
            block.animate({'opacity': 0}, {
                duration: 200, complete: function () {
                    block.remove();
                }
            });
        };
        this.rendingDirEvent = function(){
            var blockDir = $('#block-dirs'),
                btnExpand = blockDir.find('li.has-child i'),
                btnDir = blockDir.find('li a');
            btnExpand.click(function () {
                var me = $(this),
                    subDir = me.parent().find('.sub-dir');
                if (me.hasClass('fa-plus')) {
                    me.removeClass('fa-plus').addClass('fa-minus');
                    if (subDir.length > 0) {
                        $(subDir[0]).css({'display': 'block'});
                    }
                } else {
                    me.removeClass('fa-minus').addClass('fa-plus');
                    if (subDir.length > 0) {
                        $(subDir[0]).css({'display': 'none'});
                    }
                }
            });
            if(btnDir.length>0) btnDir.click(function (e) {
                e.preventDefault();
                $('#block-dirs').find('a.active').removeClass('active');
                $(this).addClass('active');
                me.loadFiles($(this).attr('href'));
                return false;
            });
        };
        this.eventPaging = function () {
            var blockPaging = $('#paging-file'),
                btnPrew = blockPaging.find('.btn-prew'),
                btnNext = blockPaging.find('.btn-next'),
                inputPage = blockPaging.find('input');
            if(btnPrew.length>0) {
                btnPrew.unbind().click(function (e) {
                    var btn = $(this),
                        paged = parseInt(inputPage.val()) - 1;
                    return me.loadFileWithPaged(e, paged, btn);
                });
            }
            if(btnNext.length>0) {
                btnNext.unbind().click(function (e) {
                    var btn = $(this),
                        paged = parseInt(inputPage.val()) + 1;
                    return me.loadFileWithPaged(e, paged, btn);
                });
            }
            if(inputPage.length>0){
                inputPage.change(function(e){
                    var paged = parseInt(inputPage.val());
                    return me.loadFileWithPaged(e, paged, null);
                });
            }
        };
        this.loadFileWithPaged = function(e,paged, btn){
            if(btn && btn.hasClass('disabled')){
                return false;
            }
            var formSearch = $('#form-search-file');
            me.loadFiles(base_url + me.Config.base_path + 'render_file', {
                'dir': me.findCurrentFolder(),
                's': formSearch.find('input').val(),
                'paged': paged
            });
        };
        this.createFolder = function(url, data){
            data = data == undefined ? {} : data;
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                    showLoading( $('#block-finder') );
                },
                success: function (result) {
                    if(result.success) {
                        $('#block-dirs').html(result.html);
                        me.rendingDirEvent();
                    }else{
                        $('#paging-file').html('');
                        $('#block-files').html(result.msg);
                    }
                    hideLoading( $('#block-finder') );
                }, error: function (error) {
                    console.log(error);
                    hideLoading( $('#block-finder') );
                }
            });
        };
        this.loadFiles = function (url, data) {
            data = data == undefined ? {} : data;
            $.ajax({
                url: url,
                data: data,
                type: 'get',
                dataType: 'json',
                beforeSend: function () {
                    showLoading( $('#block-finder') );
                    $('.file-info').html('');
                },
                success: function (result) {
                    if(result.success) {
                        $('#paging-file').html(result.paging);
                        $('#block-files').html(result.html);
                        me.eventListFiles();
                        me.eventPaging();
                    }else{
                        $('#paging-file').html('');
                        $('#block-files').html(result.msg);
                    }
                    hideLoading( $('#block-finder') );
                }, error: function (error) {
                    console.log(error);
                    hideLoading( $('#block-finder') );
                }
            });
        };
        this.findCurrentFolder = function () {
            var currentDir = $('#block-dirs').find('a.active');
            return currentDir.length == 0 ? 0 : currentDir.attr('data-dir');
        };
        this.removeFile = function($imgActive){
            var btn = $('#remove-file-selected'),
                $hash = $('.hash');
            if (btn.length == 0) return false;
            if($imgActive.length==0) return false;
            var dataInput = {};
            dataInput['files[]'] = [];
            $.each($imgActive, function(){
                var link = $(this).attr('href');
                dataInput['files[]'].push(link);
            });
            dataInput[$hash.attr('name')] = $hash.val();
            $(btn).unbind().click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: base_url + me.Config.base_path + 'remove_file',
                    data: dataInput,
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function () {
                        showLoading( $('#block-finder') );
                    },
                    success: function (result) {
                        if (result.success) {
                            $.each($imgActive, function(){
                                $(this).parent().remove();
                            });
                            $('.file-info').html('');
                        }
                        $hash.val(result.hash);
                        hideLoading( $('#block-finder') );
                    }, error: function (error) {
                        console.log(error);
                        hideLoading( $('#block-finder') );
                    }
                });
                return false;
            });
        };
        this.eventListFiles = function () {
            var $block_files = $('#block-files'),
                $lis = $block_files.find('li'),
                $btnMedia = $block_files.find('a');
            $btnMedia.unbind().click(function (e) {
                e.preventDefault();
                var $thisBtn = $(this),
                    $li = $thisBtn.parent();
                if(_multiple===true){
                    if($li.hasClass('active')===false) {
                        $li.addClass('active');
                    }else{
                        $li.removeClass('active');
                    }
                }else{
                    $lis.removeClass('active');
                    $li.addClass('active');
                }

                var $imgActive = $('#block-files').find('li.active a');

                var $file_info = $('.file-info');
                if($imgActive.length>0){
                    var str = '';
                    $.each($imgActive, function(){
                        if(str===''){
                            str += $thisBtn.attr('data-name');
                        }else{
                            str += ', ' + $thisBtn.attr('data-name');
                        }
                    });
                    $file_info.html('<p>' + str + '</p>&nbsp;' +
                        '<a id="remove-file-selected" href="javascript:void(0)">Xóa</a>');
                }
                me.removeFile($imgActive);
                return false;
            });
        };
        this.openFrameUpload = function (options) {
            var default_option = {
                output : null,
                mime : '',
                multiple : false
            };
            $.extend( default_option, options );
            _mime = default_option.mime;
            _multiple = default_option.multiple;
            var blockFinder = $('#block-finder');
            if (blockFinder.length == 1) {
                blockFinder.css({'display': 'block'}).animate({'opacity': 1}, {duration: 200});
                return false;
            }
            $.ajax({
                url: base_url + me.Config.base_path + 'ajx_load_finder',
                data: {mime:_mime, multiple:default_option.multiple},
                type: 'get',
                dataType: 'json',
                beforeSend: function () {
                    showLoading( $('body') );
                },
                success: function (result) {
                    var $body = $('body');
                    if (result.success) {
                        $body.append(result.html);
                        me.openFrameSuccess(default_option);
                        me.eventListFiles();
                    }
                    hideLoading( $body );
                }, error: function (error) {
                    console.log(error);
                    hideLoading( $('body') );
                }
            });
        };
        var showLoading = function($elem){
            if(typeof $elem === typeof undefined){
                $elem = $('body');
            }
            $elem.addClass('loading');
        };
        var hideLoading = function($elem){
            if(typeof $elem === typeof undefined){
                $elem = $('body');
            }
            $elem.removeClass('loading');
        };
        this.getConfigMedia = function(){
            return {
                selector: '.editor',
                "toolbar": [
                    "custom-media,forecolor,backcolor,fontselect,fontsizeselect,bold,italic,blockquote,bullist,numlist,alignleft,aligncenter,alignright,alignjustify,link,unlink,table,undo,redo,code"
                ],
                setup: function (editor) {
                    editor.addButton('custom-media', {
                        text: '',
                        title: 'Thêm ảnh, video, audio',
                        icon: 'media',
                        onclick: function () {
                            me.openFrameUpload({
                                output : editor,
                                mime : '',
                                multiple : true
                            });
                        }
                    });
                    var textarea = _doc.getElementById(editor.id);
                    $(textarea).parent().parent().find('.btn-reset').bind('click', function () {
                        editor.setContent('');
                    });
                },
                relative_urls: false,
                "options": "fontsize_formats",
                menubar: false,
                "plugins": "textcolor,anchor,code,insertdatetime,nonbreaking,searchreplace,table,visualblocks,visualchars,image"
            };
        };
    };
    _win.VccFinder = obj;
}(window, document));