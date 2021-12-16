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

        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");
        fcom.ajax(fcom.makeUrl(controllerName, "layoutSelectorForm"), "", function (t) {
            $.ykmodal(t, false, "modal-dialog-vertical-md");
            fcom.removeLoader();
        });
    }

    collectionForm = function (type, layoutType, collection_id = 0) {
        fcom.resetEditorInstance();

        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");
        fcom.ajax(fcom.makeUrl(controllerName, "form", [type, layoutType]), "recordId=" + collection_id, function (t) {
            $.ykmodal(t, false, "modal-dialog-vertical-md");
            fcom.removeLoader();
        });
    };

    recordForm = function (id, type) {
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");
        fcom.ajax(fcom.makeUrl('Collections', 'recordForm', [id, type]), '', function (t) {
            $.ykmodal(t, false, "modal-dialog-vertical-md");
            fcom.removeLoader();
        });
    };

    updateRecord = function (collection_id, recordId) {
        fcom.ajax(fcom.makeUrl(controllerName, 'updateCollectionRecords'), 'collection_id=' + collection_id + '&record_id=' + recordId, function (t) { });
    };

    removeCollectionRecord = function (collection_id, recordId) {
        if (!confirm(langLbl.confirmRemoveProduct)) {
            return false;
        }
        fcom.ajax(fcom.makeUrl(controllerName, 'removeCollectionRecord'), 'collection_id=' + collection_id + '&record_id=' + recordId, function (t) { });
    };

    collectionMediaForm = function (collection_id, type) {
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");
        fcom.ajax(fcom.makeUrl(controllerName, "media", [collection_id, type]), "",
            function (t) {
                fcom.removeLoader();
                $.ykmodal(t, false, "modal-dialog-vertical-md");
                if (0 < $(".displayMediaOnlyJs:checked").val()) {
                    $('.mediaElementsJs').show();
                    loadImages(collection_id);
                } else {
                    $('.mediaElementsJs').hide();
                }
            }
        );
    };

    loadImages = function (recordId, langId = 0) {
        fcom.ajax(fcom.makeUrl(controllerName, 'images', [recordId, langId]), '', function (t) {
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

    displayMediaOnly = function (collectionId, obj) {
        var value = (obj.checked) ? 1 : 0;
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");
        fcom.ajax(fcom.makeUrl(controllerName, 'displayMediaOnly', [collectionId, value]), '', function (t) {
            fcom.removeLoader();
            var ans = $.parseJSON(t);
            if (0 == ans.status) {
                $.ykmsg.error(ans.msg);
                $(obj).prop('checked', false);
                return false
            } else {
                (0 < value) ? $('.mediaElementsJs').show() : $('.mediaElementsJs').hide();
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

    bannerForm = function (collection_id, type, banner_id = 0) {
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");
        fcom.ajax(fcom.makeUrl(controllerName, 'bannerForm', [collection_id, type, banner_id]), '', function (t) {
            $.ykmodal(t, false, "modal-dialog-vertical-md");
            fcom.removeLoader();
        });
    };

    banners = function (collection_id) {
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");
        fcom.ajax(fcom.makeUrl(controllerName, 'banners', [collection_id]), '', function (t) {
            $.ykmodal(t, false, "modal-dialog-vertical-md");
            reloadBannersList(collection_id);
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
            $.ykmsg.error(langLbl.invalidRequest, true);
            return false;
        }
        data = 'bannerId=' + bannerId;
        fcom.ajax(fcom.makeUrl('Banners', 'changeStatus'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                $.ykmsg.success(ans.msg);
                $(obj).toggleClass("active");
            } else {
                $.ykmsg.error(ans.msg, true);
            }
        });
    };
    setupBanners = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setupBanner'), data, function (t) {
            reloadBannersList(t.collection_id);
        });
    }

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
                        $.ykmsg.close();
                        $.ykmsg.error(ans.msg);
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
