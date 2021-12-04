viewDetails = function(id,langId){
    $.ykmodal(function() {
        fcom.ajax(fcom.makeUrl(controllerName, 'viewDetails', [id, langId]), '', function(t) {
            $.ykmodal(t);
        });
    }, true);
};     