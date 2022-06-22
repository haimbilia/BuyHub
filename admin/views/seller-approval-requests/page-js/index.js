
(function () {
    viewSellerRequest = function (requestId) {
        fcom.updateWithAjax(fcom.makeUrl('SellerApprovalRequests', 'viewSellerRequest', [requestId]), "", function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

})(); 