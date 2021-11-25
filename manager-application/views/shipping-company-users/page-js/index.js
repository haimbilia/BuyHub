 
(function () { 
    var transactionUserId = 0;    

    usersAutocomplete = function (v) {
        var dv = $('.autoSuggest');
        if (v.value == '')
            return;
        fcom.ajax(fcom.makeUrl('users', 'autoComplete'), {keyword: v.value, user_type: document.frmUserSearch.user_type.value}, function (t) {
            dv.show();
            dv.html(t);
        });
    };

    fillSuggetion = function (v) {
        $('#keyword').val(v);
        $('.autoSuggest').hide();
    };

    transactions = function (userId) {
        transactionUserId = userId;
        $.facebox(function () {
            getTransactions(userId);
        });
    };

    getTransactions = function (userId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('Users', 'transaction', [userId]), '', function (t) {
            fcom.updateFaceboxContent(t);
        });
    };

    addUserTransaction = function (userId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('Users', 'addUserTransaction', [userId]), '', function (t) {
            fcom.updateFaceboxContent(t);
        });
    };

    setupUserTransaction = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Users', 'setupUserTransaction'), data, function (t) {
            if (t.userId > 0) {
                getTransactions(t.userId);
            }
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
