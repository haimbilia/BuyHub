$(document).ready(function() {
    searchRecords(document.frmOfferSrch);
});
(function() {

    searchRecords = function(frm) {
        var data = fcom.frmData(frm);
        $("#listing").html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Buyer', 'searchGiftCards'), data, function(res) {
            $("#listing").html(res);
            fcom.removeLoader();
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



    addGiftCards = function() {
        $.ykmodal(fcom.getLoader(), true);
        fcom.ajax(fcom.makeUrl('Buyer', 'giftCardForm'), '', function(t) {
            $.ykmodal(t, true, "modal-lg");
            fcom.removeLoader();
        });
    };

    setup = function(frm) {
        if (!$(frm).validate()) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('Buyer', 'setupGiftCard'), fcom.frmData(frm), function(response) {
            if (response.redirectUrl) {
                setTimeout(function() {
                    window.location.href = response.redirectUrl
                }, 1000);
            }
        }, { failed: true });
    };

})();