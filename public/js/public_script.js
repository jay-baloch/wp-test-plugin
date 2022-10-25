(function($) {

"use strict";

    /**
    * [AJAX Call Method]
    */
    var tab_loading = {show: function(){jQuery('.asl-cont-wc > .loading').removeClass('hide');},hide: function(){jQuery('.asl-cont-wc > .loading').addClass('hide');}};
    var ServerCall = function (_url, _data, _callback, _option) {_data   = _data == null ? {}: _data;_option = _option == null ? {}: _option; var i   = _option.dataType ? _option.dataType : "json";if(_option.submit) {_option.submit.button('loading');}tab_loading.show();var s = {type : _option.type ? _option.type : "POST",url : _url,data : _data,dataType : i,success : function (_d) {tab_loading.hide();_callback(_d);}};var o = jQuery.ajax(s);};

    /**
    * [page_ajax_call description]
    * @param  {[type]} [description]
    * @return {[type]} [description]
    */
    function page_ajax_call() {

        // Set Session From Ajax
        ServerCall(JZ_CONFIG.URL + "?action=jz_ajax_post_call", { hit: 'cart_store' }, function(_response) {

            if (_response.success) {
                $("body").append(_response.html);
            }

        }, 'json');


    };
    
    if (JZ_CONFIG.type == 'page' ) {

        page_ajax_call();
    }
})(jQuery);



