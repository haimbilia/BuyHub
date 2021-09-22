$(document).on("click", ".headerColumnJs", function (e) {
    var fld = $(this).attr('data-field');
    var frm = document.frmRecordSearchPaging;
    var sortingUp = '<svg class="svg" width="18" height="18"><use xlink: href = "' + siteConstants.webroot + 'images/retina/sprite-actions.svg#arrow-up"></use > </svg>';
    var sortingDown = '<svg class="svg" width="18" height="18"><use xlink: href = "' + siteConstants.webroot + 'images/retina/sprite-actions.svg#arrow-down"></use > </svg>';
    var sortIcn = "";
    var sortcls = "";

    document.getElementById("sortBy").value = fld;
    $(frm.sortBy).val(fld);
    $(frm.page).val(1);
    $('.sortingIconJs').remove();
    $('.headerColumnJs').removeClass('sorting_asc sorting_desc');

    if (document.getElementById("sortOrder").value == 'ASC') {
        $(frm.sortOrder).val('DESC');
        document.getElementById("sortOrder").value = 'DESC';
        sortIcn = sortingUp;
        sortcls = 'sorting_asc';
    } else {
        $(frm.sortOrder).val('ASC');
        document.getElementById("sortOrder").value = 'ASC';
        sortIcn = sortingDown;
        sortcls = 'sorting_desc';
    }

    if (0 < $(this).find('.icn').length) {
        $(this).find('.icn').html(sortIcn);
    } else {
        $(this).find('span').append('<i class="icn sortingIconJs">' + sortIcn + '</i>');
    }
    $(this).addClass(sortcls);
    searchRecords(frm);
});

