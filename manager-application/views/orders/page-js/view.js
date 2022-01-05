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
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'orderProductsCharges', [orderId, chargeType]), '', function (ans) {
            fcom.removeLoader();
            $.ykmsg.close();
            $.ykmodal(ans.html);
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
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'getItem', [orderId]), 'op_id=' + opId, function (ans) {
                fcom.removeLoader();
                $.ykmsg.close();
                $.ykmodal(ans.html);
            });
        }
    };

    getItemStatusHistory = function (orderId, opId) {
        if (0 < $(".opStausLogJs" + opId).length) {
            $.ykmodal.show();
        } else {
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'getItemStatusHistory', [orderId]), 'recordId=' + opId, function (ans) {
                fcom.removeLoader();
                $.ykmsg.close();
                $.ykmodal(ans.html);
            });
        }
    };

    getShippingUsersForm = function (orderId, opId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'shippingUsersForm', [orderId]), 'op_id=' + opId, function (ans) {
            fcom.removeLoader();
            $.ykmsg.close();
            $.ykmodal(ans.html);
        });
    };

    getOrderCommentForm = function (orderId, opId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'orderCommentsForm', [orderId]), 'op_id=' + opId, function (ans) {
            fcom.removeLoader();
            $.ykmsg.close();
            $.ykmodal(ans.html);
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
        if (0 < $("input.manualShippingJs").length) {
            manualShipping = $("input.manualShippingJs:checked").val();
        }

        if (0 < canShipByPlugin && 1 != manualShipping && orderShippedStatus == orderStatusId) {
            proceedToShipment(op_id);
        } else {
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'changeOrderStatus'), data, function (t) { });
        }
    };   

    updateShippingUser = function (frm) {
        var data = fcom.frmData(frm);
        if (!$(frm).validate()) return;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updateShippingUser'), data, function (t) { });
    };

    /* ShipStation */
    generateLabel = function (opId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippingServices', 'generateLabel', [opId]), '', function (t) {
            setTimeout(function () {
                location.reload();
            }, 300);
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

            let data = { op_id: opId, op_status_id: orderShippedStatus, customer_notified: 1, tracking_number: t.tracking_number,shipped_by_plugin:1 };
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'changeOrderStatus'), data, function (t) {
                window.location.reload();
            });
            canShipByPlugin = 0;
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

    trackOrder = function (trackingNumber, courier, orderNumber) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl(controllerName, 'orderTrackingInfo', [trackingNumber, courier, orderNumber]), '', function (res) {
            $.ykmsg.close();
            $.ykmodal(res, true);
        });
    };

    pageRedirect = function (op_id) {
        window.location.replace(fcom.makeUrl(controllerName, 'view', [op_id]));
    }

    uploadAdditionalAttachment = function () {
        var data = new FormData();
        var opId = $("input[name='op_id']").val();

        /* $inputs = $('#additional_attachments input[type=hidden]');
        $inputs.each(function() { data.append( this.name,$(this).val());}); */

        data.append('op_id', opId);

        $.each($('#downloadable_file')[0].files, function (i, file) {
            data.append('additional_attachment', file);
        });

        $.ajax({
            url: fcom.makeUrl(controllerName, 'setupAdditionalOpAttachment'),
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            success: function (t) {
                var ans = $.parseJSON(t);
                if (ans.status == 0) {
                    $.ykmsg.error(ans.msg);
                    return;
                }
                $.ykmsg.success(ans.msg);
                setTimeout("pageRedirect(" + opId + ")", 1000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error Occurred.");
            }
        });
    }
    getPickupForm = function (opId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('ShippingServices', 'pickupForm', [opId]), '', function (res) {
            $.ykmsg.close();
            $.ykmodal(res, false);
            if (0 < $('.date--js').length) {
                $('.date--js').datepicker({
                    minDate: new Date(),
                    dateFormat: 'yy-mm-dd'
                });
            }

            if (0 < $('.dateTime--js').length) {
                $('.dateTime--js').datetimepicker({
                    minDate: new Date(),
                    format: 'Y-m-d H:i'
                });
            }

            if (0 < $('.time--js').length) {
                $('.time--js').datetimepicker({
                    datepicker: false,
                    format: 'H:i',
                    step: 30
                });
            }
        });
    }
    createPickup = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        fcom.displayProcessing();
        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('ShippingServices', 'createPickup'), data, function (t) {
            $.ykmsg.close();
            t = $.parseJSON(t);
            if (1 > t.status) {
                $.ykmsg.error(t.msg);
                return;
            }
            window.location.reload();
        });
    };

    cancelPickup = function (opId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippingServices', 'cancelPickup', [opId]), '', function (t) {
            setTimeout(function () { window.location.href = fcom.makeUrl(controllerName, 'view', [opId]) }, 300);
        });
    };

    shippingRatesForm = function (opId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('ShippingServices', 'shippingRatesForm', [opId]), '', function (res) {
            $.ykmsg.close();
            $.ykmodal(res, false);
        });
    }

    setUpShippingRate = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        fcom.displayProcessing();
        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('ShippingServices', 'setUpShippingRate'), data, function (t) {
            $.ykmsg.close();
            t = $.parseJSON(t);
            if (1 > t.status) {
                $.ykmsg.error(t.msg);
                return;
            }
            $.ykmsg.success(t.msg);
        });
    };
})();