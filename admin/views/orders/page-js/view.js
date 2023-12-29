$(document).on('change', '.downloadTypeJs', function () {
    $('.downloadTypeSectionJs').hide();
    $('.downloadType-' + $(this).val()).fadeIn();
});

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
            fcom.displaySuccessMessage(t.msg);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        });
    };
    approve = function (orderPaymentId) {
        if (!confirm(langLbl.confirmUpdate)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'approvePayment', [orderPaymentId]), '', function (t) {
            fcom.displaySuccessMessage(t.msg);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        });
    };
    reject = function (orderPaymentId) {
        if (!confirm(langLbl.confirmUpdate)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'rejectPayment', [orderPaymentId]), '', function (t) {
            fcom.displaySuccessMessage(t.msg);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        });
    };
    viewPaymemntGatewayResponse = function (orderId) {
        fcom.ajax(fcom.makeUrl('Orders', 'viewPaymemntGatewayResponse'), 'order_id=' + orderId, function (t) {
            $.ykmodal(t.html, true, "modal-lg");
        }, { fOutMode: 'json' });
    };

    getOpCharges = function (orderId, chargeType) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'orderProductsCharges', [orderId, chargeType]), '', function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $.ykmodal(t.html, true, "modal-lg");
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
                fcom.closeProcessing();
                fcom.removeLoader();
                $.ykmodal(ans.html);
            });
        }
    };

    getItemStatusHistory = function (orderId, opId) {
        if (0 < $(".opStausLogJs" + opId).length) {
            $.ykmodal.show();
        } else {
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'getItemStatusHistory', [orderId]), 'recordId=' + opId, function (ans) {
                fcom.closeProcessing();
                fcom.removeLoader();
                $.ykmodal(ans.html);
            });
        }
    };

    getShippingUsersForm = function (orderId, opId) {
        fcom.updateWithAjax(fcom.makeUrl('Orders', 'shippingUsersForm', [orderId]), 'op_id=' + opId, function (ans) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $.ykmodal(ans.html);
        });
    };

    getOrderCommentForm = function (orderId, opId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'orderCommentsForm', [orderId]), 'op_id=' + opId, function (ans) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $.ykmodal(ans.html);
        });
    };

    getPayments = function (orderId) {
        fcom.ajax(fcom.makeUrl('Orders', 'getPayments', [orderId]), [], function (ans) {
            fcom.closeProcessing();
            fcom.removeLoader();
            if (0 < ans.status) {
                $('.paymentListJs').html(ans.html);
            }
            $('.paymentListJs').html(ans.html);
        }, { fOutMode: 'json' });
    };

    updateStatus = function (frm) {
        if (!$(frm).validate()) return;
        var op_id = $(frm.op_id).val();
        var data = fcom.frmData(frm);
        var orderStatusId = $(frm.op_status_id).val();
        /* var oldStatus = $(frm.op_status_id).data('oldValue');
        if (oldStatus == orderStatusId) {
            fcom.displayErrorMessage(langLbl.alreadySelected);
            return;
        } */

        if (0 < $(".shippingUserJs").length && '' == $(".shippingUserJs").val()) {
            fcom.displayErrorMessage(langLbl.shippingUser);
            return;
        }

        var manualShipping = 0;
        if (0 < $("input.manualShippingJs").length) {
            manualShipping = $("input.manualShippingJs:checked").val();
        } else if (0 < $("select.manualShippingJs").length) {
            manualShipping = $("select.manualShippingJs").val();
        }
        $.ykmodal(fcom.getLoader());
        if (0 < canShipByPlugin && 1 != manualShipping && orderShippedStatus == orderStatusId) {
            proceedToShipment(op_id);
        } else {
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'changeOrderStatus'), data, function (t) {
                fcom.displaySuccessMessage(t.msg);
                fcom.removeLoader();
                $("#allSellerJs").trigger('change');
                getOrderCommentForm(frm.order_id.value, frm.op_id.value);
                getPayments(frm.order_id.value);
            });
        }
    };

    updateShippingUser = function (frm) {
        var data = fcom.frmData(frm);
        if (!$(frm).validate()) return;
        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updateShippingUser'), data, function (t) {
            fcom.removeLoader();
            fcom.displaySuccessMessage(t.msg);
        });
    };

    /* ShipStation */
    generateLabel = function (opId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('ShippingServices', 'generateLabel', [opId]), '', function (t) {
            if (1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                if ('openShipUser' in t && t.openShipUser == 1) {
                    setTimeout(function () {
                        getShippingUsersForm(t.orderId, t.opId);
                    }, 1000);
                }
                return;
            }
            fcom.displaySuccessMessage(t.msg);
            setTimeout(function () {
                location.reload();
            }, 300);
        }, { fOutMode: 'json' });
    }
    /* ShipStation */

    proceedToShipment = function (opId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('ShippingServices', 'proceedToShipment', [opId]), '', function (t) {
            fcom.removeLoader();
            fcom.closeProcessing();
            t = $.parseJSON(t);
            if (1 > t.status) {
                fcom.displayErrorMessage(t.msg);

                if ('openShipUser' in t && t.openShipUser == 1) {
                    setTimeout(function () {
                        getShippingUsersForm(t.orderId, t.opId);
                    }, 1000);
                }
                return;
            }
            fcom.displaySuccessMessage(t.msg);

            let data = { op_id: opId, op_status_id: orderShippedStatus, customer_notified: 1, tracking_number: t.tracking_number, shipped_by_plugin: 1 };
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
        $.ykmodal(fcom.getLoader(), false);
        fcom.ajax(fcom.makeUrl('ShippingServices', 'fetchTrackingDetail', [trackingId, opInvoiceId]), '', function (res) {
            $.ykmodal(res, false);
            fcom.removeLoader();
            fcom.closeProcessing();
        });
    }

    trackOrder = function (trackingNumber, courier, orderNumber, orderId, op_id) {
        $.ykmodal(fcom.getLoader(), false);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'orderTrackingInfo', [trackingNumber, courier, orderNumber]), { orderId, op_id }, function (res) {
            fcom.closeProcessing();
            $.ykmodal(res.html, false);
            fcom.removeLoader();
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
                    fcom.displayErrorMessage(ans.msg);
                    return;
                }
                fcom.displaySuccessMessage(ans.msg);
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
            fcom.closeProcessing();
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
            fcom.closeProcessing();
            t = $.parseJSON(t);
            if (1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                return;
            }
            window.location.reload();
        });
    };

    cancelPickup = function (opId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippingServices', 'cancelPickup', [opId]), '', function (t) {
            fcom.displaySuccessMessage(t.msg);
            setTimeout(function () { window.location.reload(); }, 300);
        });
    };

    shippingRatesForm = function (opId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippingServices', 'shippingRatesForm', [opId]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };

    setUpShippingRate = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        fcom.displayProcessing();
        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('ShippingServices', 'setUpShippingRate'), data, function (t) {
            fcom.closeProcessing();
            t = $.parseJSON(t);
            if (1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                return;
            }
            fcom.displaySuccessMessage(t.msg);
            $.ykmodal.close();
            setTimeout(function () { window.location.reload(); }, 300);
        });
    };

    viewAttachments = function (opId) {
        fcom.updateWithAjax(fcom.makeUrl('Orders', 'viewAttachments', [opId]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, false, 'modal-dialog-vertical-md')
        });
    }

    getCancelOrderProductForm = function (opId) {
        fcom.updateWithAjax(fcom.makeUrl('Orders', 'getCancelOrderProductForm', [opId]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, false);
        });
    }

    cancelOrderProduct = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('Orders', 'cancelOrderProduct'), data, function (t) {
            fcom.closeProcessing();
            fcom.displaySuccessMessage(t.msg);
            getOrderParticulars(t.order_id, { value: "" });
            $.ykmodal.close();
        });
    };
})();