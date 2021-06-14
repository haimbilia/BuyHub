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

    markActive = function (element) {
        $('ul.tabs_nav-js li.is-active').removeClass('is-active');
        $(element).closest('li').addClass('is-active');
    }

    goToCustomCatalogProductSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSearchCustomCatalogProducts;
        $(frm.page).val(page);
        searchCustomCatalogProducts();
    };

    searchCustomCatalogProducts = function () {
        checkRunningAjax();
        $(dv).html(fcom.getLoader());
        markActive('a.customCatalogReq--js');
        fcom.ajax(fcom.makeUrl('SellerRequests', 'searchCustomCatalogProducts'), '', function (res) {
            runningAjaxReq = false;
            $(dv).html(res);
        });
    };

    customCatalogInfo = function (prodreq_id) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('SellerRequests', 'customCatalogInfo', [prodreq_id]), '', function (t) {
                $.facebox(t, 'faceboxWidth catalogInfo');
            });
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
        $(dv).html(fcom.getLoader());
        markActive('a.brandReq--js');
        fcom.ajax(fcom.makeUrl('SellerRequests', 'searchBrandRequests'), '', function (res) {
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
        $(dv).html(fcom.getLoader());
        markActive('a.catReq--js');
        fcom.ajax(fcom.makeUrl('SellerRequests', 'searchProdCategoryRequests'), '', function (res) {
            runningAjaxReq = false;
            $(dv).html(res);
        });
    };


    /* Product Brand Request [ */
    addBrandReqForm = function (id) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('SellerRequests', 'addBrandReqForm', [id]), '', function (t) {
                $.facebox(t, 'faceboxWidth medium-fb-width');
            });
        });
    };

    setupBrandReq = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'setupBrandReq'), data, function (t) {
            $.mbsmessage.close();
            searchBrandRequests(frm);
            if (t.langId > 0) {
                addBrandReqLangForm(t.brandReqId, t.langId);
                return;
            }
            $(document).trigger('close.facebox');
        });
    };

    addBrandReqLangForm = function (brandReqId, langId, autoFillLangData = 0) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('SellerRequests', 'brandReqLangForm', [brandReqId, langId, autoFillLangData = 0]), '', function (t) {
                $.facebox(t);
            });
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
            $(document).trigger('close.facebox');
        });
    };

    brandMediaForm = function (brandReqId) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('SellerRequests', 'brandMediaForm', [brandReqId]), '', function (t) {
                $.facebox(t);
            });
        });
    };

    removeBrandLogo = function (brandReqId, langId) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'removeBrandLogo', [brandReqId, langId]), '', function (t) {
            brandMediaForm(brandReqId);
            reloadList();
        });
    }

    checkUniqueBrandName = function (obj, $langId, $brandId) {
        data = "brandName=" + $(obj).val() + "&langId= " + $langId + "&brandId= " + $brandId;
        fcom.ajax(fcom.makeUrl('Brands', 'checkUniqueBrandName'), data, function (t) {
            $.mbsmessage.close();
            $res = $.parseJSON(t);

            if ($res.status == 0) {
                $(obj).val('');

                $alertType = 'alert--danger';

                $.mbsmessage($res.msg, true, $alertType);
            }

        });
    };

    brandPopupImage = function (inputBtn) {
        if (inputBtn.files && inputBtn.files[0]) {
            fcom.ajax(fcom.makeUrl('SellerRequests', 'imgCropper'), '', function (t) {
                $('#cropperBox-js').html(t);
                $("#brandMediaForm-js").css("display", "none");
                var ratioType = document.frmBrandMedia.ratio_type.value;
                var aspectRatio = 1 / 1;
                if (ratioType == ratioTypeRectangular) {
                    aspectRatio = 16 / 5
                }
                var options = {
                    aspectRatio: aspectRatio,
                    preview: '.img-preview',
                    imageSmoothingQuality: 'high',
                    imageSmoothingEnabled: true,
                    crop: function (e) {
                        var data = e.detail;
                    }
                };
                var file = inputBtn.files[0];
                $(inputBtn).val('');
                return cropImage(file, options, 'uploadBrandLogo', inputBtn);
            });
        }
    };

    uploadBrandLogo = function (formData) {
        var brandId = document.frmBrandMedia.brand_id.value;
        var langId = document.frmBrandMedia.brand_lang_id.value;
        var ratio_type = $('input[name="ratio_type"]:checked').val();
        formData.append('brand_id', brandId);
        formData.append('lang_id', langId);
        formData.append('ratio_type', ratio_type);
        $.ajax({
            url: fcom.makeUrl('SellerRequests', 'uploadBrandLogo'),
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
                $('.text-danger').remove();
                $('#input-field').html(ans.msg);
                if (ans.status == true) {
                    $('#input-field').removeClass('text-danger');
                    $('#input-field').addClass('text-success');
                    brandMediaForm(ans.brandId);
                } else {
                    $('#input-field').removeClass('text-success');
                    $('#input-field').addClass('text-danger');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    /* ] */

    /* Product Category  request [*/
    addCategoryReqForm = function (id) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('SellerRequests', 'categoryReqForm', [id]), '', function (t) {
                $.facebox(t, 'faceboxWidth medium-fb-width');
            });
        });
    };

    setupCategoryReq = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('SellerRequests', 'setupCategoryReq'), data, function (t) {
            $(document).trigger('close.facebox');
            searchProdCategoryRequests(frm);
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
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('Seller', 'productTooltipInstruction', [type]), '', function (t) {
                $.facebox(t, 'medium-fb-width catalog-bg');
            });
        });
    };

    /* Badge Request [ */
    addBadgeReqForm = function (badgeReqId) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('SellerRequests', 'badgeReqForm', [badgeReqId]), '', function (t) {
                $.facebox(t, 'content fbminwidth faceboxWidth medium-fb-width');
            });
        });
    };

    setupBadgeReq = function (frm) {
        if (!$(frm).validate()) return;

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
                $.mbsmessage(langLbl.processing, false, 'alert--process');
            },
            success: function (ans) {
                $.mbsmessage(ans.msg, true, 'alert--success');
                $(document).trigger('close.facebox');
                searchBadgeRequests();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    };

    searchBadgeRequests = function () {
        checkRunningAjax();
        $(dv).html(fcom.getLoader());
        markActive('a.badgeReq--js');
        fcom.ajax(fcom.makeUrl('SellerRequests', 'searchBadgeRequests'), '', function (res) {
            runningAjaxReq = false;
            $(dv).html(res);
        });
    }

    getRecordTypeURL = function () {
        var searchSelector = $(formClass + "select.recordIds--js").siblings('.select2').find('[aria-owns]').attr('aria-owns');
        $("#" + searchSelector).html("");
        var recordType = $(formClass + 'select[name="blinkcond_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            return fcom.makeUrl('Products', 'autoComplete');
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return fcom.makeUrl('SellerProducts', 'autoCompleteProducts');
        } else if (RECORD_TYPE_SHOP == recordType) {
            return fcom.makeUrl('Shops', 'autoComplete');
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    bindRecordsSelect2 = function () {
        var selector = $(formClass + "select.recordIds--js");
        selector.select2({
            tags: true,
            closeOnSelect: true,
            allowClear: true,
            dir: layoutDirection,
            placeholder: selector.attr('placeholder'),
            ajax: {
                url: function () {
                    return getRecordTypeURL()
                },
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    return { keyword: params.term };
                },
                processResults: function (data, params) {
                    return { results: getRecordData(data) };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: function (result) {
                return result.name;
            },
            templateSelection: function (result) {
                return result.name || result.text;
            }
        }).on('select2:selecting', function (e) {
            var badgeType = $(formClass + 'input[name="badge_type"]').val();
            var recordType = $(formClass + 'select[name="blinkcond_record_type"]').val();
            var position = 0;
            if (0 < $(formClass + 'select[name="blinkcond_position"]').length) {
                position = $(formClass + 'select[name="blinkcond_position"]').val();
            }
            fcom.ajax(fcom.makeUrl(controller, 'isUnique', [badgeType, recordType, e.params.args.data.id, position]), '', function (t) {
                var resp = JSON.parse(t);
                if (1 > resp.status) {
                    selector.val('').trigger('change');
                    $.systemMessage(resp.msg, 'alert--danger');
                    return false;
                }

                var JSONObj = [e.params.args.data.id];
                var badgeLinkRecordIds = $(formClass + "input[name='record_ids']").val();
                if ('' != badgeLinkRecordIds) {
                    JSONObj = JSON.parse(badgeLinkRecordIds);
                    JSONObj.push(e.params.args.data.id);
                }
                $(formClass + "input[name='record_ids']").val(JSON.stringify(JSONObj));
                setTimeout(function () {
                    selector.val('').trigger('change');
                }, 200);
                var badgeLinkCondId = $(formClass + "input[name='blinkcond_id']").val();
                if ('' != badgeLinkCondId) {
                    bindLink(badgeType, badgeLinkCondId, e.params.args.data.id, position);
                } else {
                    var htm = '<tr><td><a class="text-dark" href="javascript:void(0)" title="' + langLbl.remove + '" onClick="removeRecordRow(this, ' + e.params.args.data.id + ');"><i class="icon ion-close"></i></a></id><td>' + e.params.args.data.name + '</td></tr>';
                    var tbl = "";
                    if (1 > $(formClass + 'table.recordListing--js').length) {
                        var tbl = '<table class="table table-responsive table--hovered recordListing--js"><tbody></tbody></table>';
                        $(formClass + '.recordsContainer--js').html(tbl);
                    }
                    $(formClass + '.recordListing--js').append(htm);
                }
                $(formClass + "select[name='blinkcond_record_type']").attr('disabled', 'disabled');
            });
        }).on('select2:unselect', function (e) {
            updateRecordIds(e.params.args.data.id);
        });
    }

})();