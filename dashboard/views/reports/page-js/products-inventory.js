$(document).ready(function () {
    searchRecords(document.frmRecordSearch);
});

$(document).on("click", ".headerColumnJs", function (e) {
    var fld = $(this).attr('data-field');
    var frm = document.frmReportSearchPaging;
    document.getElementById("sortBy").value = fld;
    $(frm.sortBy).val(fld);
    if (document.getElementById("sortOrder").value == 'ASC') {
        $(frm.sortOrder).val('DESC');
        document.getElementById("sortOrder").value = 'DESC';
    } else {
        $(frm.sortOrder).val('ASC');
        document.getElementById("sortOrder").value = 'ASC';
    }
    searchRecords(frm, false);
});

$(function () {
    $("#sortable").sortable({
        handle: ".handleJs",
        helper: fixWidthHelper,
        start: fixPlaceholderStyle,
        stop: function () {
            reloadList(false);
        }
    }).disableSelection();
});

(function () {
    var dv = '#listingDiv';

    reloadList = function (withloader) {
        var frm = document.frmReportSearchPaging;
        searchRecords(frm, withloader);
    };

    searchRecords = function (frm, withloader) {
        setColumnsData(frm);
        var data = '';
        if (frm) {
            data = fcom.frmData(frm);
        }

        if (typeof withloader == 'undefined' || withloader != false) {
            $(dv).prepend(fcom.getLoader());
        }

        fcom.ajax(fcom.makeUrl('Reports', 'searchProductsInventory'), data, function (t) {
            fcom.removeLoader();
            $(dv).html(t);
        });
    };

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmReportSearchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    }

    clearSearch = function () {
        document.frmRecordSearch.reset();
        $("input:checkbox[name=reportColumns]:checked").each(function () {
            if ($(this).attr('disabled') != 'disabled') {
                $(this).prop('checked', false);
            }
        });
        searchRecords(document.frmRecordSearch);
    };

    exportReport = function () {
        setColumnsData(document.frmRecordSearch);
        document.frmRecordSearch.action = fcom.makeUrl('Reports', 'exportProductsInventoryReport');
        document.frmRecordSearch.submit();
    };

    setColumnsData = function (frm) {
        reportColumns = [];
        $("input:checkbox[name=reportColumns]:checked").each(function () {
            reportColumns.push($(this).val());
        });

        $(frm.reportColumns).val(JSON.stringify(reportColumns));
    };
})();
