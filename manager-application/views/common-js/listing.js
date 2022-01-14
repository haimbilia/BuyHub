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
    });
});

/* Reset result on clear(cross) icon on keyword search field. */
$(document).on("search", "input[name='keyword']", function () {
    if ("" == $(this).val()) {
        searchRecords(document.frmRecordSearch);
    }
});

$(document).on("click", ".resetModalFormJs", function (e) {
    if ($.ykmodal.isSideBarView()) {
        $.ykmodal(fcom.getLoader());
    }
    if (0 > $(".navTabsJs .nav-link").length) {
        $(".navTabsJs .nav-link.active").click();
    } else {
        var onClear = $(".modalFormJs").data("onclear");
        eval(onClear);
    }
});

$(document).on("click", ".clearFormJs", function (e) {
    var form = $(this).closest('form');
    form[0].reset();
});

$(document).on("click", ".submitFormBtnJs", function (e) {
    $(this).closest('form').submit();
});

/* Sidebar auto open if accidently close modal popup. Retain previous position. */
var autoOpenSideBar = true;
$(document).on("hidden.bs.modal", "#modalBoxJs", function () {
    if (autoOpenSideBar) {
        $.ykmodal.show();
    }
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
        /* if ("undefined" != typeof document.frmRecordSearch.page) {
            document.frmRecordSearch.page.value = 1;
        } */
        searchRecords(frm);
    };

    loadMore = function () {
        if (false === checkControllerName()) {
            return false;
        }

        var frm = document.frmLoadMoreRecordsPaging;
        var page = 1;
        if ("undefined" != typeof frm.page.value && "" != frm.page.value && 0 < frm.page.value) {
            page += parseInt(frm.page.value);
        }

        $(frm.page).val(page);
        var reference = $(".appendRowsJs .rowJs:last").data("reference");
        if ("undefined" != typeof reference && "undefined" != typeof frm.reference) {
            $(frm.reference).val(reference);
        }

        var data = fcom.frmData(frm);

        var loadMoreBtn = $('.loadMoreBtnJs');
        var btnText = loadMoreBtn.text();
        loadMoreBtn.html(fcom.getRowSpinner());

        fcom.updateWithAjax(fcom.makeUrl(controllerName, "getRows"), data, function (rows) {
            $.ykmsg.close();
            $(".appendRowsJs").append(rows.html);
            loadMoreBtn.html(btnText);

            var similarElement = '.appendRowsJs [data-reference="' + reference + '"]';
            var lastSimilar = $(similarElement + ':last');
            if (1 < $(similarElement).length) {
                var li = lastSimilar.find('.ulJs').html();
                lastSimilar.remove();
                $(similarElement + ':last ul.ulJs').append(li);
            }

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

        fcom.updateWithAjax(fcom.makeUrl(controllerName, "search"), data, function (res) {
            $.ykmsg.close();
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
        $(':input', document.frmRecordSearch).not(':hidden').val('');
        $("input:checkbox[name=listingFld]:checked").each(function () {
            if ($(this).attr("disabled") != "disabled") {
                $(this).prop("checked", false);
            }
        });
        $('.select2-hidden-accessible').val('').trigger('change');
        searchRecords(document.frmRecordSearch, loadRowsOnly);

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

        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), "", function (t) {
            $.ykmodal(t.html, displayInPopup, dialogClass);
            $.ykmsg.close();
            fcom.removeLoader();
        });
    };

    editRecord = function (recordId, displayInPopup = false, dialogClass = '') {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();
        data = "recordId=" + recordId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            $.ykmodal(t.html, displayInPopup, dialogClass);
            $.ykmsg.close();
            fcom.removeLoader();
        });
    };

    editLangData = function (recordId, langId, autoFillLangData = 0) {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();
        data = "recordId=" + recordId + "&langId=" + langId;
        var isPopupView = ($.ykmodal.isAdded() && !$.ykmodal.isSideBarView());

        $.ykmodal(fcom.getLoader(), isPopupView);
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "langForm", [autoFillLangData]),
            data,
            function (t) {
                $.ykmodal(t.html, isPopupView);
                fcom.removeLoader();
                $.ykmsg.close();
            }
        );
    };

    updateStatus = function (e, obj, recordId, status, callback = "") {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.displayProcessing();
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
                $.ykmsg.close();
                $(obj).prop("checked", 1 == status);
                var ans = JSON.parse(res);
                if (ans.status == 1) {
                    $.ykmsg.success(ans.msg);
                    $(obj).attr({ onclick: "updateStatus(event, this, " + recordId + ", " + oldStatus + ")", "data-old-status": status });
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
        $.ykmodal(fcom.getLoader(), !$.ykmodal.isSideBarView());

        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {
            $("." + $.ykmodal.element + ' .submitBtnJs').removeClass('loading');
            fcom.removeLoader();
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
        if (!$(frm).validate()) {
            return;
        }
        $.ykmodal(fcom.getLoader(), !$.ykmodal.isSideBarView());

        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "langSetup"), data, function (t) {
            fcom.removeLoader();
            $.ykmsg.success(t.msg);

            if (t.langId == langLbl.defaultFormLangId) {
                reloadList();
            }

            if (t.langId > 0) {
                editLangData(t.recordId, t.langId);
            } else if ("openMediaForm" in t) {
                mediaForm(t.recordId);
            }
        });
    };

    selectAll = function (element) {
        var obj = $(element);
        if (1 > $(".listingRecordJs .selectItemJs:not(:disabled)").length) {
            obj.prop("disabled", "disabled");
            obj.prop("checked", false);
            return false;
        } else {
            obj.removeAttr("disabled");
        }

        $(".listingRecordJs .selectItemJs").each(function () {
            var tr = $(this).closest('tr');
            if (obj.prop("checked") == false) {
                $(this).prop("checked", false);
                tr.removeClass('selected');
            } else if (!$(this).hasClass('disabled')) {
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

        fcom.updateWithAjax(frm.action, data, function (t) {
            fcom.removeLoader();
            $.ykmsg.close();
            $(".selectAllJs").prop("checked", false);
            callback();
            showActionsBtns();
            $.ykmsg.success(t.msg);
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

        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "images", [recordId, fileType, langId, slide_screen]), "",
            function (t) {
                fcom.removeLoader();
                $.ykmsg.close();
                if (fileType == "logo") {
                    $("#logoListingJs").html(t.html);
                    return;
                }

                $("#imageListingJs").html(t.html);
            }
        );
    };

    mediaForm = function (recordId, langId = 0, slide_screen = 1) {
        if (false === checkControllerName()) {
            return false;
        }

        fcom.updateWithAjax(fcom.makeUrl(controllerName, "media", [recordId, langId, slide_screen]), "",
            function (t) {
                fcom.removeLoader();
                $.ykmsg.close();
                loadImages(recordId, "logo", slide_screen, langId);
                loadImages(recordId, "image", slide_screen, langId);
                $.ykmodal(t.html, !$.ykmodal.isSideBarView());
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

    loadCropperSkeleton = function (reopenSideBarOnClose = true) {
        autoOpenSideBar = reopenSideBarOnClose;
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
            fcom.updateWithAjax(fcom.makeUrl(controllerName, "imgCropper"), "", function (t) {
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
                setTimeout(function () {
                    cropImage(file, options, "uploadImages", inputBtn);
                }, 100);
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
        var langId = 0;
        if ('undefined' != typeof frm.lang_id) {
            langId = frm.lang_id.value;
        }
        var slideScreen = 0;
        if ("undefined" != typeof frm.slide_screen) {
            slideScreen = frm.slide_screen.value;
        }

        var action = 'uploadMedia';
        if ("undefined" != typeof frm.dataset.action) {
            action = frm.dataset.action;
        }

        var other_data = $('form[name="' + frmName + '"]').serializeArray();
        $.each(other_data, function (key, input) {
            formData.append(input.name, input.value);
        });

        formData.append('fOutMode', 'json');
        $.ajax({
            url: fcom.makeUrl(controllerName, action),
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#modalBoxJs .modal-body").prepend(fcom.getLoader());
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
                    if ("undefined" != typeof frm.dataset.callback) {
                        eval(frm.dataset.callback);
                    } else if ("undefined" != typeof frm.dataset.callbackfn) {
                        window[frm.dataset.callbackfn](ans); /* callback function */
                    } else if (0 < $(".navTabsJs").length && 0 < $("." + $.ykmodal.element + " form[name='" + frm['name'] + "'] select[name='lang_id']").length) {
                        $("." + $.ykmodal.element + " form[name='" + frm['name'] + "'] select[name='lang_id']").val(langId).change();
                    } else if (0 < $(".navTabsJs").length && 0 < $("." + $.ykmodal.element + " form[name='" + frm['name'] + "'] select[name='slide_screen']").length) {
                        $("." + $.ykmodal.element + " form[name='" + frm['name'] + "'] select[name='slide_screen']").change();
                    } else {
                        mediaForm(ans.recordId, frm.file_type.value, langId, slideScreen);
                    }
                } else {
                    mediaForm(ans.recordId, frm.file_type.value, langId, slideScreen);
                }
                reloadList();
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
        var autoTableColumWidth = $('.listingTableJs').data('autoColumnWidth');
        if (1 > autoTableColumWidth) {
            return false;
        }

        $('.listingTableJs .tableHeadJs th').each(function () {
            var arr = {
                'width': $(this).outerWidth(true),
                'element': $(this)
            };
            thWidthArr.push(arr);
        });
        /* Sort By width */
        thWidthArr.sort((a, b) => (a.width > b.width) ? 1 : -1)
        /* Sort By width */

        /* let isSortableTable = 0 < $(".listingTableJs .listingRecordJs .handleJs").length; */

        $.each(thWidthArr, function (index, value) {
            var width = value.width;
            var element = value.element;
            $(element).attr('width', width);

            /* Not required for drag drop functionality. */
            /* if (isSortableTable) {
                $(".listingTableJs .listingRecordJs tr td:nth-child(" + (value.element.index() + 1) + ")").attr('width', width);
            } */
        });
    }

    fixWidthHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    }

    fixPlaceholderStyle = function (e, ui) {
        ui.placeholder.height(ui.item.height());
        ui.placeholder.css("visibility", "visible");
        ui.placeholder.css('background-color', '#f3f6f9');
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

/* $(document).ready(function () {
    if (typeof controllerName != 'undefined') {
        getHelpCenterContent(controllerName);
    }
}); */

$(window).on('load', function () {
    fixTableColumnWidth();
});