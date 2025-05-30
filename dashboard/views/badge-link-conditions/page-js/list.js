$(document).ready(function () {
    searchRecords(document.frmRecordSearch);
});

$(document).on('click', '.selectAll-js, .selectItem--js', function () {
    if (0 < $('.selectItem--js:checked').length) {
        $('.deleteSelectedConds--js').removeClass('d-none');
    } else {
        $('.deleteSelectedConds--js').addClass('d-none');
    }
});

(function () {
    var dv = '#listing';
    var controller = 'BadgeLinkConditions';

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSrchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    reloadList = function () {
        var frm = document.frmSrchPaging;
        searchRecords(frm);
    };

    searchRecords = function (form) {
        $(dv).prepend(fcom.getLoader());
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        
        fcom.ajax(fcom.makeUrl(controller, 'search'), data, function (res) {
            fcom.removeLoader();
            $(dv).html(res);
        });
    };

    clearSearch = function () {
        document.frmRecordSearch.reset();
        searchRecords(document.frmRecordSearch);
        $('.searchHead--js').click();
    };
    
    unlink = function (e, blinkcond_id) {
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }

        if (blinkcond_id < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'blinkcond_id=' + blinkcond_id;
        fcom.ajax(fcom.makeUrl(controller, 'badgeUnlink'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
                reloadList();
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };
})()