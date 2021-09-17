$(document).ready(function () {
    searchReport(document.frmReportSearch);
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
    searchReport(frm, false);
});

/* $(function () {
    $("#sortable").sortable({
        stop: function () {
            reloadList(false);
        }
    }).disableSelection();
}); */

(function () {
    var dv = '#listing';

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmReportSearchPaging;
        $(frm.page).val(page);
        searchReport(frm);
    };

    setPageSize = function (pageSize) {
        var frm = document.frmReportSearchPaging;
        $(frm.pageSize).val(pageSize);
        reloadList();
    }

    redirectBack = function (redirecrt) {
        window.location = redirecrt;
    }

    reloadList = function (withloader) {
        var frm = document.frmReportSearchPaging;
        searchReport(frm, withloader);
    };

    searchReport = function (frm, withloader) {
        setColumnsData(frm);
        var data = '';
        if (frm) {
            data = fcom.frmData(frm);
        }

        if (typeof withloader == 'undefined' || withloader != false) {
            $(dv).html(fcom.getLoader());
        }

        fcom.ajax(fcom.makeUrl(controllerName, 'search'), data, function (res) {
            $(dv).html(res);
        });
    };

    exportReport = function () {
        setColumnsData(document.frmReportSearch);
        document.frmReportSearch.action = fcom.makeUrl(controllerName, 'search', ['export']);
        document.frmReportSearch.submit();
    }

    clearSearch = function () {
        document.frmReportSearch.reset();
        $("input:checkbox[name=reportColumns]:checked").each(function () {
            if ($(this).attr('disabled') != 'disabled') {
                $(this).prop('checked', false);
            }
        });
        searchReport(document.frmReportSearch);
    };

    setColumnsData = function (frm) {
        reportColumns = [];
        $("input:checkbox[name=reportColumns]:checked").each(function () {
            reportColumns.push($(this).val());
        });

        $(frm.reportColumns).val(JSON.stringify(reportColumns));
    };

    deleteRecord = function (recordId) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        data = 'recordId=' + recordId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'deleteRecord'), data, function () {
            reloadList();
        });
    };
    
    editRecord = function (recordId) {
        data = 'recordId=' + recordId;
        fcom.ajax(fcom.makeUrl(controllerName, 'editRecord'), data, function (t) {
            $.ykmodal(t);
        });
    };

    updateStatus = function (e, obj, recordId, status) {
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return false;
        }

        if (recordId < 1) {
            e.preventDefault();
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }

        data = 'recordId=' + recordId + '&status=' + status;
        fcom.ajax(fcom.makeUrl(controllerName, 'updateStatus'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                $.mbsmessage(ans.msg, true, "alert--success alert");
                $(obj).toggleClass("active");
            }
        });
    };
})();