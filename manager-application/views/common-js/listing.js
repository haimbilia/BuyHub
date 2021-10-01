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

/* Reset result on clear on keyword. */
$(document).on('search', "input[name='keyword']", function () {
    if ('' == $(this).val()) {
        searchRecords(document.frmRecordSearch, false);
    }
});

(function () {
    var dv = '.listingRecordJs';
    var paginationDv = '.listingPaginationJs';
    var listingTableJs = '.listingTableJs';

    checkControllerName = function () {
        if ('undefined' == typeof controllerName || '' == controllerName) {
            $.ykmsg.error(langLbl.controllerNameRequired);
            return false;
        }
        return true;
    }

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
        if (false === checkControllerName()) {
            return false;
        }

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
            $('.selectAllJs').prop('checked', false);
        });
    };

    exportRecords = function () {
        if (false === checkControllerName()) {
            return false;
        }
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
        if (false === checkControllerName()) {
            return false;
        }

        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        data = 'recordId=' + recordId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'deleteRecord'), data, function () {
            reloadList();
        });
    };

    deleteSelected = function () {
        if (!confirm(langLbl.confirmDelete)) {
            return false;
        }
        $("form.actionButtonsJs").attr("action", fcom.makeUrl(controllerName, 'deleteSelected')).submit();
    };

    addNew = function () {
        if (false === checkControllerName()) {
            return false;
        }

        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, 'form'), '', function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    editRecord = function (recordId) {
        if (false === checkControllerName()) {
            return false;
        }

        $.ykmodal(fcom.getLoader());
        data = 'recordId=' + recordId;
        fcom.ajax(fcom.makeUrl(controllerName, 'form'), data, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    editLangData = function (recordId, langId, autoFillLangData = 0) {
        if (false === checkControllerName()) {
            return false;
        }

        $.ykmodal(fcom.getLoader());
        data = 'recordId=' + recordId + '&langId=' + langId;
        fcom.ajax(fcom.makeUrl(controllerName, 'langForm', [autoFillLangData]), data, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    updateStatus = function (e, obj, recordId, status) {
        if (false === checkControllerName()) {
            return false;
        }

        e.stopPropagation();
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return false;
        }

        var oldStatus = $(obj).attr("data-old-status");
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
                $(obj).attr({ 'onclick': 'updateStatus(event, this, ' + recordId + ', ' + oldStatus + ')', 'data-old-status': status });
            } else {
                $(obj).prop('checked', (1 == oldStatus));
                $.ykmsg.error(ans.msg);
            }
            fcom.removeLoader();
        });
    };

    saveRecord = function (frm) {
        if (false === checkControllerName()) {
            return false;
        }

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
        if (false === checkControllerName()) {
            return false;
        }

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
        $(element).attr('action', fcom.makeUrl(controllerName, 'toggleBulkStatuses'))
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

    /* Media Form & Image Management */
    loadImages = function (recordId, fileType, slide_screen, langId) {
        if (false === checkControllerName()) {
            return false;
        }

        fcom.ajax(fcom.makeUrl(controllerName, 'images', [recordId, fileType, langId, slide_screen]), '', function (t) {
            if (fileType == 'logo') {
                $('#logoListingJs').html(t);
                return;
            }

            $('#imageListingJs').html(t);
        });
    };

    mediaForm = function (recordId, langId = 0, slide_screen = 1) {
        if (false === checkControllerName()) {
            return false;
        }

        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, 'media', [recordId, langId, slide_screen]), '', function (t) {
            fcom.removeLoader();
            loadImages(recordId, 'logo', slide_screen, langId);
            loadImages(recordId, 'image', slide_screen, langId);
            $.ykmodal(t);
        });
    };

    deleteMedia = function (recordId, fileType, afileId) {
        if (false === checkControllerName()) {
            return false;
        }

        if (!confirm(langLbl.confirmDelete)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeMedia', [recordId, fileType, afileId]), '', function (t) {
            loadImages(recordId, fileType, slide_screen, langId);
            reloadList();
        });
    };

    loadImageCropper = function (inputBtn) {
        if (false === checkControllerName()) {
            return false;
        }

        if (inputBtn.files && inputBtn.files[0]) {
            fcom.ajax(fcom.makeUrl(controllerName, 'imgCropper'), '', function (t) {
                $('#cropperBoxJs').html(t);
                $("#mediaFormJs").css("display", "none");
                var file = inputBtn.files[0];
                var minWidth = document.frmRecordImage.min_width.value;
                var minHeight = document.frmRecordImage.min_height.value;
                if (minWidth == minHeight) {
                    var aspectRatio = 1 / 1
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
                    imageSmoothingQuality: 'high',
                    imageSmoothingEnabled: true,
                };
                $(inputBtn).val('');
                return cropImage(file, options, 'uploadImages', inputBtn);
            });
        }
    };

    uploadImages = function (formData) {
        if (false === checkControllerName()) {
            return false;
        }

        var frmName = formData.get("frmName");
        var recordId = document.frmName.record_id.value;
        var langId = document.frmName.lang_id.value;
        var fileType = document.frmName.file_type.value;
        var imageType = document.frmName.file_type.value;
        var ratio_type = $('input[name="ratio_type"]:checked').val();

        formData.append('recordId', recordId);
        formData.append('slide_screen', slideScreen);
        formData.append('lang_id', langId);
        formData.append('file_type', fileType);
        formData.append('ratio_type', ratio_type);
        $.ajax({
            url: fcom.makeUrl(controllerName, 'uploadMedia'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.ykmodal(fcom.getLoader());
            },
            complete: function () {
                $.ykmodal(fcom.getLoader());
            },
            success: function (ans) {
                fcom.removeLoader();
                if (ans.status == 0) {
                    $.ykmsg.error(ans.msg);
                    return;
                }
                $.ykmsg.success(ans.msg);
                mediaForm(ans.recordId, imageType, langId, slideScreen);
                reloadList();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $.ykmsg.error(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
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