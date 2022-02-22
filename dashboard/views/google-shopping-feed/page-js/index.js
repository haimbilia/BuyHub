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
            $.ykmodal(res);
            fcom.removeLoader();
        });
    };

    clearForm = function () {
        batchForm();
    };


    setupBatch = function (frm) {
        if (!$(frm).validate()) return;
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
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(keyName, 'setupServiceAccountForm'), data, function (t) {
            
            location.reload();
        });
    }

    publishBatch = function (adsBatchId) {
        $.mbsmessage(langLbl.processing, true, 'alert--process alert');
        fcom.updateWithAjax(fcom.makeUrl(keyName, 'publishBatch', [adsBatchId]), '', function (t) {
            if (t.status == 1) {
                $.mbsmessage(t.msg, true, 'alert--success');
            } else {
                $.mbsmessage(t.msg, true, 'alert--danger');
            }
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
})();