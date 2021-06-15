$(document).ready(function () {
    var canShipByPlugin = 1;
    $(document).on('click', 'input.manualShipping-js', function () {
        if ($(this).is(":checked")) {
            setTimeout(() => {
                trackingUrlFld();
            }, 500);
        }
    });
});

(function () {
    updateStatus = function (frm) {
        if (!$(frm).validate()) return;
        var op_id = $(frm.op_id).val();
        var manualShipping = 0;
        var orderStatusId = $(frm.op_status_id).val();
        if (0 < $("input.manualShipping-js").length) {
            manualShipping = $("input.manualShipping-js:checked").val();
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
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('Seller', 'orderTrackingInfo', [trackingNumber, courier, orderNumber]), '', function (res) {
                $.facebox(res, 'medium-fb-width');
            });
        });
    };

    /* ShippingServices */
    generateLabel = function (opId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippingServices', 'generateLabel', [opId]), '', function (t) {
            window.location.reload();
        });
    }

    proceedToShipment = function (opId) {
        $.mbsmessage(langLbl.processing, false, 'alert--process');
        if ('' == $(".shippingUser-js").val()) {
            $.mbsmessage(langLbl.shippingUser, false, 'alert--danger');
            return;
        }
        fcom.ajax(fcom.makeUrl('ShippingServices', 'proceedToShipment', [opId]), '', function (t) {
            $.mbsmessage.close();
            t = $.parseJSON(t);
            if (1 > t.status) {
                $.mbsmessage(t.msg, false, 'alert--danger');
                return;
            }
            // $.mbsmessage(t.msg, false, 'alert--success');

            var form = "form.markAsShipped-js";
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
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('ShippingServices', 'fetchTrackingDetail', [trackingId, opInvoiceId]), '', function (res) {
                $.facebox(res, 'medium-fb-width');
            });
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
                    $.systemMessage(ans.msg, 'alert alert--danger');
                    return;
                }
                $.systemMessage(ans.msg, 'alert alert--success');
                setTimeout("pageRedirect(" + opId + ")", 1000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error Occurred.");
            }
        });
    }

    getPickupForm = function (opId) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('ShippingServices', 'pickupForm', [opId]), '', function (res) {
                $.facebox(res, 'medium-fb-width');
                if (0 < $('.date--js').length) {
                    $('.date--js').datepicker({
                        minDate: new Date(),
                        dateFormat:'yy-mm-dd'
                    });
                } 
                
                if (0 < $('.dateTime--js').length) {
                    $('.dateTime--js').datetimepicker({
                        minDate: new Date(),
                        format:'y-m-d H:i'
                    });
                } 

                if (0 < $('.time--js').length) {
                    $('.time--js').datetimepicker({
                        datepicker: false,
                        format:'H:i',
                        step: 30
                    });
                }
            });
        });
    }
    createPickup = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('ShippingServices', 'createPickup'), data, function (res) {
            console.log(res);
        });
    }
})();
