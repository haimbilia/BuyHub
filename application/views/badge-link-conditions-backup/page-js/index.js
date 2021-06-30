$(document).ready(function () {
    searchRecords(document.frmSearch);
    
    $(document).on('change', '.formSearch--js select[name="badge_type"]', function () {
        var selectors = $(".formSearch--js select[name='record_condition'], .formSearch--js select[name='blinkcond_condition_type']");
        if (TYPE_RIBBON == $(this).val()) {
            selectors.val("").attr('disabled', 'disabled');
            return;
        }
        selectors.removeAttr('disabled');
    });
});

var formClass = '.addUpdateForm--js ';

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
        $(dv).html(fcom.getLoader());
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        fcom.ajax(fcom.makeUrl(controller, 'search'), data, function (res) {
            $(dv).html(res);
        });
    };

    clearSearch = function () {
        document.frmSearch.reset();
        searchRecords(document.frmSearch);
        $('.searchHead--js').click();
        var selectors = $(".formSearch--js select[name='record_condition'], .formSearch--js select[name='blinkcond_condition_type']");
        selectors.removeAttr('disabled');
    };
})()