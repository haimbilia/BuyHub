$(document).ready(function () {
    searchRecords(document.frmRecordSearch);
});
(function () {
    var dv = '#creditListing';

    searchRecords = function (frm) {
        /*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
        var data = fcom.frmData(frm);
        /*]*/
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Account', 'creditSearch'), data, function (res) {
            fcom.removeLoader();
            $(dv).html(res);
        });
    };

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmRecordSearchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    clearSearch = function () {
        document.frmRecordSearch.reset();
        searchRecords(document.frmRecordSearch);
    };

    withdrawalReqForm = function () {
        $payoutType = $(".payout_type").val();
        if ('-1' == $payoutType) {
            fcom.ajax(fcom.makeUrl('Account', 'requestWithdrawal'), '', function (res) {
                $.ykmodal(res);
            });
        } else {
            fcom.ajax(fcom.makeUrl($payoutType, 'getRequestForm'), '', function (res) {
                $.ykmodal(res);
            });
        }
        fcom.removeLoader();
    };

    setupWithdrawalReq = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('Account', 'setupRequestWithdrawal'), data, function (t) {
            fcom.removeLoader();
            searchRecords(document.frmRecordSearch);
        });
    };

    setUpWalletRecharge = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Account', 'setUpWalletRecharge'), data, function (t) {
            if (t.redirectUrl) {
                window.location = t.redirectUrl;
            }
        });
    }
    setupPluginForm = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl(frm.keyName.value, 'setup'), data, function (t) {
            fcom.removeLoader();
            searchRecords(document.frmRecordSearch);
        });
    };
})();
