(function () {
    updatePayment = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updatePayment'), data, function (t) {
            window.location.reload();
        });
    };

    getItem = function (orderId, ossubsId) {
        if (0 < $(".opDetailsJs" + ossubsId).length) {
            $.ykmodal.show();
        } else {
            $.ykmodal(fcom.getLoader(), false);
            fcom.ajax(fcom.makeUrl(controllerName, 'getItem', [orderId]), 'ossubs_id=' + ossubsId, function (ans) {
                $.ykmodal(ans);
                fcom.removeLoader()
            });
        }
    };
})();