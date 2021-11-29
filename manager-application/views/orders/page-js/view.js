/* $(document).ready(function () {
    $(document).on('click', 'ul.linksvertical li a.redirect--js', function (event) {
        event.stopPropagation();
    });
}); */

(function () {
    var itemSummaryJs = ".itemSummaryJs";
    var orderSummaryJs = ".orderSummaryJs";
    getOrderParticulars = function (orderId, obj) {
        var data = "op_selprod_user_id=" + obj.value;
        $(itemSummaryJs + ", " + orderSummaryJs).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, 'getOrderParticulars', [orderId]), data, function (t) {
            var res = JSON.parse(t);
            fcom.removeLoader();
            $(itemSummaryJs).replaceWith(res.itemSummaryHtml);
            $(orderSummaryJs).replaceWith(res.orderSummaryHtml);
        });
    };
    updatePayment = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updatePayment'), data, function (t) {
            window.location.reload();
        });
    };
    approve = function (orderPaymentId) {
        if (!confirm(langLbl.confirmUpdate)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'approvePayment', [orderPaymentId]), '', function (t) {
            window.location.reload();
        });
    };
    reject = function (orderPaymentId) {
        if (!confirm(langLbl.confirmUpdate)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'rejectPayment', [orderPaymentId]), '', function (t) {
            window.location.reload();
        });
    };
    viewPaymemntGatewayResponse = function (data) {
        $.ykmodal(data, true);
    };

    getOpCharges = function (orderId, chargeType) {
        $.ykmodal(fcom.getLoader(), true, 'modal-lg');
        fcom.ajax(fcom.makeUrl(controllerName, 'orderProductsCharges', [orderId, chargeType]), '', function (ans) {
            $.ykmodal(ans);
            fcom.removeLoader()
        });
    }

    loadOpShippingCharges = function (orderId, chargeType) {
        if (0 < $(".opShippingChargesJs").length) {
            $.ykmodal.show();
        } else {
            getOpCharges(orderId, chargeType);
        }
    };

    loadOpTaxCharges = function (orderId, chargeType) {
        if (0 < $(".opTaxChargesJs").length) {
            $.ykmodal.show();
        } else {
            getOpCharges(orderId, chargeType);
        }
    };

    loadOpVolDiscount = function (orderId, chargeType) {
        if (0 < $(".opVolDiscountJs").length) {
            $.ykmodal.show();
        } else {
            getOpCharges(orderId, chargeType);
        }
    };

    loadOpRewards = function (orderId, chargeType) {
        if (0 < $(".opRewardsJs").length) {
            $.ykmodal.show();
        } else {
            getOpCharges(orderId, chargeType);
        }
    };
    
    getItem = function (orderId, opId) {
        if (0 < $(".opDetailsJs" + opId).length) {
            $.ykmodal.show();
        } else {
            $.ykmodal(fcom.getLoader());
            fcom.ajax(fcom.makeUrl(controllerName, 'getItem', [orderId]), 'op_id=' + opId, function (ans) {
                $.ykmodal(ans);
                fcom.removeLoader()
            });
        }
    };
   
    getItemStatusHistory = function (orderId, opId) {
        if (0 < $(".opStausLogJs" + opId).length) {
            $.ykmodal.show();
        } else {
            $.ykmodal(fcom.getLoader());
            fcom.ajax(fcom.makeUrl(controllerName, 'getItemStatusHistory', [orderId]), 'recordId=' + opId, function (ans) {
                $.ykmodal(ans);
                fcom.removeLoader()
            });
        }
    };
    
    getOrderCommentForm = function (orderId, opId) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, 'orderCommentsForm', [orderId]), 'op_id=' + opId, function (ans) {
            $.ykmodal(ans);
            fcom.removeLoader()
        });
    };
    
    updateStatus = function (frm) {
        if (!$(frm).validate()) return;
        var op_id = $(frm.op_id).val();
        var data = fcom.frmData(frm);
        var orderStatusId = $(frm.op_status_id).val();

        if (0 < $(".shippingUser-js").length && '' == $(".shippingUser-js").val()) {
            $.systemMessage(langLbl.shippingUser, 'alert--danger', false);
            return;
        }

        var manualShipping = 0;
        if (0 < $("input.manualShipping-js").length) {
            manualShipping = $("input.manualShipping-js:checked").val();
        }

        if (0 < canShipByPlugin && 1 != manualShipping && orderShippedStatus == orderStatusId) {
            proceedToShipment(op_id);
        } else {
            fcom.updateWithAjax(fcom.makeUrl('SellerOrders', 'changeOrderStatus'), data, function (t) {
                setTimeout("pageRedirect(" + op_id + ")", 1000);
            });
        }
    };
})();