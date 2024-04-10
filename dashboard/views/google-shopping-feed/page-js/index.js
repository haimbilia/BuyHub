var keyName = 'GoogleShoppingFeed';
$(document).ready(function () {
    searchRecords();
});

(function () {
    var dv = '#listing';

    searchRecords = function (frm) {
        if (1 > $(dv).length) {
            return false;
        }
        var data = '';
        if (frm) {
            data = fcom.frmData(frm);
        }

        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(keyName, 'search'), data, function (res) {
            fcom.removeLoader();
            $(dv).html(res);
        });
    };

    batchForm = function (adsBatchId = 0, langId = 0) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(keyName, 'batchForm', [adsBatchId, langId]), '', function (res) {
            fcom.removeLoader();
            $.ykmodal(res);
            $('.date_js').datepicker('option', {
                minDate: new Date()
            });
        });
    };

    serviceAccountForm = function () {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(keyName, 'serviceAccountForm'), '', function (res) {
            $.ykmodal(res, true, 'modal-dialog-vertical-md');
            fcom.removeLoader();
        });
    };

    clearForm = function () {
        batchForm();
    };


    setupBatch = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(keyName, 'setupBatch'), data, function (t) {
            fcom.removeLoader();
            searchRecords();
            closeForm();
        });
    }

    deleteBatch = function (adsBatchId) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl(keyName, 'deleteBatch', [adsBatchId]), '', function (t) {
            searchRecords();
        });
    }

    setuppluginform = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(keyName, 'setupServiceAccountForm'), data, function (t) {
            location.reload();
        });
    }

    publishBatch = function (adsBatchId, download = 0) {
        fcom.updateWithAjax(fcom.makeUrl(keyName, 'publishBatch', [adsBatchId, download]), '', function (t) {
            if (t.status != 1) {
                fcom.displayErrorMessage(t.msg);
                return;
            }
            fcom.displaySuccessMessage(t.msg);
            searchRecords();
            if (0 < download && 'undefined' != typeof t.redirect_url) {
                setTimeout(() => {
                    location.href = t.redirect_url;
                }, 500);
            }
        });
    }

    downloadBatch = function (adsBatchId) {
        fcom.updateWithAjax(fcom.makeUrl(keyName, 'publishBatch', [adsBatchId]), '', function (t) {
            if (t.status != 1) {
                fcom.displayErrorMessage(t.msg);
                return;
            }
            fcom.displaySuccessMessage(t.msg);
            searchRecords();
        });
    }

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSearchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    subUsersAccountList = function () {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl(keyName, 'getSubUsersAccountList'), '', function (t) {
            fcom.removeLoader();
            fcom.closeProcessing();
            $.ykmodal(t.html, true);
        }, { fOutMode: 'json' });
    }

    selectSubAccount = function (merchantId) {
        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl(keyName, 'updateMerchantId'), 'merchantId=' + merchantId, function (t) {
            fcom.removeLoader();
            $.ykmodal.close();
            setTimeout(() => {
                location.reload();
            }, 1000);
        });
    }
})();