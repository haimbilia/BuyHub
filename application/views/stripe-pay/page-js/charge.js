(function () {
    sendPayment = function (frm, dv = '') {
        var data = fcom.frmData(frm);
        var action = $(frm).attr('action');
        data += '&chargeAjax=0';
        $(".paymentFormJs").prepend(fcom.getLoader());
        fcom.displayProcessing();
        fcom.ajax(action, data, function (t) {
            // debugger;
            try {
                var json = $.parseJSON(t);
                if (typeof json.status != 'undefined' && 1 > json.status) {
                    fcom.removeLoader();
                    fcom.displayErrorMessage(json.msg);
                    return false;
                }
                if (typeof json.html != 'undefined') {
                    fcom.removeLoader();
                    $(dv).append(json.html);
                }
                console.log(json);
                if (json['redirect']) {
                    $(location).attr("href", json['redirect']);
                }
            } catch (e) {
                fcom.removeLoader();
                $(dv).append(t);
            }
        });
    };
})();