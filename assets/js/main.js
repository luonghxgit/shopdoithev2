(function($, win, doc){
    var init = function(){
        $('.read-more').click(function(e){
            e.preventDefault();
            var $elm = $($(this).attr('href'));
            if($elm.length>0){
                $elm.fadeIn(100);
            }
            $(this).fadeOut(100);
            return false;
        });
    };
    $(doc).ready(function(){
        init();
    });
}(jQuery, window, document));