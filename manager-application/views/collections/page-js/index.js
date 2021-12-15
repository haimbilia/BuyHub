$(window).on('load', function () {
    bindSortable();
    $(document).on("click", ".language-js", function () {
        $(".CollectionImages-js li").addClass('d-none');
        $('#Image-' + $(this).val()).removeClass('d-none');
    });
    $(document).on("click", ".bgLanguage-js", function () {
        $(".bgCollectionImages-js li").addClass('d-none');
        $('#bgImage-' + $(this).val()).removeClass('d-none');
    });
});

$(document).ajaxComplete(function () {
    bindSortable();
});

(function () {
    bindSortable = function () {
        if (1 > $('[data-field="dragdrop"]').length) {
            return;
        }
        $(".listingTableJs tbody.listingRecordJs").sortable({
            update: function (event, ui) {
                fcom.displayProcessing();
                $('.listingTableJs').prepend(fcom.getLoader());
                var order = $(this).sortable('toArray');
                var data = '';
                const bindData = new Promise((resolve, reject) => {
                    for (let i = 0; i < order.length; i++) {
                        data += 'collectionList[' + (i + 1) + ']=' + order[i];
                        if (i + 1 < order.length) {
                            data += '&';
                        }
                    }
                    resolve(data);
                });
                bindData.then(
                    function (value) {
                        fcom.ajax(fcom.makeUrl(controllerName, 'updateOrder'), value, function (res) {
                            $.ykmsg.close();
                            fcom.removeLoader();
                            var ans = JSON.parse(res);
                            if (ans.status != 1) {
                                $.ykmsg.error(ans.msg);
                                return;
                            }
                            $.ykmsg.success(ans.msg);
                            reloadList();
                        });
                    },
                    function (error) {
                        fcom.removeLoader();
                        $.ykmsg.close();
                    }
                );
            },
        }).disableSelection();
    };

    layoutSelectorForm = function () {
        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, "layoutSelectorForm"), "", function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    }

    collectionForm = function (type, layoutType, recordId = 0) {
        fcom.resetEditorInstance();

        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, "form", [type, layoutType]), "recordId=" + recordId, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    recordForm = function (id, type) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Collections', 'recordForm', [id, type]), '', function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    updateRecord = function (collection_id, record_id) {
        fcom.ajax(fcom.makeUrl(controllerName, 'updateCollectionRecords'), 'collection_id=' + collection_id + '&record_id=' + record_id, function (t) {});
    };

    removeCollectionRecord = function (collection_id, record_id) {
        if (!confirm(langLbl.confirmRemoveProduct)) {
            return false;
        }
        fcom.ajax(fcom.makeUrl(controllerName, 'removeCollectionRecord'), 'collection_id=' + collection_id + '&record_id=' + record_id, function (t) {});
    };


    /* ----------------------------- */

    getCollectionTypeLayout = function (frm, collectionType, searchForm) {
        callCollectionTypePopulate(collectionType);
        fcom.ajax(fcom.makeUrl(controllerName, 'getCollectionTypeLayout', [collectionType, searchForm]), '', function (t) {
            $("#" + frm + " [name=collection_layout_type]").html(t);
        });
    }

    collectionLayouts = function () {
        fcom.ajax(fcom.makeUrl(controllerName, 'layouts'), '', function (t) {
            fcom.updateFaceboxContent(t, 'content fbminwidth faceboxWidth');
        });
    };
    banners = function (collection_id) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl(controllerName, 'banners', [collection_id]), '', function (t) {
                $.facebox(t, 'faceboxWidth');
                reloadBannersList(collection_id);
            });
        });
    };
    removeBanner = function (fileId, bannerId, langId, screen) {
        if (!confirm(langLbl.confirmDeleteImage)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeBanner', [fileId, bannerId, langId, screen]), '', function (t) {
            $("#banner-image-listing").html('');
            $("[name='banner_image_id[" + langId + "_" + screen + "]']").val('');
        });
    };
    reloadBannersList = function (collection_id) {
        $("#banners_list-js").html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, 'searchBanners', [collection_id]), '', function (t) {
            $("#banners_list-js").html(t);
        });
    };
    toggleBannerStatus = function (e, obj, canEdit) {
        if (canEdit == 0) {
            e.preventDefault();
            return;
        }
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return;
        }
        var bannerId = parseInt(obj.value);
        if (bannerId < 1) {
            $.mbsmessage(langLbl.invalidRequest, true, 'alert--danger');
            return false;
        }
        data = 'bannerId=' + bannerId;
        fcom.ajax(fcom.makeUrl('Banners', 'changeStatus'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                $.mbsmessage(ans.msg, true, 'alert--success');
                $(obj).toggleClass("active");
            } else {
                $.mbsmessage(ans.msg, true, 'alert--danger');
            }
        });
    };
    bannerForm = function (collection_id, banner_id) {
        fcom.ajax(fcom.makeUrl(controllerName, 'bannerForm', [collection_id, banner_id]), '', function (t) {
            $("#banners_list-js").html(t);
            bannerImages(collection_id, banner_id, 0, 1);
        });
    };
    setupBanners = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setupBanner'), data, function (t) {
            reloadBannersList(t.collection_id);
        });
    }

    collectionMediaForm = function (recordId) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(
            fcom.makeUrl(controllerName, "media", [recordId]),
            "",
            function (t) {
                fcom.removeLoader();
                $.ykmodal(t);
                var parentSiblings = $(".displayMediaOnly--js").closest("div.row").siblings('div.row:not(:first)');
                if (0 < $(".displayMediaOnly--js:checked").val()) {
                    parentSiblings.show();
                    loadImages(recordId, "image", slide_screen, langId);
                } else {
                    parentSiblings.hide();
                }
            }
        );
    };

    removeCollectionImage = function (collectionId, langId) {
        if (!confirm(langLbl.confirmDeleteImage)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeImage', [collectionId, langId]), '', function (t) {
            collectionMediaForm(collectionId);
        });
    };
    removeCollectionBGImage = function (collectionId, langId) {
        if (!confirm(langLbl.confirmDeleteImage)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'removeBgImage', [collectionId, langId]), '', function (t) {
            collectionMediaForm(collectionId);
        });
    };

    callCollectionTypePopulate = function (val) {
        if (val == 1) {
            $("#collection_criteria_div").show();
        } else {
            $("#collection_criteria_div").hide();
        }
    };

    displayMediaOnly = function (collectionId, obj) {
        var parentSiblings = $(obj).closest("div.row").siblings('div.row:not(:first)');
        var value = (obj.checked) ? 1 : 0;
        fcom.ajax(fcom.makeUrl(controllerName, 'displayMediaOnly', [collectionId, value]), '', function (t) {
            var ans = $.parseJSON(t);
            if (0 == ans.status) {
                $.systemMessage(ans.msg, 'alert--danger');
                $(obj).prop('checked', false);
                return false
            } else {
                (0 < value) ? parentSiblings.show() : parentSiblings.hide();
            }
        });
    };
    popupImage = function (inputBtn) {
        if (inputBtn.files && inputBtn.files[0]) {
            fcom.ajax(fcom.makeUrl(controllerName, 'imgCropper'), '', function (t) {
                $('#cropperBox-js').html(t);
                $("#mediaForm-js").css("display", "none");
                var file = inputBtn.files[0];
                var minWidth = document.frmCollectionMedia.min_width.value;
                var minHeight = document.frmCollectionMedia.min_height.value;
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
        var collection_id = document.frmCollectionMedia.collection_id.value;
        var langId = document.frmCollectionMedia.image_lang_id.value;
        var fileType = document.frmCollectionMedia.file_type.value;
        formData.append('collection_id', collection_id);
        formData.append('file_type', fileType);
        formData.append('lang_id', langId);
        $.ajax({
            url: fcom.makeUrl(controllerName, 'uploadImage'),
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
                if (0 == ans.status) {
                    $.mbsmessage.close();
                    $.systemMessage(ans.msg, 'alert--danger');
                } else {
                    collectionMediaForm(ans.collection_id);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    translateData = function (item) {
        var autoTranslate = $("input[name='auto_update_other_langs_data']:checked").length;
        var defaultLang = $(item).attr('defaultLang');
        var collectionName = $("input[name='collection_name[" + defaultLang + "]']").val();
        var toLangId = $(item).attr('language');
        var alreadyOpen = $('#collapse_' + toLangId).hasClass('active');
        if (autoTranslate == 0 || collectionName == "" || alreadyOpen == true) {
            return false;
        }
        if ($("textarea[name='epage_content_" + defaultLang + "']").length > 0) {
            var oEdit = eval(oUtil.arrEditor[0]);
            var epageContent = oEdit.getTextBody();
            var data = "collectionName=" + collectionName + "&epageContent=" + epageContent + "&toLangId=" + toLangId;
        } else {
            var data = "collectionName=" + collectionName + "&toLangId=" + toLangId;
        }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'translatedData'), data, function (t) {
            if (t.status == 1) {
                $("input[name='collection_name[" + toLangId + "]']").val(t.collectionName);
                if ($("textarea[name='epage_content_" + toLangId + "']").length > 0) {
                    var oEdit1 = eval(oUtil.arrEditor[toLangId - 1]);
                    oEdit1.putHTML(t.epageContent);
                    var layout = langLbl['language' + toLangId];
                    $('#idContent' + oUtil.arrEditor[toLangId - 1]).contents().find("body").css('direction', layout);
                    $('#idArea' + oUtil.arrEditor[toLangId - 1] + ' td[dir="ltr"]').attr('dir', layout);
                }
            }
        });
    }
    translateBannerData = function (item) {
        var autoTranslate = $("input[name='auto_update_other_langs_data']:checked").length;
        var defaultLang = $(item).attr('defaultLang');
        var title = $("input[name='banner_title[" + defaultLang + "]']").val();
        var toLangId = $(item).attr('language');
        var alreadyOpen = $('#collapse_' + toLangId).hasClass('active');
        if (autoTranslate == 0 || title == "" || alreadyOpen == true) {
            return false;
        }
        var data = "collectionName=" + title + "&toLangId=" + toLangId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'translatedData'), data, function (t) {
            if (t.status == 1) {
                $("input[name='banner_title[" + toLangId + "]']").val(t.collectionName);
            }
        });
    }
    bannerImages = function (collectionId, bannerId = 0, langId = 0, screen = 0) {
        fcom.ajax(fcom.makeUrl(controllerName, 'bannerImages', [collectionId, bannerId, langId, screen]), '', function (t) {
            $('#banner-image-listing').html(t);
            var bannerImageId = $("#banner-image-listing li").attr('id');
            var selectedLangId = $(".banner-language-js").val();
            var screen = $(".prefDimensions-js").val();
            $("[name='banner_image_id[" + selectedLangId + "_" + screen + "]']").val(bannerImageId);
            fcom.resetFaceboxHeight();
        });
    };
    bannerPopupImage = function (inputBtn) {
        if (inputBtn.files && inputBtn.files[0]) {
            fcom.ajax(fcom.makeUrl(controllerName, 'imgCropper'), '', function (t) {
                $('#cropperBox-js').html(t);
                $("#mediaForm-js").css("display", "none");
                var file = inputBtn.files[0];
                var minWidth = document.frmBanner.banner_min_width.value;
                var minHeight = document.frmBanner.banner_min_height.value;
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
                return cropImage(file, options, 'uploadBannerImages', inputBtn);
            });
        }
    };
    uploadBannerImages = function (formData) {
        var frmName = formData.get("frmName");
        var collectionId = $("[name='collection_id']").val();
        var bannerId = $("[name='banner_id']").val();
        var blocationId = $("[name='blocation_id']").val();
        var langId = $("[name='banner_lang_id']").val();
        var bannerScreen = $("[name='banner_screen']").val();
        var afileId = $("#banner-image-listing li").attr('id');
        formData.append('banner_id', bannerId);
        formData.append('blocation_id', blocationId);
        formData.append('banner_screen', bannerScreen);
        formData.append('lang_id', langId);
        formData.append('afile_id', afileId);
        $.ajax({
            url: fcom.makeUrl(controllerName, 'setupBannerImage'),
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
                    $('#cropperBox-js').html('');
                    $("#mediaForm-js").css("display", "block");
                    fcom.displaySuccessMessage(ans.msg);
                    bannerImages(collectionId, bannerId, langId, bannerScreen);
                } else {
                    fcom.displayErrorMessage(ans.msg);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    deleteImage = function (fileId, prodcatId, imageType, langId, slide_screen) {
        if (!confirm(langLbl.confirmDeleteImage)) { return; }
        fcom.updateWithAjax(fcom.makeUrl('productCategories', 'removeImage', [fileId, prodcatId, imageType, langId, slide_screen]), '', function (t) {
            $("#banner-image-listing").html('');
            $("[name='banner_image_id[" + langId + "_" + slide_screen + "]']").val('');
        });
    };
})();
$(document).on('change', '.prefDimensions-js', function () {
    var banner_screen = $(this).val();
    var banner_id = $("input[name='banner_id']").val();
    var collection_id = $("input[name='collection_id']").val();
    var lang_id = $(".banner-language-js").val();
    var imageId = $("[name='banner_image_id[" + lang_id + "_" + banner_screen + "]']").val();
    if (banner_id == 0) {
        if (imageId > 0) {
            bannerImages(collection_id, banner_id, lang_id, banner_screen);
        } else {
            $("#banner-image-listing").html('');
        }
    } else {
        bannerImages(collection_id, banner_id, lang_id, banner_screen);
    }
});
$(document).on('change', '.banner-language-js', function () {
    var lang_id = $(this).val();
    var banner_id = $("input[name='banner_id']").val();
    var collection_id = $("input[name='collection_id']").val();
    var banner_screen = $("input[name='banner_screen']").val();
    var imageId = $("[name='banner_image_id[" + lang_id + "_" + banner_screen + "]']").val();
    if (banner_id == 0) {
        if (imageId > 0) {
            bannerImages(collection_id, banner_id, lang_id, banner_screen);
        } else {
            $("#banner-image-listing").html('');
        }
    } else {
        bannerImages(collection_id, banner_id, lang_id, banner_screen);
    }
});
/* $(document).on('change','.banner-language-js',function(){
    var langId = $(this).val();
    var bannerId = $("input[name='banner_id']").val();
    var blocationId = $("input[name='blocation_id']").val();
    var screen = $(".display-js").val();
    images(blocationId,bannerId,langId,screen);
}); */
$(document).on('click', '.File-Js', function () {
    var node = this;
    $('#form-upload').remove();
    var fileType = $(node).attr('data-file_type');
    var collection_id = $(node).attr('data-collection_id');
    if (fileType == FILETYPE_COLLECTION_IMAGE) {
        var langId = document.frmCollectionMedia.image_lang_id.value;
    } else if (fileType == FILETYPE_COLLECTION_BG_IMAGE) {
        var langId = document.frmCollectionMedia.bg_image_lang_id.value;
    }
    var frm = '<form enctype="multipart/form-data" id="form-upload" style="position:absolute; top:-100px;" >';
    frm = frm.concat('<input type="file" name="file" />');
    frm = frm.concat('<input type="hidden" name="file_type" value="' + fileType + '">');
    frm = frm.concat('<input type="hidden" name="collection_id" value="' + collection_id + '">');
    frm = frm.concat('<input type="hidden" name="lang_id" value="' + langId + '">');
    frm = frm.concat('</form>');
    $('body').prepend(frm);
    $('#form-upload input[name=\'file\']').trigger('click');
    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }
    timer = setInterval(function () {
        if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);
            $val = $(node).val();
            $.ajax({
                url: fcom.makeUrl(controllerName, 'uploadImage'),
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(node).val('Loading');
                },
                complete: function () {
                    $(node).val($val);
                },
                success: function (ans) {
                    if (0 == ans.status) {
                        $.mbsmessage.close();
                        $.systemMessage(ans.msg, 'alert--danger');
                    } else {
                        collectionMediaForm(ans.collection_id);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
});
(function () {
    displayImageInFacebox = function (title, url) {
        loadCropperSkeleton();

        $("#modalBoxJs .modal-title").text(title);
        $("#modalBoxJs .modal-body").html('<img class="mx-auto d-block" width="800px;" src="' + url + '">');
    }
})();
