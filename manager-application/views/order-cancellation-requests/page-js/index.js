setupStatus = function(frm){
    if (!$(frm).validate()) return;
    var transferLocation = $("input[name='ocrequest_refund_in_wallet']:checked").val();
    if(0 != transferLocation && !confirm(langLbl.confirmTransfer) ){ return; }

    var data = fcom.frmData(frm);		
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setupUpdateStatus'), data, function(t) {
        searchOrderCancellationRequests(document.frmRequestSearch);
        $(document).trigger('close.facebox');
    });
};


viewComment = function(id,langId){
    $.ykmodal(function() {
        fcom.ajax(fcom.makeUrl(controllerName, 'viewComment', [id, langId]), '', function(t) {
            $.ykmodal(t);
        });
    }, true);
};     