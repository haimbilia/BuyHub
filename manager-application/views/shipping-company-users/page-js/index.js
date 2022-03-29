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
        var data = 'utxn_user_id=' + userId;
        if (frm) {
            data = fcom.frmData(frm);
        }
        fcom.updateWithAjax(fcom.makeUrl('Transactions', 'shippingTransactionSearch'), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, false, '');
            fcom.removeLoader();
        });
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
        var data = 'utxn_user_id=' + userId;
        fcom.updateWithAjax(fcom.makeUrl('transactions', 'form'), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, false);
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
                fcom.displayErrorMessage(t.msg);
                return false;
            }
            fcom.displaySuccessMessage(t.msg);
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
            $.ykmodal(t);
        });
    };

    loadMore = function () {
        if (false === checkControllerName()) {
            return false;
        }

        var frm = document.frmLoadMoreRecordsPaging;
        var page = 1;
        if ("undefined" != typeof frm.page.value && "" != frm.page.value && 0 < frm.page.value) {
            page += parseInt(frm.page.value);
        }

        $(frm.page).val(page);
        var reference = $(".appendRowsJs .rowJs:last").data("reference");
        if ("undefined" != typeof reference && "undefined" != typeof frm.reference) {
            $(frm.reference).val(reference);
        }

        var data = fcom.frmData(frm);

        var loadMoreBtn = $('.loadMoreBtnJs');
        var btnText = loadMoreBtn.text();
        loadMoreBtn.html(fcom.getRowSpinner());

        fcom.updateWithAjax(fcom.makeUrl('transactions', "getRows"), data, function (rows) {
            fcom.closeProcessing();
            $(".appendRowsJs").append(rows.html);
            loadMoreBtn.html(btnText);

            var similarElement = '.appendRowsJs [data-reference="' + reference + '"]';
            var lastSimilar = $(similarElement + ':last');
            if (1 < $(similarElement).length) {
                var li = lastSimilar.find('.ulJs').html();
                lastSimilar.remove();
                $(similarElement + ':last ul.ulJs').append(li);
            }

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

