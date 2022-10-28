
$(document).on('change', '.logo-language-js', function () {
    var lang_id = $(this).val();
    shopImages('logo', 0, lang_id);
});
$(document).on('change', '.banner-language-js', function () {
    var lang_id = $(this).val();
    var slide_screen = $(".prefDimensions-js").val();
    shopImages('banner', slide_screen, lang_id);
});
$(document).on('change', '.prefDimensions-js', function () {
    var slide_screen = $(this).val();
    var lang_id = $(".banner-language-js").val();
    shopImages('banner', slide_screen, lang_id);
});
$(document).on('change', '.bg-language-js', function () {
    var lang_id = $(this).val();
    shopImages('bg', 0, lang_id);
});
$(document).on('change', '.collection-language-js', function () {
    var lang_id = $(this).val();
    var scollection_id = document.frmCollectionMedia.scollection_id.value;
    shopCollectionImages(scollection_id, lang_id);
});

$(document).on("change", "select[name='business_type']", function () {
    requiredFieldsForm();
});

$(document).on("change", ".country", function () {
    if ('' == $(this).val()) {
        return;
    }
    $state = $(this).data("statefield");
    $("." + $state).removeAttr("disabled");
    getStatesByCountryCode($(this).val(), 0, "." + $state, 'state_code');
});

$(document).on("change", ".state", function () {
    $(this).removeAttr("disabled");
});

