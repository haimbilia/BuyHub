$(window).on('load', function () {
    bindSortable();
});

$(document).ajaxComplete(function () {
    bindSortable();
});

$(document).on('change', '.prefDimensionsJs', function () {
    var banner_screen = $(this).val();
    var banner_id = $("input[name='banner_id']").val();
    var collection_id = $("input[name='collection_id']").val();
    var lang_id = $("select[name='lang_id']").val();
    loadBannerImages(collection_id, banner_id, lang_id, banner_screen);
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

    bannerForm = function (collection_id, banner_id = 0) {
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");
        fcom.ajax(fcom.makeUrl(controllerName, 'bannerForm', [collection_id, banner_id]), '', function (t) {
            $.ykmodal(t, false, "modal-dialog-vertical-md");
            fcom.removeLoader();
        });
    };

    bannerLangForm = function (collection_id, banner_id, langId, autoFillLangData = 0) {
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");

        var data = "collection_id=" + collection_id + "&banner_id=" + banner_id + "&langId=" + langId;
        fcom.ajax(fcom.makeUrl(controllerName, 'bannerLangForm', [autoFillLangData]), data, function (t) {
            $.ykmodal(t, false, "modal-dialog-vertical-md");
            fcom.removeLoader();
        });
    };

    banners = function (collection_id) {
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");
        fcom.ajax(fcom.makeUrl(controllerName, 'searchBanners', [collection_id]), '', function (t) {
            $.ykmodal(t, false, "modal-dialog-vertical-md");
            fcom.removeLoader();
        });
    };

    setupBanners = function (frm) {
        if (!$(frm).validate()) { return; }
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");

        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controllerName, 'setupBanner'), data, function (res) {
            $("." + $.ykmodal.element + ' .submitBtnJs').removeClass('loading');
            fcom.removeLoader();
            var t = JSON.parse(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
                return false;
            }
            $.ykmsg.success(t.msg);

            if (t.langId > 0) {
                bannerLangForm(t.collectionId, t.bannerId, t.langId);
            }
            return;
        });
    };

    saveBannerLangData = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");

        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controllerName, "bannerLangSetup"), data, function (res) {
            fcom.removeLoader();
            var t = JSON.parse(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
                return false;
            }
            $.ykmsg.success(t.msg);

            if (t.langId > 0) {
                bannerLangForm(t.collectionId, t.recordId, t.langId);
            } else if ("openMediaForm" in t) {
                bannerMediaForm(t.collectionId, t.recordId);
            }
        });
    };

    bannerMediaForm = function (collectionId, bannerId, langId = 0, slide_screen = 1) {
        $.ykmodal(fcom.getLoader(), false, "modal-dialog-vertical-md");
        fcom.ajax(
            fcom.makeUrl(controllerName, "bannerMedia", [collectionId, bannerId, langId, slide_screen]),
            "",
            function (t) {
                fcom.removeLoader();
                loadBannerImages(collectionId, bannerId, langId, slide_screen);
                $.ykmodal(t, false, "modal-dialog-vertical-md");
            }
        );
    };

    loadBannerImages = function (collectionId, bannerId = 0, langId = 0, screen = 1) {
        if (1 > screen || 'undefined' == typeof screen) {
            screen = $('.prefDimensionsJs').val();
        }
        fcom.ajax(fcom.makeUrl(controllerName, 'bannerImages', [collectionId, bannerId, langId, screen]), '', function (t) {
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

    removeBannerImage = function (recordId, afile_id, lang_id, slide_screen) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.ajax(fcom.makeUrl(controllerName, 'removeBanner', [recordId, afile_id, lang_id, slide_screen]), '', function (t) {
            var ans = $.parseJSON(t);
            if (ans.status == 0) {
                $.ykmsg.error(ans.msg);
                return;
            }

            $.ykmsg.success(ans.msg);
            loadBannerImages(recordId, lang_id);
        });
    }

    toggleBannerStatus = function (e, obj, recordId, status, callback = "") {
        e.stopPropagation();

        var oldStatus = $(obj).attr("data-old-status");
        if (1 > recordId) {
            $(obj).prop("checked", 1 == oldStatus);
            $.ykmsg.error(langLbl.invalidRequest);
            fcom.removeLoader();
            return false;
        }

        data = "bannerId=" + recordId + "&status=" + status;
        fcom.ajax(fcom.makeUrl('Banners', "updateStatus"), data,
            function (res) {
                $(obj).prop("checked", 1 == status);
                var ans = JSON.parse(res);
                if (ans.status == 1) {
                    $.ykmsg.success(ans.msg);
                    $(obj).attr({ onclick: "toggleBannerStatus(event, this, " + recordId + ", " + oldStatus + ")", "data-old-status": status });
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
})();