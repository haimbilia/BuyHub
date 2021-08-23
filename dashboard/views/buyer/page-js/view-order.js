$(document).ready(function () {
    $(document).on('click', 'ul.linksvertical li a.redirect--js', function (event) {
        event.stopPropagation();
    });
});
(function () {
    updatePayment = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Buyer', 'updatePayment'), data, function (t) {
            setTimeout(function () { location.reload(true); }, 2000);
        });
    };

    fetchTrackingDetail = function (trackingId, opInvoiceId) {
        fcom.displayProcessing();
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('ShippingServices', 'fetchTrackingDetail', [trackingId, opInvoiceId]), '', function (res) {
                $.mbsmessage.close();
                $.facebox(res);
            });
        });
    }

    addItemsToCart = function (orderId) {
        fcom.ajax(fcom.makeUrl('Buyer', 'addItemsToCart', [orderId]), '', function (ans) {
            window.location = fcom.makeUrl('Cart', '', '', siteConstants.webrootfront);
            return true;
        });
    };

    loadOpShippingCharges = function (orderId, chargeType) {
        if (0 < $(".opShippingChargesJs").length) {
            $.facebox.show();
        } else {
            $.facebox(fcom.getLoader());
            fcom.ajax(fcom.makeUrl('Buyer', 'orderProductsCharges', [orderId, chargeType]), '', function (ans) {
                $.mbsmessage.close();
                $.facebox(ans, 'modal-lg opShippingChargesJs', 'modal-body-scroll');
            });
        }
    };
    
    loadOpTaxCharges = function (orderId, chargeType) {
        if (0 < $(".opTaxChargesJs").length) {
            $.facebox.show();
        } else {
            $.facebox(fcom.getLoader());
            fcom.ajax(fcom.makeUrl('Buyer', 'orderProductsCharges', [orderId, chargeType]), '', function (ans) {
                $.mbsmessage.close();
                $.facebox(ans, 'modal-lg opTaxChargesJs', 'modal-body-scroll');
            });
        }
    };
})();