(function () {
    var dv = '.listingRecordJs';
    var paginationDv = '.listingPaginationJs';
    var listingTableJs = '.listingTableJs';

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmRecordSearchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    setPageSize = function (pageSize) {
        var frm = document.frmRecordSearchPaging;
        $(frm.pageSize).val(pageSize);
        reloadList();
    }

    redirectBack = function (redirecrt) {
        window.location = redirecrt;
    }

    reloadList = function () {
        var frm = document.frmRecordSearchPaging;
        searchRecords(frm);
    };

    searchRecords = function (frm) {
        setColumnsData(frm);
        var data = '';
        if (frm) {
            data = fcom.frmData(frm);
        }

        $(listingTableJs).prepend(fcom.getLoader());

        fcom.ajax(fcom.makeUrl(controllerName, 'search'), data, function (res) {
            var res = $.parseJSON(res);
            $(dv).replaceWith(res.listingHtml);
            $(paginationDv).replaceWith(res.paginationHtml);
            fcom.removeLoader();
        });
    };

    exportRecords = function () {
        setColumnsData(document.frmRecordSearch);
        document.frmRecordSearch.action = fcom.makeUrl(controllerName, 'search', ['export']);
        document.frmRecordSearch.submit();
    }

    clearSearch = function () {
        document.frmRecordSearch.reset();
        $("input:checkbox[name=listingColumns]:checked").each(function () {
            if ($(this).attr('disabled') != 'disabled') {
                $(this).prop('checked', false);
            }
        });
        searchRecords(document.frmRecordSearch, false);
    };

    setColumnsData = function (frm) {
        listingColumns = [];
        $("input:checkbox[name=listingColumns]:checked").each(function () {
            listingColumns.push($(this).val());
        });

        $(frm.listingColumns).val(JSON.stringify(listingColumns));
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

    addNew = function () {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, 'form'), '', function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    editRecord = function (recordId) {
        $.ykmodal(fcom.getLoader());
        data = 'recordId=' + recordId;
        fcom.ajax(fcom.makeUrl(controllerName, 'form'), data, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    editLangData = function (recordId, langId, autoFillLangData = 0) {
        $.ykmodal(fcom.getLoader());
        data = 'recordId=' + recordId + '&langId=' + langId;
        fcom.ajax(fcom.makeUrl(controllerName, 'langForm', [autoFillLangData]), data, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    updateStatus = function (e, obj, recordId, status) {
        e.stopPropagation();
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return false;
        }
        
        var oldStatus = $(obj).data("old-status");
        $(listingTableJs).prepend(fcom.getLoader());
        
        if (1 > recordId) {
            $(obj).prop('checked', (1 == oldStatus));
            $.ykmsg.error(langLbl.invalidRequest);
            fcom.removeLoader();
            return false;
        }

        data = 'recordId=' + recordId + '&status=' + status;
        fcom.ajax(fcom.makeUrl(controllerName, 'updateStatus'), data, function (res) {
            $(obj).prop('checked', (1 == status));
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                $.ykmsg.success(ans.msg);
                $(obj).toggleClass("active");
            } else {
                $(obj).prop('checked', (1 == oldStatus));
                $.ykmsg.error(ans.msg);
            }
            fcom.removeLoader();
        });
    };

    saveRecord = function (frm) {
        if (!$(frm).validate()) { return; }
        $.ykmodal(fcom.getLoader());

        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controllerName, 'setup'), data, function (res) {
            fcom.removeLoader();
            var t = $.parseJSON(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
                return false;
            }
            $.ykmsg.success(t.msg);

            reloadList();
            if (t.langId > 0) {
                editLangData(t.recordId, t.langId);
            }
        });
    };

    saveLangData = function (frm) {
        if (!$(frm).validate()) { return; }
        $.ykmodal(fcom.getLoader());

        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controllerName, 'langSetup'), data, function (res) {
            fcom.removeLoader();
            var t = $.parseJSON(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
                return false;
            }
            
            reloadList();
            if (t.langId > 0) {
                editLangData(t.recordId, t.langId);
            }
        });
    };

    selectAll = function (element) {
        var obj = $(element);
        var parentForm = obj.closest('form').attr('id');
        $("#" + parentForm + " .selectItemJs").each(function () {
            if (obj.prop("checked") == false) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });

        var faceboxActionBtns = (0 < $("#facebox").length && $("#facebox").is(":visible")) ? "#facebox " : '';

        if (0 < $(faceboxActionBtns + ".toolbar-btn-js").length) {
            if ($(obj).prop("checked") == false) {
                $(faceboxActionBtns + ".toolbar-btn-js").addClass('disabled').removeClass('selected');
            } else {
                $(faceboxActionBtns + ".toolbar-btn-js").removeClass('disabled').addClass('selected');;
            }
        }
    }

    formAction = function (frm, callback) {
        if (typeof $(".selectItemJs:checked").val() === 'undefined') {
            $.ykmsg.error(langLbl.atleastOneRecord);
            return false;
        }

        if (0 < $('.listingTableJs').length) {
            $('.listingTableJs').prepend(fcom.getLoader());
        }

        data = fcom.frmData(frm);

        fcom.ajax(frm.action, data, function (res) {
            fcom.removeLoader();
            $(".selectAllJs").prop("checked", false);
            callback();
            showActionsBtns();

            var t = $.parseJSON(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
            }
            $(".toolbar-btn-js").addClass('disabled').removeClass('selected');
        });
    }

    toggleBulkStatues = function (status, msg = '') {
        var element = 0 < $("#facebox").length ? "#facebox " : '';
        if ($(element).is(":hidden")) {
            element = '';
        }
        element = element + 'form.actionButtonsJs';
        if (1 > $(element).length) {
            $.ykmsg.error(langLbl.actionButtonsClass);
            return false;
        }
        msg = ('' == msg) ? langLbl.confirmUpdateStatus : msg;
        if (!confirm(msg)) {
            return false;
        }
        $(element + " input[name='status']").val(status);
        $(element).submit();
    };

    showActionsBtns = function () {
        if (typeof $(".selectItemJs:checked").val() === 'undefined') {
            $(".toolbar-btn-js").addClass('disabled').removeClass('selected');
        } else {
            $(".toolbar-btn-js").removeClass('disabled').addClass('selected');

        }
    }
})();

$(document).on("click", ".selectItemJs", function () {
    var parentForm = $(this.form).attr("id");
    if ($(this).prop("checked") == false) {
        $("#" + parentForm + " .selectAllJs").prop("checked", false);
    }

    if ($("#" + parentForm + " .selectItemJs").length == $("#" + parentForm + " .selectItemJs:checked").length) {
        $("#" + parentForm + " .selectAllJs").prop("checked", true);
    }

    var faceboxActionBtns = (0 < $("#facebox").length && $("#facebox").is(":visible")) ? "#facebox " : '';
    if ($("#" + parentForm + " .selectItemJs:checked").length == 0) {
        $(faceboxActionBtns + " .toolbar-btn-js").addClass('disabled').removeClass('selected');
    } else {
        $(faceboxActionBtns + " .toolbar-btn-js").removeClass('disabled').addClass('selected');
    }
});