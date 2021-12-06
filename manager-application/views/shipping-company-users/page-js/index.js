var defaultController = controllerName;
(function () {
    var transactionUserId = 0;
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
            if (controllerName == 'Transactions') {
                $.ykmodal.close();
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


    loadMore = function () {
        if (false === checkControllerName()) {
            return false;
        }

        var frm = document.frmLoadMoreRecordsPaging;
        var page = 1;
        if (
                "undefined" != typeof frm.page.value &&
                "" != frm.page.value &&
                0 < frm.page.value
                ) {
            page += parseInt(frm.page.value);
        }

        $(frm.page).val(page);
        var reference = $(".appendRowsJs .rowJs:last").data("reference");
        if (
                "undefined" != typeof reference &&
                "undefined" != typeof frm.reference
                ) {
            $(frm.reference).val(reference);
        }

        var data = fcom.frmData(frm);

        $(".appendRowsJs .rowJs:last")
                .clone()
                .removeAttr("class")
                .addClass("rowJs")
                .appendTo(".appendRowsJs")
                .html(fcom.getRowSpinner());
        fcom.ajax(fcom.makeUrl('transactions', "getRows"), data, function (rows) {
            $(".appendRowsJs .rowJs:last").remove();
            $(".appendRowsJs").append(rows);

            if (page == frm.pageCount.value) {
                $(".loadMorePaginationJs").remove();
            }
        });
    };

})();

$(document).bind("close.ykmodal", function () {
    controllerName = defaultController;
    $.ykmodal.close();
});
$(document).on("hidden.bs.modal", "." + $.ykmodal.element, function () {
    controllerName = defaultController;
    $.ykmodal.close()
});

