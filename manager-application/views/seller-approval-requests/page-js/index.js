
(function () {
    viewSellerRequest = function (requestId) {
        fcom.updateWithAjax(fcom.makeUrl('SellerApprovalRequests', 'viewSellerRequest', [requestId]), "", function (t) {
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

})(); 