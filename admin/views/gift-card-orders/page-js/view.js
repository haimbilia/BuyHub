(function () {
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

    getItem = function (orderId, ossubsId) {
        if (0 < $(".opDetailsJs" + ossubsId).length) {
            $.ykmodal.show();
        } else {
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'getItem', [orderId]), 'ossubs_id=' + ossubsId, function (ans) {
                fcom.closeProcessing();
                fcom.removeLoader();
                $.ykmodal(ans.html);
            });
        }
    };

    viewPaymemntGatewayResponse = function (data) {
        $.ykmodal('<div class="form-edit-body">'+data+"</div>", true,'modal-lg');
    };
})();