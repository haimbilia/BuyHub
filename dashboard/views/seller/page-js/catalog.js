
$(document).on('change', '.option-js', function () {
    var option_id = $(this).val();
    var product_id = $('#frmCustomProductImage input[name=product_id]').val();
    var lang_id = $('.language-js').val();
    productImages(product_id, option_id, lang_id);
});

$(document).on('change', '.language-js', function () {
    var lang_id = $(this).val();
    var product_id = $('#frmCustomProductImage input[name=product_id]').val();
    var option_id = $('.option-js').val();
    productImages(product_id, option_id, lang_id);
});

$(document).on('change', '#digitalFrmLangId,#digitalFrmdownloadType,#digitalFrmOptionId', function () {
    let downloadType = $('#digitalFrmdownloadType').val();
    let recordId = $('#digitalFrmRecordId').val();
    let langId = $('#digitalFrmLangId').val();
    let optionCombi = $('#digitalFrmOptionId').val();

    getDigitalDownloads(downloadType, recordId, langId, optionCombi);
});

(function () {
    var runningAjaxMsg = 'some requests already running or this stucked into runningAjaxReq variable value, so try to relaod the page and update the same to WebMaster. ';
    var runningAjaxReq = false;
    var dv = '#listing';

    checkRunningAjax = function () {
        if (runningAjaxReq == true) {
            console.log(runningAjaxMsg);
            return;
        }
        runningAjaxReq = true;
    };

    searchCatalogProducts = function (frm) {
        checkRunningAjax();
        /*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
        var data = fcom.frmData(frm);
        /*]*/
        $(dv).prepend(fcom.getLoader());

        fcom.ajax(fcom.makeUrl('Seller', 'searchCatalogProduct'), data, function (res) {
            fcom.removeLoader();
            runningAjaxReq = false;
            $(dv).html(res);
        });
    };

    goToCatalogProductSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmCatalogProductSearchPaging;
        $(frm.page).val(page);
        searchCatalogProducts(frm);
    }

    productInstructions = function (type) {
        fcom.ajax(fcom.makeUrl('Seller', 'productTooltipInstruction', [type]), '', function (t) {
            $.ykmodal(t);
        });
    };

    setShippedBySeller = function (product_id) {
        var data = 'shippedBy=seller&product_id=' + product_id;
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setUpshippedBy'), data, function (t) {
            var frm = document.frmCatalogProductSearchPaging;
            $(document.frmRecordSearch.page).val($(frm.page).val());
            searchCatalogProducts(document.frmRecordSearch);
        });
    };

    setShippedByAdmin = function (product_id) {
        var data = 'shippedBy=admin&product_id=' + product_id;
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setUpshippedBy'), data, function (t) {
            var frm = document.frmCatalogProductSearchPaging;
            $(document.frmRecordSearch.page).val($(frm.page).val());
            searchCatalogProducts(document.frmRecordSearch);
        });
    };

    sellerShippingForm = function (productId) {
        $(dv).prepend(fcom.getLoader());

        fcom.ajax(fcom.makeUrl('Seller', 'sellerShippingForm', [productId]), '', function (res) {
            fcom.removeLoader();
            runningAjaxReq = false;
            $(dv).html(res);
        });
    }

    addShippingTab = function (id, sellerId) {
        ShipDiv = "#tab_shipping";
        fcom.ajax(fcom.makeUrl('seller', 'getShippingTab'), 'product_id=' + id, function (t) {
            try {
                res = jQuery.parseJSON(t);
                $.ykmodal(res.msg);
            } catch (e) {

                $(ShipDiv).html(t);
            }

        });
    }

    setupSellerShipping = function (frm) {
        if (!$(frm).validate()) { return; }
        if (runningAjaxReq == true) {
            console.log(runningAjaxMsg);
            return;
        }
        var data = fcom.frmData(frm);

        fcom.updateWithAjax(fcom.makeUrl('Seller', 'setupSellerShipping'), (data), function (t) {
            runningAjaxReq = false;
            productId = t.product_id;
            searchCatalogProducts(document.frmRecordSearch);
        });
    }

    clearSearch = function () {
        $('input[name="badge_id"], input[name="ribbon_id"], select[name="badge_name"], select[name="ribbon_name"], input[name="product_id"]').val('').trigger('change');
        document.frmRecordSearch.reset();
        searchCatalogProducts(document.frmRecordSearch);
    };

    customProductImages = function (productId) {
        var data = "hideButtons=1";
        fcom.ajax(fcom.makeUrl('Seller', 'customProductImages', [productId]), data, function (t) {
            productImages(productId);
            $.ykmodal(t);

        });
    };

    productImages = function (product_id, option_id, lang_id) {
        fcom.ajax(fcom.makeUrl('Seller', 'images', [product_id, option_id, lang_id]), '', function (t) {
            $('#imageupload_div').html(t);
        });
    };

    setupCustomProductImages = function () {
        /* if ($.browser.msie && parseInt($.browser.version, 10) === 8 || $.browser.msie && parseInt($.browser.version, 10) === 9) {
            $('#frmCustomProductImage').removeAttr('onsubmit')
            $('#frmCustomProductImage').submit(); return true;
        } */
        var data = new FormData();
        $inputs = $('#frmCustomProductImage input[type=text],#frmCustomProductImage select,#frmCustomProductImage input[type=hidden]');
        $inputs.each(function () { data.append(this.name, $(this).val()); });

        $.each($('#prod_image')[0].files, function (i, file) {
            $('#imageupload_div').prepend(fcom.getLoader());
            data.append('prod_image', file);
            $.ajax({
                url: fcom.makeUrl('Seller', 'setupCustomProductImages'),
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (t) {
                    fcom.removeLoader();
                    var ans = $.parseJSON(t);
                    if (ans.status == 1) {
                        fcom.displaySuccessMessage(ans.msg);
                    } else {
                        fcom.displayErrorMessage(ans.msg);
                    }
                    productImages($('#frmCustomProductImage input[name=product_id]').val(), $('.option').val(), $('.language').val());
                    $('#prod_image').val('');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error Occured.");
                }
            });
        });
    };

    deleteCustomProductImage = function (productId, image_id) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) { return false; }
        fcom.ajax(fcom.makeUrl('Seller', 'deleteCustomProductImage', [productId, image_id]), '', function (t) {
            var ans = $.parseJSON(t);
            fcom.displaySuccessMessage(ans.msg);
            if (ans.status == 0) {
                return;
            }
            productImages(productId, $('.option').val(), $('.language').val());
        });
    }

    checkIfAvailableForInventory = function (product_id) {
        fcom.ajax(fcom.makeUrl('Seller', 'checkIfAvailableForInventory', [product_id]), '', function (t) {
            $res = $.parseJSON(t);
            if ($res.status == 0) {
                fcom.displayErrorMessage($res.msg);
                return false;
            }
            window.location.href = fcom.makeUrl('Seller', 'sellerProductForm', [product_id]);
        });
    }

    catalogInfo = function (product_id) {
        fcom.ajax(fcom.makeUrl('Seller', 'catalogInfo', [product_id]), '', function (t) {
            $.ykmodal(t, true);
        });
    }

    sellerProducts = function (product_id) {
        window.location.href = fcom.makeUrl('Seller', 'Products', [product_id]);
    }

    shippingautocomplete = function (shipping_row) {
        $('input[name="product_shipping[' + shipping_row + '][country_name]"]').focusout(function () {
            setTimeout(function () { $('.suggestions').hide(); }, 500);
        });

        $('input[name="product_shipping[' + shipping_row + '][company_name]"]').focusout(function () {
            setTimeout(function () { $('.suggestions').hide(); }, 500);
        });

        $('input[name="product_shipping[' + shipping_row + '][processing_time]"]').focusout(function () {
            setTimeout(function () { $('.suggestions').hide(); }, 500);
        });
        $('input[name="product_shipping[' + shipping_row + '][country_name]"]').autocomplete({
            minLength: 0,
            'classes': {
                "ui-autocomplete": "custom-ui-autocomplete"
            },
            'source': function (request, response) {
                $.ajax({
                    url: fcom.makeUrl('seller', 'countries_autocomplete'),
                    data: { keyword: request['term'], fIsAjax: 1, includeEverywhere: true },
                    dataType: 'json',
                    type: 'post',
                    success: function (json) {
                        response($.map(json['results'], function (item) {
                            return { label: item['text'], value: item['text'], id: item['id'] };
                        }));
                    },
                });
            },
            select: function (event, ui) {
                $('input[name="product_shipping[' + shipping_row + '][country_name]"]').val(ui.item.label);
                $('input[name="product_shipping[' + shipping_row + '][country_id]"]').val(ui.item.id);
            }
        }).focus(function () {
            $(this).autocomplete("search", $(this).val());
        });


        $('input[name="product_shipping[' + shipping_row + '][company_name]"]').autocomplete({
            minLength: 0,
            'classes': {
                "ui-autocomplete": "custom-ui-autocomplete"
            },
            'source': function (request, response) {
                $.ajax({
                    url: fcom.makeUrl('seller', 'shippingCompanyAutocomplete'),
                    data: { keyword: request['term'], fIsAjax: 1 },
                    dataType: 'json',
                    type: 'post',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return { label: item['name'], value: item['name'], id: item['id'] };
                        }));
                    },
                });
            },
            select: function (event, ui) {
                $('input[name="product_shipping[' + shipping_row + '][company_name]"]').val(ui.item.label);
                $('input[name="product_shipping[' + shipping_row + '][company_id]"]').val(ui.item.id);
            }
        }).focus(function () {
            $(this).autocomplete("search", $(this).val());
        });

        $('input[name="product_shipping[' + shipping_row + '][processing_time]"]').autocomplete({
            minLength: 0,
            'classes': {
                "ui-autocomplete": "custom-ui-autocomplete"
            },
            'source': function (request, response) {

                $.ajax({
                    url: fcom.makeUrl('seller', 'shippingMethodDurationAutocomplete'),
                    data: { keyword: request['term'], fIsAjax: 1 },
                    dataType: 'json',
                    type: 'post',
                    success: function (json) {
                        response($.map(json, function (item) {
                            return { label: item['name'] + '[' + item['duraion'] + ']', value: item['duraion'], id: item['id'] };
                        }));
                    },
                });
            },
            select: function (event, ui) {
                $('input[name="product_shipping[' + shipping_row + '][processing_time]"]').val(ui.item.label);
                $('input[name="product_shipping[' + shipping_row + '][processing_time_id]"]').val(ui.item.id);
            }
        }).focus(function () {
            $(this).autocomplete("search", $(this).val());
        });
    }


    popupImage = function (inputBtn) {
        if (inputBtn.files && inputBtn.files[0]) {
            // $.ykmodal(fcom.getLoader(), '', 'cropper-body');
            fcom.ajax(fcom.makeUrl('Seller', 'imgCropper'), '', function (t) {
                // $.ykmodal(t );
                $('#cropperBox-js').html(t);
                $('#cropperBox-js').css("display", "block");
                $("#mediaForm-js").css("display", "none");
                var file = inputBtn.files[0];
                var minWidth = document.imageFrm.min_width.value;
                var minHeight = document.imageFrm.min_height.value;
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
                return cropImage(file, options, 'uploadImages', inputBtn);
            });
        }
    };

    uploadImages = function (formData) {
        var product_id = document.imageFrm.product_id.value;
        var option_id = document.imageFrm.option_id.value;
        var lang_id = document.imageFrm.lang_id.value;
        formData.append('product_id', product_id);
        formData.append('option_id', option_id);
        formData.append('lang_id', lang_id);
        $.ajax({
            url: fcom.makeUrl('Seller', 'setupCustomProductImages'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#loader-js').prepend(fcom.getLoader());
            },
            success: function (ans) {
                fcom.removeLoader();
                if (ans.status == 1) {
                    fcom.displaySuccessMessage(ans.msg);
                } else {
                    fcom.displayErrorMessage(ans.msg);
                }
                productImages($('#frmCustomProductImage input[name=product_id]').val(), $('.option').val(), $('.language').val());
                $('#prod_image').val('');
                //
                $('#cropperBox-js').css("display", "none");
                $("#mediaForm-js").css("display", "block");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    fileLinkForm = function (recordId) {
        fcom.updateWithAjax(fcom.makeUrl('Products', "fileLinkForm", [recordId]), "", function (t) {
            fcom.removeLoader();
            $.ykmodal(t.html, false, 'modal-dialog-vertical-md');
            $.ykmsg.close();
            getDigitalDownloads(0, recordId);
        });
    };

    getDigitalDownloads = function (downloadType, recordId, langId = 0, optionCombi = 0) {
        let data = { recordId, download_type: downloadType, option_comb: optionCombi, langId: langId, showNoRecordFound: 1 };
        if (downloadType == 1) {
            fcom.updateWithAjax(fcom.makeUrl('Products', 'getDigitalDownloadLinks'), data, function (res) {
                $.ykmsg.close();
                $("#digitalFrmListJs").html(res.html);
            });
        } else {
            fcom.updateWithAjax(fcom.makeUrl('Products', 'getDigitalDownloadAttachments'), data, function (res) {
                $.ykmsg.close();
                $("#digitalFrmListJs").html(res.html);
            });
        }
    };

    deleteCatalog = function (recordId) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        data = "recordId=" + recordId;
        fcom.updateWithAjax(
            fcom.makeUrl('Seller', "deleteCatalog"),
            data,
            function (t) {
                fcom.displaySuccessMessage(t.msg);
                searchCatalogProducts(document.frmRecordSearch);
            }
        );
    };

    productMissingInfo = function (selProdId) {
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'productMissingInfo'), { recordId: selProdId }, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();

        });
    }

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

    showActionsBtns = function () {
        if (typeof $(".selectItemJs:checked").val() === "undefined") {
            $(".formActionBtn-js").addClass("btn-outline-gray disabled").removeClass("btn-outline-brand selected");
        } else {
            $(".formActionBtn-js").removeClass("btn-outline-gray disabled").addClass("btn-outline-brand selected");
        }
    };

    toggleBulkStatues = function (status, confirmMsg = "") {
        var element = "form.actionButtonsJs";
        if (1 > $(element).length) {
            fcom.displayErrorMessage(langLbl.actionButtonsClass);
            return false;
        }

        if ('' != confirmMsg && !confirm(confirmMsg)) {
            return false;
        }

        $(element).attr("action", fcom.makeUrl(controllerName, "toggleBulkStatusesForCatalogs"));
        $(element + " input[name='status']").val(status);
        $(element).submit();
    };

    formAction = function (frm) {
        if (typeof $(".selectItemJs:checked").val() === "undefined") {
            fcom.displayErrorMessage(langLbl.atleastOneRecord);
            return false;
        }

        if (0 < $('.listingTableJs').length) {
            $('.listingTableJs').prepend(fcom.getLoader());
        }

        data = fcom.frmData(frm);

        fcom.updateWithAjax(frm.action, data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
            $(".selectAllJs").prop("checked", false);
            searchCatalogProducts(document.frmRecordSearch);
            showActionsBtns();
            $(".toolbarBtnJs").addClass("btn-outline-gray disabled").removeClass("btn-outline-brand selected");
        });
    };

    updateStatus = function (e, obj, recordId, status) {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.displayProcessing();
        e.stopPropagation();

        var oldStatus = $(obj).attr("data-old-status");
        $('.listingTableJs').prepend(fcom.getLoader());

        if (1 > recordId) {
            $(obj).prop("checked", 1 == oldStatus);
            fcom.displayErrorMessage(langLbl.invalidRequest);
            fcom.removeLoader();
            return false;
        }

        data = "recordId=" + recordId + "&status=" + status;
        fcom.ajax(fcom.makeUrl(controllerName, "updateCatalogStatus"), data,
            function (ans) {
                fcom.removeLoader();
                fcom.closeProcessing();
                $(obj).prop("checked", 1 == status);
                if (ans.status == 1) {
                    fcom.displaySuccessMessage(ans.msg);
                    $(obj).attr({ onclick: "updateStatus(event, this, " + recordId + ", " + oldStatus + "')", "data-old-status": status });                    
                } else {
                    $(obj).prop("checked", 1 == oldStatus);
                    fcom.displayErrorMessage(ans.msg);
                }
                fcom.removeLoader();
            }, { 'fOutMode': 'json' }
        );
    };
})();