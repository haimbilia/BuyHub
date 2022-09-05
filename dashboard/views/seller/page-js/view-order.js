$(document).ready(function () {
    var canShipByPlugin = 1;
    $(document).on('click', 'input.manualShippingJs,select.manualShippingJs', function () {
        if ((this).is("select")) {
            manualShipping = $("select.manualShippingJs").val();
        } else {
            manualShipping = $("input.manualShippingJs:checked").val();
        }
        if (manualShipping == 1) {
            setTimeout(() => {
                trackingUrlFld();
            }, 500);
        }
    });
});

(function () {
    updateStatus = function (frm) {
        if (!$(frm).validate()) { return; }
        var op_id = $(frm.op_id).val();
        var manualShipping = 0;
        var orderStatusId = $(frm.op_status_id).val();
        if (0 < $("input.manualShippingJs").length) {
            manualShipping = $("input.manualShippingJs:checked").val();
        } else if (0 < $("select.manualShippingJs").length) {
            manualShipping = $("select.manualShippingJs").val();
        }

        var data = fcom.frmData(frm);
        if (0 < canShipByPlugin && 1 != manualShipping && orderShippedStatus == orderStatusId) {
            proceedToShipment(op_id);
        } else {
            fcom.updateWithAjax(fcom.makeUrl('Seller', 'changeOrderStatus'), data, function (t) {
                setTimeout("pageRedirect(" + op_id + ")", 1000);
            });
        }
    };

    trackOrder = function (trackingNumber, courier, orderNumber) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('Seller', 'orderTrackingInfo', [trackingNumber, courier, orderNumber]), '', function (res) {
            $.ykmsg.close();
            $.ykmodal(res);
        });
    };

    /* ShippingServices */
    generateLabel = function (opId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippingServices', 'generateLabel', [opId]), '', function (t) {
            setTimeout(function () { window.location.href = fcom.makeUrl('Seller', 'viewOrder', [opId]) }, 300);
        });
    }

    proceedToShipment = function (opId) {
        fcom.displayProcessing();
        if ('' == $(".shippingUser-js").val()) {
            fcom.displayErrorMessage(langLbl.shippingUser);
            return;
        }
        fcom.ajax(fcom.makeUrl('ShippingServices', 'proceedToShipment', [opId]), '', function (t) {
            $.ykmsg.close();
            t = $.parseJSON(t);
            if (1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                return;
            }

            var form = "form.markAsShipped-js";
            if (0 < $(form).length) {
                $(form + " .status-js").val(orderShippedStatus).change();
                $(form + " .notifyCustomer-js").val(1);
                $(form + " #shippedByPluginJs").val(1);
                $(form + " input[name='tracking_number']").val(t.tracking_number);
                canShipByPlugin = 0;
                if ('' != t.tracking_number) {
                    $(form + ' .manualShippingJs').attr('data-fatreq', '{"required":false}');
                }
                updateStatus($(form)[0]);
            } else {
                window.location.reload();
            }
        });
    }
    /* ShippingServices */
    /* ShipStation */
    courierFld = function () {
        $('.courierBlk--js').removeClass('d-none');
        $('.courierFld--js').attr('data-fatreq', '{"required": true}');
        $('.trackingUrlBlk--js').addClass('d-none');
        $('.trackingUrlFld--js').attr('data-fatreq', '{"required": false}');
    }
    trackingUrlFld = function () {
        $('.trackingUrlBlk--js').removeClass('d-none');
        $('.trackingUrlFld--js').attr('data-fatreq', '{"required": true}');
        $('.courierBlk--js').addClass('d-none');
        $('.courierFld--js').attr('data-fatreq', '{"required": false}');
    }

    fetchTrackingDetail = function (trackingId, opInvoiceId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('ShippingServices', 'fetchTrackingDetail', [trackingId, opInvoiceId]), '', function (res) {
            $.ykmsg.close();
            $.ykmodal(res);
        });
    }

    pageRedirect = function (op_id) {
        window.location.replace(fcom.makeUrl('Seller', 'viewOrder', [op_id]));
    }

    uploadAdditionalAttachment = function () {
        /* $inputs = $('#additional_attachments input[type=hidden]');
        $inputs.each(function() { data.append( this.name,$(this).val());}); */

        var data = new FormData();

        var opId = $("input[name='op_id']").val();
        data.append('op_id', opId);

        $.each($('#downloadable_file')[0].files, function (i, file) {
            data.append('additional_attachment', file);
        });

        $.ajax({
            url: fcom.makeUrl('Seller', 'setupAdditionalOpAttachment'),
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
        fcom.ajax(fcom.makeUrl('ShippingServices', 'pickupForm', [opId]), '', function (res) {
            $.ykmodal(res);
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
            t = $.parseJSON(t);
            if (1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                return;
            }
            fcom.displaySuccessMessage(t.msg);
            window.location.reload();
        });
    };
    cancelPickup = function (opId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippingServices', 'cancelPickup', [opId]), '', function (t) {
            setTimeout(function () { window.location.href = fcom.makeUrl('Seller', 'viewOrder', [opId]) }, 300);
        });
    };
    shippingRatesForm = function (opId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('ShippingServices', 'shippingRatesForm', [opId]), '', function (res) {
            $.ykmodal(res);
            fcom.removeLoader();
            $.ykmsg.close();
        });
    }
    setUpShippingRate = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        fcom.displayProcessing();
        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('ShippingServices', 'setUpShippingRate'), data, function (t) {
            t = $.parseJSON(t);
            if (1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                return;
            }
            fcom.displaySuccessMessage(t.msg);
            setTimeout(function () { window.location.href = fcom.makeUrl('Seller', 'viewOrder', [frm.op_id.value]) }, 300);
        });
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
})();
