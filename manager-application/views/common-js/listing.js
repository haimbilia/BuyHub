$(document).on("click", ".headerColumnJs", function (e) {
    if (1 == $('.listingRecordJs tr').length) {
        return;
    }

    var fld = $(this).attr("data-field");
    var frm = document.frmRecordSearchPaging;
    var sortingUp =
        '<svg class="svg" width="18" height="18"><use xlink: href = "' +
        siteConstants.webroot +
        'images/retina/sprite-actions.svg#arrow-up"></use > </svg>';
    var sortingDown =
        '<svg class="svg" width="18" height="18"><use xlink: href = "' +
        siteConstants.webroot +
        'images/retina/sprite-actions.svg#arrow-down"></use > </svg>';
    var sortIcn = "";
    var sortcls = "";

    document.getElementById("sortBy").value = fld;
    if ("undefined" != typeof frm) {
        $(frm.sortBy).val(fld);
        $(frm.page).val(1);
    }

    $(".headerColumnJs").removeClass("sorting_asc sorting_desc");
    if (document.getElementById("sortOrder").value == "ASC") {
        if ("undefined" != typeof frm) {
            $(frm.sortOrder).val("DESC");
        }
        document.getElementById("sortOrder").value = "DESC";
        sortIcn = sortingUp;
        sortcls = "sorting_asc";
    } else {
        if ("undefined" != typeof frm) {
            $(frm.sortOrder).val("ASC");
        }
        document.getElementById("sortOrder").value = "ASC";
        sortIcn = sortingDown;
        sortcls = "sorting_desc";
    }

    $(this).addClass(sortcls);
    searchRecords(frm);
});

$(function () {
    $("#sortable").sortable({
        stop: function () {
            reloadList();
        }
    }).disableSelection();
});

/* Reset result on clear on keyword. */
$(document).on("search", "input[name='keyword']", function () {
    if ("" == $(this).val()) {
        searchRecords(document.frmRecordSearch);
    }
});

$(document).on("click", ".resetModalFormJs", function (e) {
    if (0 > $(".navTabsJs .nav-link").length) {
        $(".navTabsJs .nav-link.active").click();
    } else {
        var onClear = $(".modalFormJs").data("onclear");
        eval(onClear);
    }
});

$(document).on("hidden.bs.modal", "#modalBoxJs", function () {
    $.ykmodal.show();
});

