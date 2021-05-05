$(document).ready(function () {
    searchRecords(document.frmSearch);

});

$(document).on('change', '.icon-language-js', function () {
    var badge_id = $("input[name='badge_id']").val();
    if ('' == badge_id) { badge_id = 0; }
    badgeImages(badge_id, 'icon', 0, $(this).val());
});

(function () {
    var dv = '#listing';
    var controller = 'Badges';

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

    form = function (badge_id, type) {
        fcom.ajax(fcom.makeUrl(controller, 'form', [badge_id, type]), '', function (t) {
            $('.pagebody--js').hide();
            $('.editRecord--js').html(t);
            if ('' != $("input[name='badge_id']").val()) {
                var badge_id = $("input[name='badge_id']").val();
                if ('' == badge_id) { badge_id = 0; }
                badgeImages(badge_id, 'icon', 0, $('.icon-language-js').val());
            }
        });
    };

    backToListing = function () {
        $('.editRecord--js').html("");
        $('.pagebody--js').fadeIn();
    }

    setup = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controller, 'setup'), data, function (t) {
            reloadList();
            // form(t.badge_id, t.badge_type);
            backToListing();
        });
    };

    clearSearch = function () {
        document.frmSearch.reset();
        searchRecords(document.frmSearch);
        $('.searchHead--js').click();
    };

    toggleStatus = function (e, obj, status) {
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return;
        }
        var badge_id = parseInt(obj.value);
        if (badge_id < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'badge_id=' + badge_id + '&badge_active=' + status;
        fcom.ajax(fcom.makeUrl(controller, 'changeStatus'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
                $(obj).toggleClass("active");
                $(obj).attr('onclick', 'toggleStatus(event,this,' + (status ? 0 : 1) + ')');
            } else {
                $(obj).prop('checked', (1 != status));
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

    translateData = function (item) {
        var autoTranslate = $("input[name='auto_update_other_langs_data']:checked").length;
        var defaultLang = $(item).attr('defaultLang');
        var badge_name = $("input[name='badge_name[" + defaultLang + "]']").val();
        var toLangId = $(item).attr('language');
        var alreadyOpen = $('#collapse_' + toLangId).hasClass('active');
        if (autoTranslate == 0 || badge_name == "" || alreadyOpen == true) {
            return false;
        }

        if ('' != $("input[name='badge_name[" + toLangId + "]']").val()) {
            return false;
        }

        var data = "badge_name=" + badge_name + "&toLangId=" + toLangId;
        fcom.updateWithAjax(fcom.makeUrl(controller, 'translatedCategoryData'), data, function (t) {
            if (t.status == 1) {
                $("input[name='badge_name[" + toLangId + "]']").val(t.badge_name);
            }
            $.systemMessage.close();
        });
    }

    deleteSelected = function () {
        if (1 > $('.selectItem--js:checked').length) {
            fcom.displayErrorMessage(langLbl.atleastOneRecord);
            return;
        }
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }
        $('.badgesList--js').attr('action', fcom.makeUrl(controller, 'deleteSelected')).submit();
    }

    deleteRecord = function (e, badge_id) {
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }

        if (badge_id < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'badgeIds[]=' + badge_id;
        fcom.ajax(fcom.makeUrl(controller, 'deleteSelected'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                reloadList();
                fcom.displaySuccessMessage(ans.msg);
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

    iconPopupImage = function (inputBtn) {
        if (inputBtn.files && inputBtn.files[0]) {
            fcom.ajax(fcom.makeUrl(controller, 'imgCropper'), '', function (t) {
                $.facebox(t, 'faceboxWidth');
                var file = inputBtn.files[0];
                var minWidth = $('input[name="logo_min_width"]').val();
                var minHeight = $('input[name="logo_min_height"]').val();
                var options = {
                    aspectRatio: 1 / 1,
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
                return cropImage(file, options, 'uploadBadgeImages', inputBtn);
            });
        }
    };

    uploadBadgeImages = function (formData) {
        var frmName = formData.get("frmName");
        var slideScreen = 0;
        var badgeId = $("[name='badge_id']").val();
        if ('' == badgeId) { badgeId = 0; }
        var badgeType = $("[name='badge_type']").val();
        var afileId = $("#icon-image-listing li").attr('id');
        var langId = $("[name='icon_lang_id']").val();
        var fileType = $("[name='icon_file_type']").val();
        var imageType = 'icon';

        formData.append('badge_id', badgeId);
        formData.append('badge_type', badgeType);
        formData.append('slide_screen', slideScreen);
        formData.append('lang_id', langId);
        formData.append('file_type', fileType);
        formData.append('afile_id', afileId);
        $.ajax({
            url: fcom.makeUrl(controller, 'setUpImages'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#loader-js').html(fcom.getLoader());
            },
            complete: function () {
                $('#loader-js').html(fcom.getLoader());
            },
            success: function (ans) {
                if (ans.status == 1) {
                    fcom.displaySuccessMessage(ans.msg);
                    var langId = $('.icon-language-js').val();
                    var JSONObj = { [langId]: ans.attachFileId };

                    var attachmentIds = $('input[name="attachment_ids"]').val();
                    if ('' != attachmentIds) {
                        JSONObj = JSON.parse(attachmentIds);
                        JSONObj[langId] = ans.attachFileId;
                    }
                    $('input[name="attachment_ids"]').val(JSON.stringify(JSONObj));

                    badgeImages(badgeId, imageType, slideScreen, langId);
                } else {
                    fcom.displayErrorMessage(ans.msg);
                }
                $(document).trigger('close.facebox');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    badgeImages = function (badge_id, imageType, slide_screen, lang_id) {
        fcom.ajax(fcom.makeUrl(controller, 'images', [badge_id, imageType, lang_id, slide_screen]), '', function (t) {
            $('.uploadedImage--js').replaceWith(t);
        });
    };

    deleteImage = function (fileId, badge_id, imageType, langId, slide_screen) {
        if (!confirm(langLbl.confirmDeleteImage)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controller, 'removeImage', [fileId, badge_id, imageType, langId, slide_screen]), '', function (t) {
            $('.uploadedImage--js').html('');
            var attachmentIds = $('input[name="attachment_ids"]').val();
            if ('' != attachmentIds) {
                JSONObj = JSON.parse(attachmentIds);
                delete JSONObj[langId];
                $('input[name="attachment_ids"]').val(JSON.stringify(JSONObj));
            }
        });
    };
})()
