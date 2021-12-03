viewComment = function(id,langId){
    $.ykmodal(function() {
        fcom.ajax(fcom.makeUrl(controllerName, 'viewComment', [id, langId]), '', function(t) {
            $.ykmodal(t);
        });
    }, true);
};     