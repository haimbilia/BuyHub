$(document).ready(function() {
    searchGiftCards(document.frmOfferSrch);
});
(function() {

    searchGiftCards = function(frm) {
        var data = fcom.frmData(frm);
        $("#listing").html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Buyer', 'searchGiftCards'), data, function(res) {
            $("#listing").html(res);
            fcom.removeLoader();
        });
    };

    searchRecords = function(frm) {
        /*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
        var data = fcom.frmData(frm);
        /*]*/
        $("#listing").prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Buyer', 'searchGiftCards'), data, function(res) {
            fcom.removeLoader();
            $("#listing").html(res);
        });
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
        frm.submit.disabled = true;
        fcom.updateWithAjax(fcom.makeUrl('Buyer', 'setupGiftCard'), fcom.frmData(frm), function(response) {
            if (response.redirectUrl) {
                setTimeout(function() {
                    window.location.href = response.redirectUrl
                }, 1000);
            }
            if (response.status != 1) {
                frm.submit.disabled = false;
            }
        }, { failed: true });
    };


    walletSelection = function(el) {
        var wallet = $(el).is(":checked") ? 1 : 0;
        var data = "payFromWallet=" + wallet;
        fcom.updateWithAjax(
            fcom.makeUrl("Buyer", "walletSelection"),
            data,
            function(ans) {
                // if (wallet) {
                //     $('input[name=order_pmethod_id]').attr('checked', false);
                // } else {
                //     addGiftCards();
                // }
            }
        );
    };




})();