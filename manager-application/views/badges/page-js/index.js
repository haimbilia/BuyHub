(function () {
    var dv = '#listing';
    var controller = 'Badges';

    loadImages = function (recordId, lang_id) {
        fcom.ajax(fcom.makeUrl(controllerName, 'images', [recordId, lang_id]), '', function (t) {
            var uploadedContentEle = $(".dropzoneContainerJs .dropzoneUploadedJs");
            if (0 < uploadedContentEle.length) {
                uploadedContentEle.remove();
            }

            if ('' != t) {
                $(".dropzoneContainerJs").append(t);
                $(".dropzoneUploadJs").hide();
            } else {
                $(".dropzoneUploadJs").show();
            }
        });
    };

    deleteImage = function (recordId, afile_id, lang_id, slide_screen) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.ajax(fcom.makeUrl(controllerName, 'deleteImage', [recordId, afile_id, lang_id, slide_screen]), '', function (t) {
            var ans = $.parseJSON(t);
            if (ans.status == 0) {
                $.ykmsg.error(ans.msg);
                return;
            }
            
            $.ykmsg.success(ans.msg);
            loadImages(recordId, lang_id);
        });
    }
    /* iconPopupImage = function (inputBtn) {
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
                    reloadList();
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
    }; */

    conditionType = function (element) {
        if ('undefined' == typeof element) {
            return;
        }
        var approvalFld = $("select[name='badge_required_approval']");
        if ("" == $("input[name='badge_id']").val() || condAuto == element.value) {
            approvalFld.val("");
        }
        if (condManual == element.value) {
            approvalFld.attr('data-fatreq', '{"required":true}').removeAttr('disabled');
        } else {
            approvalFld.attr({'data-fatreq' : '{"required":false}', 'disabled': 'disabled'});
        }
    }
})()
