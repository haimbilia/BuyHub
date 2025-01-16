$(document).ready(function () {
    bindUserSelect2("buyerJs", { user_is_buyer: 1, joinBuyerRfq: 1 });
    bindUserSelect2("sellerJs", { user_is_supplier: 1, joinSellerRfq: 1 });

    $(document).on('click', '.showMoreJs', function () {
        $('.lessContentJs').hide();
        $('.moreContentJs').show();
    });
    $(document).on('click', '.showLessJs', function () {
        $('.moreContentJs').hide();
        $('.lessContentJs').show();
    });
});
(function () {
    bindUserSelect2 = function (element, obj) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), obj);
    }

    bindSellerUserSelect2 = function (element, obj = []) {
        let productId = $('input[name="rfq_product_id"]').val();
        obj['product_id'] = productId;
        let rfqId = $('input[name="rfq_id"]').val();
        obj['rfq_id'] = rfqId;
        select2(element, fcom.makeUrl(controllerName, 'getSellersByProductId'), obj);
    }

    view = function (rfqId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'view', [rfqId]), [], function (ans) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $.ykmodal(ans.html, false, 'modal-lg');
        });
    };
    
    assignSellerForm = function (rfqId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'assignSellerForm', [rfqId]), [], function (ans) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $.ykmodal(ans.html);
            bindSellerUserSelect2("aSellerJs", { 'exclude_assigned_seller': 1 });
        });
    }
    assignSeller = function (frm) {
        if (false === checkControllerName()) {
            return false;
        }
        if (!$(frm).validate()) { return; }
        $.ykmodal(fcom.getLoader());
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'assignSeller'), data, function (t) {
            fcom.removeLoader();
            if ('undefined' != typeof t.msg) {
                fcom.displaySuccessMessage(t.msg);
            }
            assignSellerForm(t.record_id);
        });
    }

    approval = function (e, obj, recordId, status) {
        if (false === checkControllerName()) {
            return false;
        }

        if (!confirm(langLbl.areYouSure)) {
            $(obj).val(0);
            return false;
        }

        fcom.displayProcessing();
        e.stopPropagation();

        data = "rfq_id=" + recordId + "&rfq_approved=" + status;
        fcom.ajax(fcom.makeUrl(controllerName, "setup"), data,
            function (ans) {
                if (!ans.status) {
                    fcom.displayErrorMessage(ans.msg);
                } else {
                    reloadList();
                }
                fcom.removeLoader();
                fcom.closeProcessing();
            }, { 'fOutMode': 'json' }
        );
    };
})();