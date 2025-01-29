$(document).ready(function () {
    // searchPages(document.frmAppVersionSearch);
});

(function () {
    reloadListing = function () {
        searchPages(document.frmSearchPaging);
    };

    goToSearchPage = function (page) {
        page = (page) ? page : 1;
        var frm = document.frmSearchPaging;
        $(frm.page).val(page);
        searchPages(frm);
    };

    searchPages = function (form) {
        var dv = '#pageListing';
        var data = (form) ? fcom.frmData(form) : '';
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('AppReleaseVersion', 'search'), data, function (res) {
            fcom.removeLoader();
            if (isJson(res)) {
                $(dv).html('');
                var res = JSON.parse(res);
                if (res.status == 0) {
                    fcom.displayErrorMessage(res.msg);
                } else {
                    fcom.displaySuccessMessage(res.msg);
                }
                return false;
            } else {
                $(dv).html(res);
            }
        });
    };

    addForm = function (id) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('AppReleaseVersion', 'form', [id]), '', function (response) {
            fcom.closeProcessing();
            $.grmodal(response);
        });
    };

    setup = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        fcom.displayProcessing();
        fcom.updateWithAjax(fcom.makeUrl('AppReleaseVersion', 'setup'), fcom.frmData(frm), function (response) {
            fcom.closeProcessing();
            if (isJson(response)) {
                var res = JSON.parse(response);
                if (res.status == 0) {
                    fcom.displayErrorMessage(res.msg);
                } else {
                    fcom.displaySuccessMessage(res.msg);
                }
                return false;
            } else {
                reloadListing();
                $.grmodal.close();
            }
        });
    };

    clearSearch = function () {
        document.frmAppVersionSearch.reset();
        searchPages(document.frmAppVersionSearch);
    };
})();
