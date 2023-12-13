$(function() {
    searchRecords(document.frmRecordSearch);
    $(document).on('click', '.withdrawJs', function() {

    });
});
(function() {
    var dv = '#creditListing';
    searchRecords = function(frm) {
        /*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
        var data = fcom.frmData(frm);
        /*]*/
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Account', 'creditSearch'), data, function(res) {
            fcom.removeLoader();
            $(dv).html(res);
        });
    };

    goToSearchPage = function(page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmRecordSearchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    clearSearch = function() {
        document.frmRecordSearch.reset();
        searchRecords(document.frmRecordSearch);
    };

    setupWithdrawalReq = function(frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('Account', 'setupRequestWithdrawal'), data, function(t) {
            fcom.removeLoader();
            window.location = fcom.makeUrl('Account', 'credits');
            $.ykmodal.close();
        });
    };

    setupPluginForm = function(frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl(frm.keyName.value, 'setup'), data, function(t) {
            fcom.removeLoader();
            searchRecords(document.frmRecordSearch);
            $.ykmodal.close();
        });
    };

    setUpWalletRecharge = function(frm) {
        if (!$(frm).validate()) { return; }
        if ('' == frm.amount.value) { return; }
        var data = fcom.frmData(frm);
        $.ykmodal(fcom.getLoader(), true);
        fcom.updateWithAjax(fcom.makeUrl('Account', 'setUpWalletRecharge'), data, function(t) {
            if (t.redirectUrl) {
                window.location = t.redirectUrl;
            }
        });
    }

    withdrawalOptionsForm = function(payoutType = -1) {
        var url = fcom.makeUrl('Account', 'requestWithdrawal');
        if (-1 != payoutType) {
            url = fcom.makeUrl(payoutType, 'getRequestForm', []);
        }

        fcom.updateWithAjax(url, '', function(t) {
            fcom.removeLoader();
            $.ykmodal(t.html);
        });
    };

    addCredits = function() {
        $.ykmodal(fcom.getLoader(), true);
        fcom.updateWithAjax(fcom.makeUrl('Account', 'walletRechargeForm'), '', function(t) {
            fcom.removeLoader();
            $.ykmodal(t.html, true);
        });
    };


    redeemGiftCard = function() {
        $.ykmodal(fcom.getLoader(), true);
        fcom.ajax(fcom.makeUrl('Account', 'redeemGiftCardForm'), '', function(t) {
            fcom.removeLoader();
            $.ykmodal(t, true);
        });
    };


    giftcardRedeem = function(frm) {
        if (!$(frm).validate()) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Account', 'reedemGiftcard'), fcom.frmData(frm), function(res) {
            // $(document).trigger('close.facebox');
            // document.location.reload();
        });
    };

})();