(function () {
    var runningAjaxReq = false;
    var dv = '#shopFormBlock';
    var dvt = '#shopFormChildBlockJs';

    var mtabId = '#shopMainBlockTabsJs';
    var ctabId = '#shopFormChildBlockTabsJs';

    checkRunningAjax = function () {
        if (runningAjaxReq == true) {
            //console.log(runningAjaxMsg);
            return;
        }
        runningAjaxReq = true;
    };

    goToCategoryBannerSrchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmCategoryBannerSrchPaging;
        $(frm.page).val(page);
        searchCategoryBanners(frm);
    };

    categoryBanners = function () {
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'searchCategoryBanners'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
        });
    };

    addCategoryBanner = function (prodCatId) {
        fcom.ajax(fcom.makeUrl('Seller', 'addCategoryBanner', [prodCatId]), '', function (t) {
            $.ykmodal(t);
        });
    };

    searchCategoryBanners = function (frm) {
        /*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
        var data = fcom.frmData(frm);
        /*]*/
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'searchCategoryBanners'), data, function (res) {
            fcom.removeLoader();
            $(dv).html(res);
        });
    };

    reloadCategoryBannerList = function () {
        searchCategoryBanners(document.frmCategoryBannerSrchPaging);
    };

    removeCategoryBanner = function (prodCatId, lang_id) {
        var agree = confirm(langLbl.confirmRemove);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'removeCategoryBanner', [prodCatId, lang_id]), '', function (t) {
            reloadCategoryBannerList();
            addCategoryBanner(prodCatId);
        });
    };

    shopForm = function (tab = '') {
        markMainTabActive();
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'shopForm', [tab]), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
            if ('' != tab) {
                $('.' + tab).click();
                var url = self.location.href;
                url = url.replace(tab, '');
                window.history.pushState("", "", url);
            }
        });
    };

    setupShop = function (frm) {
        if (!$(frm).validate()) { return; }
        checkRunningAjax();
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setupShop'), data, function (t) {
            runningAjaxReq = false;
            $(mtabId).attr('data-shop_id', t.shopId);
            if (t.langId > 0) {
                shopLangForm(t.shopId, t.langId);
                return;
            }
            shopForm();
            return;
        });
    };

    shopLangForm = function (shopId, langId, autoFillLangData = 0) {
        shopId = shopId || $(mtabId).data('shop_id');
        if (shopId < 0 || typeof (shopId) == "undefined") {
            return;
        }

        markMainTabActive();
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'shopLangForm', [shopId, langId, autoFillLangData]), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
            fcom.setEditorLayout(langId);
        });
    };

    setupShopLang = function (frm) {
        if (!$(frm).validate()) { return; }
        checkRunningAjax();
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setupShopLang'), data, function (t) {
            fcom.removeLoader();
            runningAjaxReq = false;
            if (t.langId > 0 && t.shopId > 0) {
                shopLangForm(t.shopId, t.langId);
                return;
            }
            getReturnAddress();
        });
    };

    shopMediaForm = function () {
        if (1 > $(mtabId).data('shop_id')) {
            return;
        }
        markMainTabActive();
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'shopMediaForm'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
            shopImages('logo');
            shopImages('banner', 1);
            shopImages('bg');
        });
    };

    shopImages = function (imageType, slide_screen, lang_id) {
        fcom.ajax(fcom.makeUrl('Seller', 'shopImages', [imageType, lang_id, slide_screen]), '', function (t) {
            if (imageType == 'logo') {
                $('#shopLogoHtml').html(t);
            } else if (imageType == 'banner') {
                $('#shopBannerHtml').html(t);
            }
        });
    };

    shopTemplates = function (el) {
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'shopTemplate'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
            $(el).parent().siblings().removeClass('is-active');
            $(el).parent().addClass('is-active');
        });
    };

    setTemplate = function (ltemplateId) {
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setTemplate', [ltemplateId]), '', function (t) {
            shopTemplates();
        });
    };

    removeShopImage = function (BannerId, langId, imageType, slide_screen) {
        var agree = confirm(langLbl.confirmRemove);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'removeShopImage', [BannerId, langId, imageType, slide_screen]), '', function (t) {
            shopImages(imageType, slide_screen, langId);
        });
    };

    deleteShopCollection = function (scollection_id) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.ajax(fcom.makeUrl('Seller', 'deleteShopCollection', [scollection_id]), '', function (res) {
            shopCollections();
        });
    };

    shopCollections = function () {
        if (1 > $(mtabId).data('shop_id')) {
            return;
        }
        markMainTabActive();
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'searchShopCollections'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
        });
    };

    shopCollectionProducts = function (el) {
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'shopCollection'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
            $(el).parent().siblings().removeClass('is-active');
            $(el).parent().addClass('is-active');
            getShopCollectionGeneralForm();
        });
    };

    getShopCollectionGeneralForm = function (scollection_id) { 
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'shopCollectionGeneralForm', [scollection_id]), '', function (t) {
            fcom.removeLoader();
            $.ykmodal(t);
        });
    };

    setupShopCollection = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('seller', 'setupShopCollection'), data, function (t) {
            fcom.removeLoader();          
            shopCollections();
            if (t.langId > 0) {
                editShopCollectionLangForm(t.collection_id, t.langId);
                return;
            } else if (t.openCollectionLinkForm) {
                sellerCollectionProducts(t.collection_id);
                return;
            } else {
                getShopCollectionGeneralForm(t.collection_id);
            }
        });
    };

    setupShopCollectionlangForm = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('seller', 'setupShopCollectionLang'), data, function (t) {
            fcom.removeLoader();
            if (t.langId > 0) {
                editShopCollectionLangForm(t.scollection_id, t.langId);
            }
            if (t.openCollectionLinkForm) {
                sellerCollectionProducts(t.scollection_id);
                return;
            }
        });

    };

    editShopCollectionLangForm = function (scollection_id, langId, autoFillLangData = 0) {
        if (typeof (langId) == "undefined" || langId < 0) {
            return false;
        }
        $(dvt).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('seller', 'shopCollectionLangForm', [scollection_id, langId, autoFillLangData]), '', function (t) {
            fcom.removeLoader();
            $.ykmodal(t);
        });
    };

    sellerCollectionProducts = function (scollection_id) {
        if (scollection_id < 0 || typeof (scollection_id) == "undefined") {
            return false;
        }       
        $(dvt).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'shopCollectionProductLinkFrm', [scollection_id]), '', function (t) {
            fcom.removeLoader();
            $.ykmodal(t);
            bindAutoComplete();
        });
    };

    setUpSellerCollectionProductLinks = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setUpSellerCollectionProductLinks'), data, function (t) {
            fcom.removeLoader();
            if("openMediaForm" in t){
                collectionMediaForm(t.scollection_id);
            }            
        });
    };

    socialPlatforms = function () {
        if (1 > $(mtabId).data('shop_id')) {
            return;
        }
        markMainTabActive();
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'socialPlatforms'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
        });
    };
    addForm = function (splatformId) {
     
        if (splatformId < 0 || typeof (splatformId) == "undefined") {
            splatformId = 0;
        }    
        fcom.ajax(fcom.makeUrl('Seller', 'socialPlatformForm', [splatformId]), '', function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };
    setup = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'socialPlatformSetup'), data, function (t) {          
            fcom.removeLoader();
            reloadSocialPlatformsList();
            if (t.langId > 0) {
                addLangForm(t.splatformId, t.langId);
            }
        });
    };

    addLangForm = function (splatformId, langId, autoFillLangData = 0) {       
        if (splatformId < 0 || typeof (splatformId) == "undefined") {
            return false;
        }       
        $(dvt).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'socialPlatformLangForm', [splatformId, langId, autoFillLangData]), '', function (t) {
            fcom.removeLoader();
            $.ykmodal(t);
        });
    };

    setupLang = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'socialPlatformLangSetup'), data, function (t) {
            fcom.removeLoader();
            reloadSocialPlatformsList();
            if (t.langId > 0) {
                addLangForm(t.splatformId, t.langId);
                return;
            }
        });
    };

    deleteRecord = function (id) {
        if (!confirm(langLbl.confirmDelete)) { return; }
        data = 'splatformId=' + id;
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'deleteSocialPlatform'), data, function (res) {
            reloadSocialPlatformsList();
        });
    };

    reloadSocialPlatformsList = function () {
        socialPlatforms();
    };

    toggleSocialPlatformStatus = function (e, obj) {
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return;
        }
        var socialPlatformId = parseInt(obj.value);
        if (socialPlatformId < 1) {
            return false;
        }
        data = 'socialPlatformId=' + socialPlatformId;
        fcom.ajax(fcom.makeUrl('Seller', 'changeSocialPlatformStatus'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                $.ykmsg.success(ans.msg);
            } else {
                $.ykmsg.error(ans.msg);
            }
        });
    };

    getReturnAddress = function () {
        if (1 > $(mtabId).data('shop_id')) {
            return;
        }
        markMainTabActive();
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'getReturnAddress'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
        });
    };

    returnAddressForm = function () {
        if (1 > $(mtabId).data('shop_id')) {
            return;
        } 
        fcom.displayProcessing();       
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'returnAddressForm'), '', function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
            fcom.closeProcessing();
        });
    };

    setReturnAddress = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setReturnAddress'), data, function (t) {
            getReturnAddress();
            if (0 < t.langId) {
                returnAddressLangForm(t.langId);
            }
        });
    };

    returnAddressLangForm = function (langId, autoFillLangData = 0) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'returnAddressLangForm', [langId, autoFillLangData]), '', function (t) {
            fcom.removeLoader();
            $.ykmodal(t);
        });
    };

    setReturnAddressLang = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setReturnAddressLang'), data, function (t) {
            getReturnAddress();
        });
    };

    deleteReturnAddress = function (id, type) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'deleteReturnAddress'), '', function (res) {
            getReturnAddress();
        });
    };

    pickupAddress = function () {
        if (1 > $(mtabId).data('shop_id')) {
            return;
        }
        markMainTabActive();
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'pickupAddress'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
        });
    };

    pickupAddressForm = function (id, langId = 0) {
        fcom.displayProcessing();
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'pickupAddressForm', [id, langId]), '', function (t) {
            fcom.removeLoader();
            fcom.closeProcessing();
            $.ykmodal(t, false, 'modal-dialog-vertical-md');
            setTimeout(function () { $('.fromTime-js').change(); }, 500);
        });
    };

    setPickupAddress = function (frm) {
        if (!$(frm).validate()) { return; }
        if (1 == $(".availabilityType-js:checked").val()) {
            if (1 > $(".slotDays-js:checked").length) {
                $.ykmsg.error(langLbl.selectTimeslotDay);
                return false;
            }
        }else {
            if ('' == $(".fromTime-js option:selected").val() || '' == $(".toTime-js option:selected").val()) {
                $.ykmsg.error(langLbl.invalidTimeSlot);
                return false;
            }
        }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setPickupAddress'), data, function (t) {
            pickupAddress();
            closeForm();
        });
    };

    removeAddress = function (id, type) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        data = 'id=' + id + '&type=' + type;
        fcom.updateWithAjax(fcom.makeUrl('Addresses', 'deleteRecord'), data, function (res) {
            pickupAddress();
        });
    };

    collectionMediaForm = function (scollection_id) {      
        if (scollection_id < 0 || typeof (scollection_id) == "undefined") {
            return false;
        }
        $(dvt).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Seller', 'shopCollectionMediaForm', [scollection_id]), '', function (t) {
            fcom.removeLoader();
            $.ykmodal(t);          
            shopCollectionImages(scollection_id);
        });
    };

    shopCollectionImages = function (scollection_id, lang_id) {
        scollection_id = scollection_id || $(ctabId).data('collectionId');
        if (scollection_id < 0 || typeof (scollection_id) == "undefined") {
            return false;
        }
        fcom.ajax(fcom.makeUrl('Seller', 'shopCollectionImages', [scollection_id, lang_id]), '', function (t) {
            $('#collectionImageHtml').html(t);
        });
    };

    removeCollectionImage = function (scollection_id, langId) {
        var agree = confirm(langLbl.confirmRemove);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'removeCollectionImage', [scollection_id, langId]), '', function (t) {
            shopCollectionImages(scollection_id, langId);
        });
    };

    toggleShopCollectionStatus = function (e, obj) {
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return;
        }
        var scollection_id = parseInt(obj.value);
        if (scollection_id < 1) {
            return false;
        }
        data = 'scollection_id=' + scollection_id;
        fcom.ajax(fcom.makeUrl('Seller', 'changeShopCollectionStatus'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                $.ykmsg.success(ans.msg);
            } else {
                $.ykmsg.error(ans.msg);
            }
        });
    };

    toggleBulkStatues = function (status) {
        if (!confirm(langLbl.confirmUpdateStatus)) {
            return false;
        }
        $("#frmCollectionsListing input[name='collection_status']").val(status);
        $("#frmCollectionsListing").submit();
    };

    deleteSelected = function () {
        if (!confirm(langLbl.confirmDelete)) {
            return false;
        }
        $("#frmCollectionsListing").attr("action", fcom.makeUrl('Seller', 'deleteSelectedCollections')).submit();
    };

    bannerPopupImage = function (inputBtn) {
        if(!validateFileUpload(inputBtn.files[0])){
            return;    
        }
        loadCropperSkeleton(false);
        $("#modalBoxJs .modal-title").text($(inputBtn).attr('data-name'));
        if (inputBtn.files && inputBtn.files[0]) {
            fcom.updateWithAjax(fcom.makeUrl('Seller', 'imgCropper'), '', function (t) {
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);

                var file = inputBtn.files[0];
                var minWidth = document.frmShopBanner.banner_min_width.value;
                var minHeight = document.frmShopBanner.banner_min_height.value;
                var options = {
                    aspectRatio: minWidth/minHeight,
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
                setTimeout(function () { cropImage(file, options, 'uploadShopImages', inputBtn); }, 100);
            });
        }
    };

    logoPopupImage = function (inputBtn) {
        if(!validateFileUpload(inputBtn.files[0])){
            return;    
        }
        loadCropperSkeleton(false);
        $("#modalBoxJs .modal-title").text($(inputBtn).attr('data-name'));
        if (inputBtn.files && inputBtn.files[0]) {
            fcom.updateWithAjax(fcom.makeUrl('Seller', 'imgCropper'), '', function (t) {
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);
                var file = inputBtn.files[0];
                var minWidth = document.frmShopLogo.logo_min_width.value;
                var minHeight = document.frmShopLogo.logo_min_height.value;               
                var options = {
                    aspectRatio: minWidth / minHeight,
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
                setTimeout(function () { cropImage(file, options, 'uploadShopImages', inputBtn); }, 100);
            });
        }
    };

    uploadShopImages = function (formData) {
        var frmName = formData.get("frmName");
        if ('frmShopLogo' == frmName) {
            var langId = document.frmShopLogo.lang_id.value;
            var fileType = document.frmShopLogo.file_type.value;
            var imageType = 'logo';
            var ratio_type = $('input[name="ratio_type"]:checked').val();
        } else {
            var langId = document.frmShopBanner.lang_id.value;
            var slideScreen = document.frmShopBanner.slide_screen.value;
            var fileType = document.frmShopBanner.file_type.value;
            var imageType = 'banner';
            var ratio_type = 0;
        }

        formData.append('slide_screen', slideScreen);
        formData.append('lang_id', langId);
        formData.append('file_type', fileType);
        formData.append('ratio_type', ratio_type);
        formData.append('fIsAjax', 1);

        $.ajax({
            url: fcom.makeUrl('Seller', 'uploadShopImages'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#modalBoxJs .modal-body").prepend(fcom.getLoader());
            },
            success: function (ans) {
                $("#modalBoxJs").modal("hide");
                fcom.removeLoader();
                if (ans.status == true) {
                    $.ykmsg.success(ans.msg);
                    shopImages(imageType, slideScreen, langId);
                } else {
                    $.ykmsg.error(ans.msg);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    collectionPopupImage = function (inputBtn) {
        if(!validateFileUpload(inputBtn.files[0])){
            return;    
        }
        loadCropperSkeleton();
        $("#modalBoxJs .modal-title").text($(inputBtn).attr('data-name'));
        if (inputBtn.files && inputBtn.files[0]) {
            $.ykmodal(fcom.getLoader(), '', 'cropper-body');
            fcom.updateWithAjax(fcom.makeUrl('Seller', 'imgCropper'), '', function (t) {
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);
                var file = inputBtn.files[0];
                var options = {
                    aspectRatio: collectionMediaWidth / collectionMediaHeight,
                    data: {
                        width: collectionMediaWidth,
                        height: collectionMediaHeight,
                    },
                    minCropBoxWidth: collectionMediaWidth,
                    minCropBoxHeight: collectionMediaHeight,
                    toggleDragModeOnDblclick: false,
                    imageSmoothingQuality: 'high',
                    imageSmoothingEnabled: true,
                };
                $(inputBtn).val('');
                setTimeout(function () { cropImage(file, options, 'uploadCollectionImage', inputBtn); }, 100);
            });
        }
    };

    uploadCollectionImage = function (formData) {
        var scollection_id = document.frmCollectionMedia.scollection_id.value;
        var lang_id = document.frmCollectionMedia.lang_id.value;

        formData.append('scollection_id', scollection_id);
        formData.append('lang_id', lang_id);
        formData.append('fIsAjax', 1);
        $.ajax({
            url: fcom.makeUrl('Seller', 'uploadCollectionImage'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#modalBoxJs .modal-body").prepend(fcom.getLoader());
            },
            success: function (ans) {
                fcom.removeLoader();
                $("#modalBoxJs").modal("hide");
                if (ans.status == true) {
                    $.ykmsg.success(ans.msg);
                    shopCollectionImages(scollection_id, lang_id);
                } else {
                    $.ykmsg.error(ans.msg);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    pluginPlatform = function (el) {
        markMainTabActive();
        $(dv).prepend(fcom.getLoader());
        var platformUrl = $(el).data('platformurl');
        fcom.ajax(platformUrl, '', function (t) {
            fcom.removeLoader();
            t = $.parseJSON(t);
            htm = (1 > t.status) ? t.msg : t.html;

            $(dv).html(htm);
            $(el).parent().siblings().removeClass('is-active');
            $(el).parent().addClass('is-active');
        });
    };

    requiredFieldsForm = function () {
        var businessType = $("select[name='business_type']").val();
        var contentDv = dv + " .requiredFieldsForm-js";
        $(contentDv).prepend(fcom.getLoader());
        var data = 'businessType=' + businessType;
        fcom.ajax(fcom.makeUrl(keyName, 'requiredFieldsForm'), data, function (res) {
            fcom.removeLoader();
            t = $.parseJSON(res);
            if (1 > t.status) {
                $(contentDv).html(t.html);
                bindMcc();
            } else {
                $.ykmsg.success(t.msg);
                $('.pluginPlatform-js').click();
            }
            $(".loader-yk").remove();
        });
    };

    bindMcc = function () {
        var selector = $(".mcc--js");
        if (0 < selector.length) {
            var valueFld = selector.data('valfld');

            fcom.ajax(fcom.makeUrl(keyName, 'getMerchantCategory'), '', function (res) {
                selector.select2({
                    closeOnSelect: true,
                    dropdownParent: selector.closest('form'),
                    dir: langLbl.layoutDirection,
                    allowClear: true,
                    placeholder: selector.attr('placeholder'),
                    data: $.parseJSON(res),
                    minimumInputLength: 0,
                }).on('select2:selecting', function (e) {
                    var item = e.params.args.data;
                    $("." + valueFld).val(item.id);
                }).on('select2:unselecting', function (e) {
                    $("." + valueFld).val("");
                }).on('select2:open', function(e) {    
                    selector.data("select2").$dropdown.addClass("custom-select2 custom-select2-single");
                })
                .data("select2").$container.addClass("custom-select2-width custom-select2 custom-select2-single");;
            });
        }
    }

    clearForm = function () {
        requiredFieldsForm();
    };

    setupRequiredFields = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        var attr = $(frm).attr('enctype');
        if (typeof attr !== typeof undefined && attr !== false) {
            $(frm).attr('action', fcom.makeUrl(keyName, 'setupRequiredFields')).removeAttr("onsubmit").submit();
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl(keyName, 'setupRequiredFields'), data, function (t) {
            location.href = t.link;
        });
    }

    register = function (el) {
        var href = $(el).data('href');
        fcom.updateWithAjax(href, '', function (t) {
            $('.pluginPlatform-js').click();
        });
    }

    completeAccount = function (el) {
        var href = $(el).data('href');
        fcom.updateWithAjax(href, '', function (t) {
            if ('undefined' != typeof t.link) {
                location.href = t.link;
            }
        });
    }

    initialSetup = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(keyName, 'initialSetup'), data, function (t) {
            $('.' + keyName).click();
        });
    }

    deleteAccount = function (el) {
        if (!confirm(langLbl.deleteAccount)) { return false; };
        var href = $(el).data('href');
        fcom.updateWithAjax(href, '', function (t) {
            $('.pluginPlatform-js').click();
        });
    };
    unlinkAccount = function (el) {
        if (!confirm(langLbl.unlinkAccount)) { return false; };
        var href = $(el).data('href');
        fcom.updateWithAjax(href, '', function (t) {
            $('.pluginPlatform-js').click();
        });
    };
    getUniqueSlugUrl = function (obj, str, recordId) {
        if (str == '') {
            return;
        }
        var data = { url_keyword: str, recordId: recordId }
        fcom.ajax(fcom.makeUrl('Seller', 'isShopRewriteUrlUnique'), data, function (t) {
            var ans = $.parseJSON(t);
            $(obj).next().html(ans.msg);
            if (ans.status == 0) {
                $(obj).next().addClass('text-danger');
            } else {
                $(obj).next().removeClass('text-danger');
            }
        });
    };

    markMainTabActive = function () {
        $(mtabId + ' a.active').removeClass('active');
        $(mtabId).find("a[onclick^='" + markMainTabActive.caller.name + "']").addClass('active');
    }

    markSubTabActive = function () {
        $(ctabId + ' a.active').removeClass('active');
        $(ctabId + " a[onclick^='" + markSubTabActive.caller.name + "']").addClass('active');
    }

})();

function bindAutoComplete() {
    $("#scp_selprod_id").select2({
        dropdownParent: $("#scp_selprod_id").closest('form'),
        closeOnSelect: true,
        dir: langLbl.layoutDirection,
        allowClear: false,
        placeholder: $("#scp_selprod_id").attr('placeholder'),
        ajax: {
            url: fcom.makeUrl('seller', 'autoCompleteProducts'),
            dataType: 'json',
            delay: 250,
            method: 'post',
            data: function (params) {
                return {
                    keyword: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results.filter(function (item) { return 1 > $('#selprod-products [name="product_ids[]"][value="' + item.id + '"]').length }),
                    pagination: {
                        more: params.page < data.pageCount
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        templateResult: function (result) {
            return (typeof result.text !== 'undefined') ? result.text : result.text + '[' + result.product_identifier + ']';
        },
        templateSelection: function (result) {
            return (typeof result.text !== 'undefined') ? result.text : result.text + '[' + result.product_identifier + ']';
        }
    }).on('select2:open', function(e) {     
        $("#scp_selprod_id").data("select2").$dropdown.addClass("custom-select2 custom-select2-single");           
    })
    .data("select2").$container.addClass("custom-select2-width custom-select2 custom-select2-single");

}

$(document).on('click', '.catFile-Js', function () {
    var node = this;
    $('#form-upload').remove();
    var prodcat_id = document.frmCategoryMedia.prodcat_id.value;
    var lang_id = document.frmCategoryMedia.lang_id.value;
    var frm = '<form enctype="multipart/form-data" id="form-upload" style="position:absolute; top:-100px;" >';
    frm = frm.concat('<input type="file" name="file" />');
    frm = frm.concat('<input type="hidden" name="prodcat_id" value="' + prodcat_id + '">');
    frm = frm.concat('<input type="hidden" name="lang_id" value="' + lang_id + '">');
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
                url: fcom.makeUrl('Seller', 'setupCategoryBanner'),
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(node).val('loading..');
                },
                complete: function () {
                    $(node).val($val);
                },
                success: function (ans) {
                    fcom.removeLoader();
                    var dv = '#mediaResponse';
                    $('.text-danger').remove();
                    if (ans.status == true) {
                        $.ykmsg.success(ans.msg);
                        $(dv).removeClass('text-danger');
                        $(dv).addClass('badge-success');
                        reloadCategoryBannerList();
                        addCategoryBanner(prodcat_id);
                    } else {
                        $.ykmsg.error(ans.msg);
                        $(dv).removeClass('badge-success');
                        $(dv).addClass('text-danger');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);

});