
(function () {
    viewSellerRequest = function (requestId) {

        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerApprovalRequests', 'viewSellerRequest', [requestId]), "", function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

})(); 