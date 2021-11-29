
(function () {
    var transactionUserId = 0;

    transactions = function (userId) {
        transactionUserId = userId;
        $.facebox(function () {
            getTransactions(userId);
        });
    };

    getTransactions = function (userId) {
        $.ykmodal(fcom.getLoader(), false, '');
        fcom.ajax(fcom.makeUrl('transactions', 'search'), 'utxn_user_id=' + userId, function (t) {
            $.ykmodal(t, true, '');
        });
    };

    addUserTransaction = function (userId) {
        $.ykmodal(fcom.getLoader(), false, '');
        var data = 'utxn_user_id=' + userId;
        fcom.ajax(fcom.makeUrl('transactions', 'form'), data, function (t) {
            $.ykmodal(t, false, '');
            fcom.removeLoader();
        });
    };

    saveRecord = function (frm, callback = '') {
        if (false === checkControllerName()) {
            return false;
        }

        if (!$(frm).validate()) {
            return;
        }

        $.ykmodal(fcom.getLoader());
        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controllerName, 'setup'), data, function (res) {
            $("." + $.ykmodal.element + ' .submitBtnJs').removeClass('loading');
            fcom.removeLoader();
            var t = JSON.parse(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
                return false;
            }
            $.ykmsg.success(t.msg);
            frm.reset();
            return;
        });
    };

    goToTransactionPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmTransactionSearchPaging;
        $(frm.page).val(page);
        data = fcom.frmData(frm);
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('Users', 'transaction', [transactionUserId]), data, function (t) {
            fcom.updateFaceboxContent(t);
        });
        $.systemMessage.close();
    };

})();
