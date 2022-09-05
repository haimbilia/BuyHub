$(document).ready(function () {
    $(document).on('click', 'ul.linksvertical li a.redirect--js', function (event) {
        event.stopPropagation();
    });
});
(function () {
    updatePayment = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Buyer', 'updatePayment'), data, function (t) {
            setTimeout(function () { location.reload(true); }, 2000);
        });
    };

    fetchTrackingDetail = function (trackingId, opInvoiceId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('ShippingServices', 'fetchTrackingDetail', [trackingId, opInvoiceId]), '', function (res) {
            $.ykmsg.close();
            $.ykmodal(res);
        });
    }

    addItemsToCart = function (orderId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('Buyer', 'addItemsToCart', [orderId]), '', function (ans) {
            window.location = fcom.makeUrl('Cart', '', '', siteConstants.webrootfront);
            return true;
        });
    };

    loadOpShippingCharges = function (orderId, chargeType, opId = 0) {
        if (0 < $(".opShippingChargesJs").length) {
            $.ykmodal.show();
        } else {
            $.ykmodal(fcom.getLoader());
            fcom.ajax(fcom.makeUrl('Order', 'orderProductsCharges', [orderId, chargeType, opId]), '', function (ans) {
                fcom.removeLoader();
                $.ykmsg.close();
                $.ykmodal(ans, false, 'modal-dialog-vertical-md opShippingChargesJs');
            });
        }
    };

    loadOpTaxCharges = function (orderId, chargeType, opId = 0) {
        if (0 < $(".opTaxChargesJs").length) {
            $.ykmodal.show();
        } else {
            $.ykmodal(fcom.getLoader());
            fcom.ajax(fcom.makeUrl('Order', 'orderProductsCharges', [orderId, chargeType, opId]), '', function (ans) {
                fcom.removeLoader();
                $.ykmsg.close();
                $.ykmodal(ans, false, 'modal-dialog-vertical-md opTaxChargesJs');
            });
        }
    };

    copyContent = function (obj) {
        var text = $(obj).siblings('.trackingNumberJs').val().trim();
        var elem = document.createElement("textarea");
        document.body.appendChild(elem);
        elem.value = text;
        elem.select();
        document.execCommand("copy");
        document.body.removeChild(elem);
        var elOriginalText = $(obj).attr('data-original-title');
        $(obj).attr('data-original-title', langLbl.copied).tooltip('show').attr('data-original-title', elOriginalText);
    }
})();