(function () {
    var dv = ".listingRecordJs";
    var paginationDv = ".listingPaginationJs";
    var listingTableJs = ".listingTableJs";

    checkControllerName = function () {
        if ("undefined" == typeof controllerName || "" == controllerName) {
            $.ykmsg.error(langLbl.controllerNameRequired);
            return false;
        }
        return true;
    };

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmRecordSearchPaging;
        $(frm.page).val(page);
        if ("undefined" != typeof document.frmRecordSearch.page) {
            document.frmRecordSearch.page.value = page;
        }
        searchRecords(frm);
    };

    loadMore = function () {
        if (false === checkControllerName()) {
            return false;
        }

        var frm = document.frmLoadMoreRecordsPaging;
        var page = 1;
        if (
            "undefined" != typeof frm.page.value &&
            "" != frm.page.value &&
            0 < frm.page.value
        ) {
            page += parseInt(frm.page.value);
        }

        $(frm.page).val(page);
        var reference = $(".appendRowsJs .rowJs:last").data("reference");
        if (
            "undefined" != typeof reference &&
            "undefined" != typeof frm.reference
        ) {
            $(frm.reference).val(reference);
        }

        var data = fcom.frmData(frm);

        $(".appendRowsJs .rowJs:last")
            .clone()
            .removeAttr("class")
            .addClass("rowJs")
            .appendTo(".appendRowsJs")
            .html(fcom.getRowSpinner());
        fcom.ajax(fcom.makeUrl(controllerName, "getRows"), data, function (rows) {
            $(".appendRowsJs .rowJs:last").remove();
            $(".appendRowsJs").append(rows);

            if (page == frm.pageCount.value) {
                $(".loadMorePaginationJs").remove();
            }
        });
    };

    setPageSize = function (pageSize) {
        var frm = document.frmRecordSearchPaging;
        $(frm.pageSize).val(pageSize);
        reloadList();
    };

    redirectBack = function (redirecrt) {
        window.location = redirecrt;
    };

    reloadList = function () {
        searchRecords(document.frmRecordSearchPaging);
    };

    /* exportReport = function () {
        setColumnsData(document.frmRecordSearch);
        document.frmRecordSearch.action = fcom.makeUrl(controllerName, 'search', ['export']);
        document.frmRecordSearch.submit();
    } */

    searchRecords = function (frm) {
        if (false === checkControllerName()) {
            return false;
        }

        setColumnsData(frm);
        var data = "";
        if (frm) {
            data = fcom.frmData(frm);
        }

        $(listingTableJs).prepend(fcom.getLoader());

        fcom.ajax(fcom.makeUrl(controllerName, "search"), data, function (res) {
            var res = JSON.parse(res);
            if (res.headSection) {
                $('.tableHeadJs').replaceWith(res.headSection);
            }
            $(dv).replaceWith(res.listingHtml);
            $(paginationDv).replaceWith(res.paginationHtml);
            fcom.removeLoader();
            $(".selectAllJs").prop("checked", false);
            if (0 < $(".listingRecordJs .noRecordFoundJs").length) {
                $(".selectAllJs").prop("disabled", "disabled");
            } else {
                $(".selectAllJs").removeAttr("disabled");
            }
        });
    };

    exportRecords = function () {
        if (false === checkControllerName()) {
            return false;
        }
        setColumnsData(document.frmRecordSearch);
        document.frmRecordSearch.action = fcom.makeUrl(controllerName, "search", [
            "export",
        ]);
        document.frmRecordSearch.submit();
    };

    clearSearch = function (loadRowsOnly = false) {
        document.frmRecordSearch.reset();
        $("input:checkbox[name=listingFld]:checked").each(function () {
            if ($(this).attr("disabled") != "disabled") {
                $(this).prop("checked", false);
            }
        });
        searchRecords(document.frmRecordSearch, loadRowsOnly);
        $('.select2-hidden-accessible').val('').trigger('change');
    };

    setColumnsData = function (frm) {
        if ("undefined" == typeof frm) {
            return;
        }

        listingColumns = [];
        $("input:checkbox[name=listingFld]:checked").each(function () {
            listingColumns.push($(this).val());
        });

        $(frm.listingColumns).val(JSON.stringify(listingColumns));
    };

    deleteRecord = function (recordId) {
        if (false === checkControllerName()) {
            return false;
        }

        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        data = "recordId=" + recordId;
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "deleteRecord"),
            data,
            function () {
                reloadList();
            }
        );
    };

    deleteSelected = function () {
        if (!confirm(langLbl.confirmDelete)) {
            return false;
        }
        $("form.actionButtonsJs")
            .attr("action", fcom.makeUrl(controllerName, "deleteSelected"))
            .submit();
    };

    addNew = function (displayInPopup = false, dialogClass = '') {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();

        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        $.ykmodal(fcom.getLoader(), displayInPopup, dialogClass);
        fcom.ajax(fcom.makeUrl(controllerName, "form"), "", function (t) {
            $.ykmodal(t, displayInPopup, dialogClass);
            fcom.removeLoader();
        });
    };

    editRecord = function (recordId, displayInPopup = false, dialogClass = '') {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();
        $.ykmodal(fcom.getLoader(), displayInPopup, dialogClass);
        data = "recordId=" + recordId;
        fcom.ajax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            $.ykmodal(t, displayInPopup, dialogClass);
            fcom.removeLoader();
        });
    };

    editLangData = function (recordId, langId, autoFillLangData = 0) {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();
        $.ykmodal(fcom.getLoader());
        data = "recordId=" + recordId + "&langId=" + langId;
        fcom.ajax(
            fcom.makeUrl(controllerName, "langForm", [autoFillLangData]),
            data,
            function (t) {
                $.ykmodal(t);
                fcom.removeLoader();
            }
        );
    };

    updateStatus = function (e, obj, recordId, status, callback = "") {
        if (false === checkControllerName()) {
            return false;
        }

        e.stopPropagation();
        /* if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return false;
        } */

        var oldStatus = $(obj).attr("data-old-status");
        $(listingTableJs).prepend(fcom.getLoader());

        if (1 > recordId) {
            $(obj).prop("checked", 1 == oldStatus);
            $.ykmsg.error(langLbl.invalidRequest);
            fcom.removeLoader();
            return false;
        }

        data = "recordId=" + recordId + "&status=" + status;
        fcom.ajax(fcom.makeUrl(controllerName, "updateStatus"), data,
            function (res) {
                $(obj).prop("checked", 1 == status);
                var ans = JSON.parse(res);
                if (ans.status == 1) {
                    $.ykmsg.success(ans.msg);
                    $(obj).attr({onclick: "updateStatus(event, this, " + recordId + ", " + oldStatus + ")", "data-old-status": status});
                    if ("" != callback) {
                        eval(callback);
                    } 
                } else {
                    $(obj).prop("checked", 1 == oldStatus);
                    $.ykmsg.error(ans.msg);
                }
                fcom.removeLoader();
            }
        );
    };

    saveRecord = function (frm, callback = '') {
        if (false === checkControllerName()) {
            return false;
        }
        if (!$(frm).validate()) { return; }
        $.ykmodal(fcom.getLoader());

        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controllerName, 'setup'), data, function (res) {
            $("." + $.ykmodal.element + ' .submitBtnJs').removeClass('loading');
            fcom.removeLoader();
            var t = JSON.parse(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
                return false;
            }
            $.ykmsg.success(t.msg);

            reloadList();
            if (t.langId > 0) {
                editLangData(t.recordId, t.langId);
            } else if ("openMediaForm" in t) {
                mediaForm(t.recordId);
            } else if ('' != callback) {
                window[callback](t.recordId);
            }
            return;
        });
    };

    saveLangData = function (frm) {
        if (false === checkControllerName()) {
            return false;
        }
        console.log($(frm).validate());
        if (!$(frm).validate()) {
            return;
        }
        $.ykmodal(fcom.getLoader());

        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controllerName, "langSetup"), data, function (res) {
            fcom.removeLoader();
            var t = JSON.parse(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
                return false;
            }
            $.ykmsg.success(t.msg);
            reloadList();
            if (t.langId > 0) {
                editLangData(t.recordId, t.langId);
            } else if ("openMediaForm" in t) {
                mediaForm(t.recordId);
            }
        });
    };

    selectAll = function (element) {
        var obj = $(element);
        if (0 < $(".listingRecordJs .noRecordFoundJs").length) {
            obj.prop("disabled", "disabled");
            obj.prop("checked", false);
            return false;
        } else {
            obj.removeAttr("disabled");
        }

        var parentForm = obj.closest("form").attr("id");
        $("#" + parentForm + " .selectItemJs").each(function () {
            var tr = $(this).closest('tr');
            if (obj.prop("checked") == false) {
                $(this).prop("checked", false);
                tr.removeClass('selected');
            } else {
                $(this).prop("checked", true);
                tr.addClass('selected');
            }
        });

        showActionsBtns();
    };

    formAction = function (frm, callback) {
        if (typeof $(".selectItemJs:checked").val() === "undefined") {
            $.ykmsg.error(langLbl.atleastOneRecord);
            return false;
        }

        if (0 < $(listingTableJs).length) {
            $(listingTableJs).prepend(fcom.getLoader());
        }

        data = fcom.frmData(frm);

        fcom.displayProcessing();
        fcom.ajax(frm.action, data, function (res) {
            fcom.removeLoader();
            $.ykmsg.close();
            $(".selectAllJs").prop("checked", false);
            callback();
            showActionsBtns();

            var t = JSON.parse(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
            } else {
                $.ykmsg.success(t.msg);
            }
            $(".toolbarBtnJs").addClass("btn-outline-gray disabled").removeClass("btn-outline-brand selected");
        });
    };

    toggleBulkStatues = function (status, msg = "") {
        var element = "form.actionButtonsJs";
        if (1 > $(element).length) {
            $.ykmsg.error(langLbl.actionButtonsClass);
            return false;
        }
        /* msg = "" == msg ? langLbl.confirmUpdateStatus : msg;
        if (!confirm(msg)) {
            return false;
        } */
        $(element).attr("action", fcom.makeUrl(controllerName, "toggleBulkStatuses"));
        $(element + " input[name='status']").val(status);
        $(element).submit();
    };

    showActionsBtns = function () {
        if (typeof $(".selectItemJs:checked").val() === "undefined") {
            $(".toolbarBtnJs").addClass("btn-outline-gray disabled").removeClass("btn-outline-brand selected");
        } else {
            $(".toolbarBtnJs").removeClass("btn-outline-gray disabled").addClass("btn-outline-brand selected");
        }
    };

    /* Media Form & Image Management */
    loadImages = function (recordId, fileType, slide_screen, langId) {
        if (false === checkControllerName()) {
            return false;
        }

        fcom.ajax(
            fcom.makeUrl(controllerName, "images", [
                recordId,
                fileType,
                langId,
                slide_screen,
            ]),
            "",
            function (t) {
                if (fileType == "logo") {
                    $("#logoListingJs").html(t);
                    return;
                }

                $("#imageListingJs").html(t);
            }
        );
    };

    mediaForm = function (recordId, langId = 0, slide_screen = 1) {
        if (false === checkControllerName()) {
            return false;
        }

        $.ykmodal(fcom.getLoader());
        fcom.ajax(
            fcom.makeUrl(controllerName, "media", [recordId, langId, slide_screen]),
            "",
            function (t) {
                fcom.removeLoader();
                loadImages(recordId, "logo", slide_screen, langId);
                loadImages(recordId, "image", slide_screen, langId);
                $.ykmodal(t);
            }
        );
    };

    deleteMedia = function (recordId, fileType, afileId, slide_screen = 0, langId = 0) {
        if (false === checkControllerName()) {
            return false;
        }

        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "removeMedia", [
                recordId,
                fileType,
                afileId,
            ]),
            "",
            function (t) {
                loadImages(recordId, fileType, slide_screen, langId);
                reloadList();
            }
        );
    };

    loadCropperSkeleton = function () {
        $("#modalBoxJs").remove();
        $("body").append(fcom.getModalBody());
        $("#modalBoxJs").modal("show");
        $.ykmodal.close();
    };

    loadImageCropper = function (inputBtn) {
        if (false === checkControllerName()) {
            return false;
        }

        if (inputBtn.files && inputBtn.files[0]) {
            loadCropperSkeleton();
            $("#modalBoxJs .modal-title").text($(inputBtn).attr('data-name'));
            fcom.ajax(fcom.makeUrl(controllerName, "imgCropper"), "", function (t) {
                t = $.parseJSON(t);
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);
                var file = inputBtn.files[0];

                var frmName = $(inputBtn).closest('form').attr('name');
                var minWidth = document[frmName].min_width.value;
                var minHeight = document[frmName].min_height.value;

                if (minWidth == minHeight) {
                    var aspectRatio = 1 / 1;
                } else {
                    var aspectRatio = 16 / 9;
                }
                var options = {
                    aspectRatio: aspectRatio,
                    data: {
                        width: minWidth,
                        height: minHeight,
                    },
                    minCropBoxWidth: minWidth,
                    minCropBoxHeight: minHeight,
                    toggleDragModeOnDblclick: false,
                    imageSmoothingQuality: "high",
                    imageSmoothingEnabled: true,
                };
                $(inputBtn).val("");
                setTimeout(function () { cropImage(file, options, "uploadImages", inputBtn) }, 100);
                return;
            });
        }
    };

    uploadImages = function (formData) {
        if (false === checkControllerName()) {
            return false;
        }
        var frmName = formData.get("frmName");
        var frm = document.forms[frmName];
        var langId = frm.lang_id.value;
        var imageType = frm.file_type.value;
        var callback = "";
        if ("undefined" != typeof frm.dataset.callback) {
            var callback = frm.dataset.callback;
        }

        var slideScreen = 0;
        if ("undefined" != typeof frm.slide_screen) {
            slideScreen = frm.slide_screen.value;
        }

        var other_data = $('form[name="' + frmName + '"]').serializeArray();
        $.each(other_data, function (key, input) {
            formData.append(input.name, input.value);
        });

        $.ajax({
            url: fcom.makeUrl(controllerName, "uploadMedia"),
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.ykmodal(fcom.getLoader());
            },
            success: function (ans) {
                fcom.removeLoader();
                if (ans.status == 0) {
                    $.ykmsg.error(ans.msg);
                    return;
                }
                $.ykmsg.success(ans.msg);
                if (true === $.ykmodal.isAdded()) {
                    $.ykmodal.show();
                    $("#modalBoxJs").modal("hide");
                    if ("" != callback) {
                        eval(callback);
                    } else if (0 < $(".navTabsJs").length && 0 < $("." + $.ykmodal.element + " form[name='" + frm['name'] + "'] select[name='lang_id']").length) {
                        $("." + $.ykmodal.element + " form[name='" + frm['name'] + "'] select[name='lang_id']").val(langId).change();
                    } else if (0 < $(".navTabsJs").length && 0 < $("." + $.ykmodal.element + " form[name='" + frm['name'] + "'] select[name='slide_screen']").length) {
                        $("." + $.ykmodal.element + " form[name='" + frm['name'] + "'] select[name='slide_screen']").change();
                    } else {
                        mediaForm(ans.recordId, imageType, langId, slideScreen);
                    }
                } else {
                    mediaForm(ans.recordId, imageType, langId, slideScreen);
                    reloadList();
                }
                fcom.removeLoader();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $.ykmsg.error(
                    thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText
                );
            },
        });
    };

    isInViewport = function (el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <=
            (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    };

    isElement = function (obj) {
        try {
            //Using W3 DOM2 (works for FF, Opera and Chrome)
            return obj instanceof HTMLElement;
        } catch (e) {
            //Browsers not supporting W3 DOM2 don't have HTMLElement and
            //an exception is thrown and we end up here. Testing some
            //properties that all elements have (works on IE7)
            return (
                typeof obj === "object" &&
                obj.nodeType === 1 &&
                typeof obj.style === "object" &&
                typeof obj.ownerDocument === "object"
            );
        }
    };

    closeForm = function () {
        $.ykmodal.close();
    }

    editDropZoneImages = function (obj) {
        $(obj).closest(".dropzoneContainerJs").find(".dropzoneInputJs").click();
    }

    /* Fix width of table headings. */
    fixTableColumnWidth = function () {
        var thWidthArr = [];
        $('.listingTableJs .tableHeadJs th').each(function () {
            var arr = {
                'width': $(this).width(),
                'element': $(this)
            };
            thWidthArr.push(arr);
        });
        /* Sort By width */
        thWidthArr.sort((a, b) => (a.width > b.width) ? 1 : -1)
        /* Sort By width */

        $.each(thWidthArr, function (index, value) {
            var width = value.width;
            var element = value.element;
            $(element).css({ 'width': width });
        });
    }
})();

$(document).on("click", ".selectItemJs", function () {
    var parentForm = $(this.form).attr("id");
    var tr = $(this).closest('tr');
    if ($(this).prop("checked") == false) {
        $("#" + parentForm + " .selectAllJs").prop("checked", false);
        tr.removeClass('selected');
    } else {
        tr.addClass('selected');
    }

    if ($("#" + parentForm + " .selectItemJs").length == $("#" + parentForm + " .selectItemJs:checked").length) {
        $("#" + parentForm + " .selectAllJs").prop("checked", true);
    }
    showActionsBtns();
});

$(document).ready(function () {
    if (typeof controllerName != 'undefined') {
        getHelpCenterContent(controllerName);
    }
});

$(window).on('load', function () {
    fixTableColumnWidth();
});