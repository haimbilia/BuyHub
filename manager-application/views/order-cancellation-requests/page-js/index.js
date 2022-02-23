$(function () {
    bindUserSelect2("buyerJs", { user_is_buyer: 1 });
    bindUserSelect2("sellerJs", { user_is_supplier: 1, joinShop: 1 });

    $(document).on("change", '#ocrequest_status', function () {
        if ('1' === $(this).val()) {
            $('[name="ocrequest_refund_in_wallet"]').attr('disabled', false);
        } else {
            $('[name="ocrequest_refund_in_wallet"]').attr('disabled', true).val(0);
        }
    });
});

(function () {
    bindUserSelect2 = function (element, obj) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), obj);
    }

    setupStatus = function (frm) {
        if (!$(frm).validate()) return;
        var transferLocation = $("input[name='ocrequest_refund_in_wallet']:checked").val();
        if (0 != transferLocation && !confirm(langLbl.confirmTransfer)) { return; }

        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setupUpdateStatus'), data, function (t) {
            searchOrderCancellationRequests(document.frmRequestSearch);
            
        });
    };

    viewComment = function (ocrequestId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "viewComment",[ocrequestId]), '', function (t) {
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };
    
    viewAdminComment = function (ocrequestId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "viewAdminComment",[ocrequestId]), '', function (t) {
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };
})();