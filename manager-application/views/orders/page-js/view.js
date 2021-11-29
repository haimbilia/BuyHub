/* $(document).ready(function () {
    $(document).on('click', 'ul.linksvertical li a.redirectJs', function (event) {
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
    
    getShippingUsersForm = function (orderId, opId) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, 'shippingUsersForm', [orderId]), 'op_id=' + opId, function (ans) {
            $.ykmodal(ans);
            fcom.removeLoader()
        });
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

        if (0 < $(".shippingUserJs").length && '' == $(".shippingUserJs").val()) {
            $.ykmsg.error(langLbl.shippingUser);
            return;
        }

        var manualShipping = 0;
        if (0 < $("input.manualShipping-js").length) {
            manualShipping = $("input.manualShipping-js:checked").val();
        }

        if (0 < canShipByPlugin && 1 != manualShipping && orderShippedStatus == orderStatusId) {
            proceedToShipment(op_id);
        } else {
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'changeOrderStatus'), data, function (t) {
                setTimeout("pageRedirect(" + op_id + ")", 1000);
            });
        }
    };

    updateShippingUser = function (frm) {
        var data = fcom.frmData(frm);
        // var op_id = $(frm.op_id).val();
        if (!$(frm).validate()) return;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updateShippingUser'), data, function (t) {});
    };

    /* ShipStation */
    generateLabel = function (opId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippingServices', 'generateLabel', [opId]), '', function (t) {            
            setTimeout(function(){ window.location.href = fcom.makeUrl('sellerOrders', 'view',[opId]) }, 300);
        });
    }
    /* ShipStation */

    proceedToShipment = function (opId) {
        fcom.displayProcessing();
        if ('' == $(".shippingUser-js").val()) {
            $.ykmsg.error(langLbl.shippingUser);
            return;
        }
        fcom.ajax(fcom.makeUrl('ShippingServices', 'proceedToShipment', [opId]), '', function (t) {
            $.ykmsg.close();
            t = $.parseJSON(t);
            if (1 > t.status) {
                $.ykmsg.error(t.msg);
                return;
            }
            $.ykmsg.success(t.msg);

            var form = "form.markAsShippedJs";
            if (0 < $(form).length) {
                $(form + " .status-js").val(orderShippedStatus).change();
                $(form + " .notifyCustomer-js").val(1);
                $(form + " input[name='tracking_number']").val(t.tracking_number);
                canShipByPlugin = 0;
                if ('' != t.tracking_number) {
                    $(form + ' .manualShipping-js').attr('data-fatreq', '{"required":false}');
                }
                updateStatus($(form)[0]);
            } else {
                window.location.reload();
            }
        });
    }

    courierFld = function () {
        $('.courierBlkJs').removeClass('d-none');
        $('.courierFldJs').attr('data-fatreq', '{"required": true}');
        $('.trackingUrlBlkJs').addClass('d-none');
        $('.trackingUrlFldJs').attr('data-fatreq', '{"required": false}');
    }

    trackingUrlFld = function () {
        $('.trackingUrlBlkJs').removeClass('d-none');
        $('.trackingUrlFldJs').attr('data-fatreq', '{"required": true}');
        $('.courierBlkJs').addClass('d-none');
        $('.courierFldJs').attr('data-fatreq', '{"required": false}');
    }

    fetchTrackingDetail = function (trackingId, opInvoiceId) {
        fcom.ajax(fcom.makeUrl('ShippingServices', 'fetchTrackingDetail', [trackingId, opInvoiceId]), '', function (res) {
            $.ykmodal(res, true);
        });
    }

    trackOrder = function(trackingNumber, courier, orderNumber) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('SellerOrders', 'orderTrackingInfo', [trackingNumber, courier, orderNumber]), '', function(res) {
            $.ykmsg.close();
            $.ykmodal(res, true);
        });
    };
})();