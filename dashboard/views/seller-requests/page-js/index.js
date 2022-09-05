$(document).on('change', '#brandlogoLanguageJs', function () {
    var lang_id = $(this).val();
    var brand_id = $(this).closest("form").find('input[name="brand_id"]').val();
    brandMediaForm(brand_id, lang_id);
});

$(document).on('change', '#catLanguageJs', function () {
    let lang_id = $(this).val();
    let recordId = $(this).closest("form").find('input[name="record_id"]').val();
    categoryReqMediaForm(recordId, lang_id);
});

$(document).on('change', '.badgeLinkCondtionJs [name="breq_record_type"]', function () {
    $("input[name='record_ids']").val("");
    $('table.recordListing--js tr').remove();
    $(".badgeLinkCondtionJs .recordIds--js").removeAttr('disabled');
    if (RECORD_TYPE_SHOP == $(this).val()) {
        $(".badgeLinkCondtionJs .recordIds--js").attr('disabled', 'disabled');
    } else {
        var recordNameSelector = $(".badgeLinkCondtionJs .recordIds--js");
        if ("" == recordNameSelector.val() || "undefined" == recordNameSelector.val()) { return; }
        $(".badgeLinkCondtionJs .recordIds--js").val('').trigger('change');
    }
});

(function () {
    var runningAjaxReq = false;
    var dv = '#listing';

    checkRunningAjax = function () {
        if (runningAjaxReq == true) {
            console.log(runningAjaxMsg);
            return;
        }
        runningAjaxReq = true;
    };

    /* markActive = function (element) {
        $('.navTabsJs a.active').removeClass('active');
        $(element).addClass('active');
    } */

    goToCustomCatalogProductSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmCatalogProductSearchPaging;
        $(frm.page).val(page);
        searchCustomCatalogProducts();
    };

    searchCustomCatalogProducts = function () {
        checkRunningAjax();
        $(dv).prepend(fcom.getLoader());
        var data = fcom.frmData(document.frmCatalogProductSearchPaging);
        fcom.ajax(fcom.makeUrl('SellerRequests', 'searchCustomCatalogProducts'), data, function (res) {
            fcom.removeLoader();
            runningAjaxReq = false;
            $(dv).html(res);
        });
    };

    customCatalogInfo = function (prodreq_id) {
        fcom.ajax(fcom.makeUrl('SellerRequests', 'customCatalogInfo', [prodreq_id]), '', function (t) {
            $.ykmodal(t);
        });
    }

    goToBrandSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSearchBrandRequest;
        $(frm.page).val(page);
        searchBrandRequests();
    };

    searchBrandRequests = function () {
        checkRunningAjax();
        $(dv).prepend(fcom.getLoader());
        var data = fcom.frmData(document.frmSearchBrandRequest);
        fcom.ajax(fcom.makeUrl('SellerRequests', 'searchBrandRequests'), data, function (res) {
            fcom.removeLoader();
            runningAjaxReq = false;
            $(dv).html(res);
        });
    };

    goToProdCategorySearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSrchProdCategoryRequest;
        $(frm.page).val(page);
        searchProdCategoryRequests();
    };

    searchProdCategoryRequests = function () {
        checkRunningAjax();
        $(dv).prepend(fcom.getLoader());
        var data = fcom.frmData(document.frmSrchProdCategoryRequest);
        fcom.ajax(fcom.makeUrl('SellerRequests', 'searchProdCategoryRequests'), data, function (res) {
            fcom.removeLoader();
            runningAjaxReq = false;
            $(dv).html(res);
        });
    };

    /* Product Brand Request [ */
    addBrandReqForm = function (id) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerRequests', 'addBrandReqForm', [id]), '', function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
            $.ykmsg.close();
        });
    };

    setupBrandReq = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'setupBrandReq'), data, function (t) {
            searchBrandRequests(frm);
            if (t.langId > 0) {
                addBrandReqLangForm(t.brandReqId, t.langId);
                return;
            }

            if (t.openMediaForm) {
                brandMediaForm(t.brandReqId);
                return;
            }
        });
    };

    addBrandReqLangForm = function (brandReqId, langId, autoFillLangData = 0) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerRequests', 'brandReqLangForm', [brandReqId, langId, autoFillLangData]), '', function (t) {
            fcom.removeLoader();
            $.ykmodal(t);
        });
    };

    setupBrandReqLang = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'brandReqLangSetup'), data, function (t) {
            if (t.langId > 0) {
                addBrandReqLangForm(t.brandReqId, t.langId);
                return;
            }
            if (t.openMediaForm) {
                brandMediaForm(t.brandReqId);
                return;
            }
        });
    };

    brandMediaForm = function (brandReqId, langId = 0, slide_screen = 1) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerRequests', 'brandMediaForm', [brandReqId, langId]), '', function (t) {            
            brandImages(brandReqId, 'logo', slide_screen, langId);
            brandImages(brandReqId, 'image', slide_screen, langId);
            fcom.removeLoader();
            $.ykmodal(t);
        });
    };

    brandImages = function (brandId, fileType, slide_screen, langId) {
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'brandImages', [brandId, fileType, langId, slide_screen]), '', function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            if (fileType == 'logo') {
                $('#logoListingJs').html(t.html);
            } else {
                $('#imageListingJs').html(t.html);
            }
        });
    };


    deleteBrandMedia = function (brandId, fileType, afileId, langId, slide_screen) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('BrandRequests', 'removeBrandMedia', [brandId, fileType, afileId]), '', function (t) {
            fcom.displaySuccessMessage(t.msg);
            brandImages(brandId, fileType, slide_screen, langId);
            reloadList();
        });
    };

    removeBrandMedia = function (brandId, fileType, afileId, langId, slide_screen) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'removeBrandMedia', [brandId, fileType, afileId]), '', function (t) {
            brandImages(brandId, fileType, slide_screen, langId);
            searchBrandRequests();
        });
    }

    checkUniqueBrandName = function (obj, $langId, $brandId) {
        data = "brandName=" + $(obj).val() + "&langId= " + $langId + "&brandId= " + $brandId;
        fcom.ajax(fcom.makeUrl('Brands', 'checkUniqueBrandName'), data, function (t) {
            $.ykmsg.close();
            $res = $.parseJSON(t);

            if ($res.status == 0) {
                $(obj).val('');
                fcom.displayErrorMessage($res.msg);
            }

        });
    };

    brandPopupImage = function (inputBtn) {
        if(!validateFileUpload(inputBtn.files[0])){
            return;    
        }
        loadCropperSkeleton();
        $("#modalBoxJs .modal-title").text($(inputBtn).attr('data-name'));
        if (inputBtn.files && inputBtn.files[0]) {
            fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'imgCropper'), '', function (t) {
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);

                var frmName = $(inputBtn).closest('form').attr('name');
                var minWidth = document[frmName].min_width.value;
                var minHeight = document[frmName].min_height.value;

                var options = {
                    toggleDragModeOnDblclick: false,
                    imageSmoothingQuality: "high",
                    imageSmoothingEnabled: true,
                };
                options['aspectRatio'] = minWidth / minHeight;
                options['minCropBoxWidth'] = minWidth;
                options['minCropBoxHeight'] = minHeight;
                options['data'] = {
                    width: minWidth,
                    height: minHeight,
                };
               
                var file = inputBtn.files[0];
                $(inputBtn).val('');
                setTimeout(function () { cropImage(file, options, 'uploadBrandMedia', inputBtn); }, 100);
            });
        }
    };

    uploadBrandMedia = function (formData) {  
      
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

        var other_data = $('form[name="' + frmName + '"]').serializeArray();
        $.each(other_data, function (key, input) {
            formData.append(input.name, input.value);
        });

        $.ajax({
            url: fcom.makeUrl('SellerRequests', 'uploadBrandMedia'),
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
                    $("." + $.ykmodal.element + " form[name='" + frm['name'] + "'] [name='lang_id']").val(langId).change();
                    fcom.displaySuccessMessage(ans.msg);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    /* ] */

    /* Product Category  request [*/
    addCategoryReqForm = function (id = 0) {
        fcom.ajax(fcom.makeUrl('SellerRequests', 'categoryReqForm', [id]), '', function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    addCategoryReqLangForm = function (categoryReqId, langId, autoFillLangData = 0) {       
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerRequests', 'categoryReqLangForm', [categoryReqId, langId, autoFillLangData]), '', function (t) {
            fcom.removeLoader();
            $.ykmodal(t);
        });
    };

    categoryReqMediaForm = function (categoryReqId, langId = 0) {   
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerRequests', 'categoryReqMediaForm', [categoryReqId, langId]), '', function (t) {
            fcom.removeLoader();
            $.ykmodal(t);            
        });
    };

    categoryPopupImage = function (inputBtn) {
        if(!validateFileUpload(inputBtn.files[0])){
            return;    
        }
        loadCropperSkeleton();
        $("#modalBoxJs .modal-title").text($(inputBtn).attr('data-name'));
        if (inputBtn.files && inputBtn.files[0]) {
            fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'imgCropper'), '', function (t) {
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);
                var frmName = $(inputBtn).closest('form').attr('name');
                var minWidth = document[frmName].min_width.value;
                var minHeight = document[frmName].min_height.value;
                var options = {                    
                    aspectRatio: minWidth / minHeight,
                    preview: '.img-preview',
                    imageSmoothingQuality: 'high',
                    imageSmoothingEnabled: true,
                    crop: function (e) {
                        var data = e.detail;
                    }
                };
                var file = inputBtn.files[0];
                $(inputBtn).val('');
                setTimeout(function () { cropImage(file, options, 'uploadCategoryLogo', inputBtn); }, 100);
            });
        }
    };

    uploadCategoryLogo = function (formData) {
        var frmName = formData.get("frmName");
        var frm = document.forms[frmName];       
        let langId = 0;
        if ('undefined' != typeof frm.lang_id) {
            langId = frm.lang_id.value;
        }

        var other_data = $('form[name="' + frmName + '"]').serializeArray();
        $.each(other_data, function(key, input) {
            formData.append(input.name, input.value);
        });
        $.ajax({
            url: fcom.makeUrl('SellerRequests', 'uploadCategoryLogo'),
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
                    categoryReqMediaForm(ans.recordId, langId);
                    searchProdCategoryRequests();
                    fcom.displaySuccessMessage(ans.msg);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    removeCategoryLogo = function (recordId, langId) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'removeCategoryLogo', [recordId, langId]), '', function (t) {
            categoryReqMediaForm(recordId, langId);
            searchBrandRequests();
        });
    }

    setupCategoryReq = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'setupCategoryReq'), data, function (t) {          
            if (0 < t.langId) {
                addCategoryReqLangForm(t.categoryReqId, t.langId);
            }
            searchProdCategoryRequests(frm);
        });
    };

    setupCategoryReqLang = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'categoryReqLangSetup'), data, function (t) {
            if (t.langId > 0) {
                addCategoryReqLangForm(t.categoryReqId, t.langId);
                return;
            }
            if (t.openMediaForm) {
                categoryReqMediaForm(t.categoryReqId);
                return;
            }
        });
    };

    /* ] */

    translateData = function (item, defaultLang, toLangId) {
        var autoTranslate = $("input[name='auto_update_other_langs_data']:checked").length;
        var prodName = $("input[name='product_name[" + defaultLang + "]']").val();
        var oEdit = eval(oUtil.arrEditor[0]);
        var prodDesc = oEdit.getTextBody();

        var alreadyOpen = $('.collapse-js-' + toLangId).hasClass('show');
        if (autoTranslate == 0 || prodName == "" || alreadyOpen == true) {
            return false;
        }
        var data = "product_name=" + prodName + '&product_description=' + prodDesc + "&toLangId=" + toLangId;
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'translatedProductData'), data, function (t) {
            if (t.status == 1) {
                $("input[name='product_name[" + toLangId + "]']").val(t.productName);
                var oEdit1 = eval(oUtil.arrEditor[toLangId - 1]);
                oEdit1.putHTML(t.productDesc);
                var layout = langLbl['language' + toLangId];
                $('#idContent' + oUtil.arrEditor[toLangId - 1]).contents().find("body").css('direction', layout);
                $('#idArea' + oUtil.arrEditor[toLangId - 1] + ' td[dir="ltr"]').attr('dir', layout);
            }
        });
    }

    productInstructions = function (type) {
        fcom.ajax(fcom.makeUrl('Seller', 'productTooltipInstruction', [type]), '', function (t) {
            $.ykmodal(t);
        });
    };

    /* Badge Request [ */
    addBadgeReqForm = function (badgeReqId, badgeId = 0) {
        fcom.ajax(fcom.makeUrl('SellerRequests', 'badgeReqForm', [badgeReqId, badgeId]), '', function (t) {
            $.ykmodal(t);
            setTimeout(() => {
                bindRecordsSelect2();
                updateRecordIds();
                $("select[name='breq_blinkcond_id']").trigger('change');
                if (0 < badgeReqId) {
                    reloadRecordsList(badgeReqId, 1);
                }
            }, 500);
        });
    };

    backToListing = function () {
        searchBadgeRequests();
        $.ykmodal.close();
    }

    setupBadgeReq = function (frm) {
        if (!$(frm).validate()) { return; }

        let formData = new FormData(frm);
        $.ajax({
            url: fcom.makeUrl('SellerRequests', 'setupBadgeReq'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                fcom.displayProcessing();
            },
            success: function (ans) {
                if (1 > ans.status) {
                    fcom.displayErrorMessage(ans.msg);
                    return false;
                }
                fcom.displaySuccessMessage(ans.msg);
                backToListing();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    };

    deleteBadgeRequest = function (badgeReqId) {
        if (!confirm(langLbl.confirmDelete)) { return; }
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'deleteBadgeRequest', [badgeReqId]), '', function (t) { searchBadgeRequests(); });
    }
    
    goToBadgeSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSearchBadgeRequest;
        $(frm.page).val(page);
        searchBadgeRequests();
    };

    searchBadgeRequests = function () {
        checkRunningAjax();
        $(dv).prepend(fcom.getLoader());
        var data = fcom.frmData(document.frmSearchBadgeRequest);
        fcom.ajax(fcom.makeUrl('SellerRequests', 'searchBadgeRequests'), data, function (res) {
            fcom.removeLoader();
            runningAjaxReq = false;
            $(dv).html(res);
        });
    }

    getRecordTypeURL = function () {
        var searchSelector = $("select.recordIds--js").siblings('.select2').find('[aria-owns]').attr('aria-owns');
        $("#" + searchSelector).html("");
        var recordType = $('[name="breq_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            return fcom.makeUrl('Products', 'autoComplete', [], siteConstants.webrootfront);
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return fcom.makeUrl('Seller', 'sellerProductsAutoComplete');
        } else if (RECORD_TYPE_SHOP == recordType) {
            return fcom.makeUrl('Seller', 'getShopDetail', [1]);
        } else {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
    }

    getRecordData = function (data) {
        var recordType = $('[name="breq_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            return data
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return data.suggestions;
        } else if (RECORD_TYPE_SHOP == recordType) {
            return [data.shopData];
        } else {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
    }

    bindRecordsSelect2 = function () {
        var selector = $("select.recordIds--js");
        selector.select2({
            tags: true,
            closeOnSelect: true,
            allowClear: true,
            dir: langLbl.layoutDirection,
            dropdownParent: selector.closest('form'),
            placeholder: selector.attr('placeholder'),
            ajax: {
                url: function () {
                    return getRecordTypeURL()
                },
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    return { keyword: params.term ,excludeRecords:  ($("input[name='record_ids']").val() != '' ? JSON.parse($("input[name='record_ids']").val()) : {})    };
                },
                processResults: function (data, params) {
                    return { results: getRecordData(data) };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: function (result) {
                return result.name || result.value;
            },
            templateSelection: function (result) {
                return result.name || result.value;
            }
        }).on('select2:selecting', function (e) {
            var position = 0;
            if (0 < $('select[name="blinkcond_position"]').length) {
                position = $('select[name="blinkcond_position"]').val();
            }

            var recordIds = $("input[name='record_ids']");
            var JSONObj = [e.params.args.data.id];
            var badgeLinkRecordIds = recordIds.val();
            if ('' != badgeLinkRecordIds) {
                JSONObj = JSON.parse(badgeLinkRecordIds);
                if (JSONObj.includes(e.params.args.data.id)) {
                    selector.val('').trigger('change');
                    fcom.displayErrorMessage(langLbl.alreadySelected);
                    return false;
                }
                JSONObj.push(e.params.args.data.id);
            }
            recordIds.val(JSON.stringify(JSONObj));
            setTimeout(function () {
                selector.val('').trigger('change');
            }, 200);
            var htm = '<tr><td><a class="text-dark" href="javascript:void(0)" title="' + langLbl.remove + '" onclick="removeRecordRow(this, ' + e.params.args.data.id + ');"><i class="fa fa-times"></i></a></id><td>' + (e.params.args.data.value || e.params.args.data.name) + '</td></tr>';
            var tbl = "";
            if (1 > $('table.recordListing--js').length) {
                var tbl = '<table class="table table-responsive table--hovered recordListing--js"><tbody></tbody></table>';
                $('.recordsContainer--js').html(tbl);
            }
            $('.recordListing--js').append(htm);
        }).on('select2:unselect', function (e) {
            updateRecordIds(e.params.args.data.id);
        }).on('select2:open', function (e) {
            selector.data("select2").$dropdown.addClass("custom-select2 custom-select2-multiple");               
        })
        .data("select2").$container.addClass("custom-select2-width custom-select2 custom-select2-multiple");
    }


    updateRecordIds = function (removeRecordId = 0) {
        var selectedRecords = $("input[name='record_ids']").val();
        if ('' != selectedRecords && 'undefined' != typeof selectedRecords) {
            selectedRecords = $.parseJSON(selectedRecords);
            if (removeRecordId) {
                var index = selectedRecords.indexOf(removeRecordId);
                if (index > -1) {
                    selectedRecords.splice(index, 1);
                }
                $("input[name='record_ids']").val(JSON.stringify(selectedRecords));
            }
        }
    }

    removeRecordRow = function (element, removeRecordId) {
        $(element).closest('tr').remove();
        updateRecordIds(removeRecordId);
        var badgeReqId = $('input[name="breq_id"]').val();
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'unlinkRecord', [badgeReqId, removeRecordId]), '', function (t) {
            reloadRecordsList(badgeReqId);
        });
    }

    reloadRecordsList = function (badgeReqId, page) {
        $(".recordsContainer--js").prepend(fcom.getLoader());
        var data = 'page=' + page;
        fcom.ajax(fcom.makeUrl('SellerRequests', 'records', [badgeReqId]), data, function (t) {
            fcom.removeLoader();
            $(".recordsContainer--js").html(t);
        });
    };

    removeBadgeRequestRefFile = function (badgeReqId) {
        fcom.ajax(fcom.makeUrl('SellerRequests', 'removeBadgeRequestRefFile', [badgeReqId]), '', function (t) {
            var res = $.parseJSON(t);
            if (1 > res.status) {
                fcom.displayErrorMessage(res.msg);
                return false;
            }
            $('.refFileJs').remove();
            $('.fileUpload--js').removeAttr('disabled');
            fcom.displaySuccessMessage(res.msg);
        });
    };
})();