$(document).ready(function () {
    searchRecords(document.frmSearch);
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
    };
})()