
(function () {
    var transactionUserId = 0;
    var defaultController = controllerName;
    transactions = function (userId) {
        transactionUserId = userId;
        $.facebox(function () {
            getTransactions(userId);
        });
    };

    getTransactions = function (userId, frm = '') {
        $.ykmodal(fcom.getLoader(), false, '');
        var data = 'utxn_user_id=' + userId;
        if (frm) {
            data = fcom.frmData(frm);
        }
        fcom.ajax(fcom.makeUrl('transactions', 'shippingTransactionSearch'), data, function (t) {
            $.ykmodal(t, false, '');
        });
        fcom.removeLoader();
    };

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmShippingSearchPaging;
        $(frm.page).val(page);
        getTransactions(0, frm);
    }

    setTranPageSize = function (pageSize) {
        var frm = document.frmShippingSearchPaging;
        $(frm).append("<input type='hidden' name='pageSize' value='" + pageSize + "' />");
        getTransactions(0, frm);
    };

    addUserTransaction = function (userId) {
        $.ykmodal(fcom.getLoader(), false, '');
        var data = 'utxn_user_id=' + userId;
        fcom.ajax(fcom.makeUrl('transactions', 'form'), data, function (t) {
            $.ykmodal(t, false, 'modal-dialog-vertical-md');
            fcom.removeLoader();
        });
        controllerName = defaultController;
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
            console.log(controllerName);
            if (controllerName == 'Transactions') {
                frm.reset();
            } else {
                reloadList();
            }
            controllerName = defaultController;
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
