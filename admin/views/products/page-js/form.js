$(document).on('change', '.cartTypeJs', function () {
    $('.selprodHidePriceBlockJs').hide();
    /* RFQ Only: 2 */
    if (2 == $(this).val()) {
        $('.selprodHidePriceBlockJs').show();
    }
});

$(document).ready(function () {
    $("#selprod_track_inventory").trigger('change');
    $(".cartTypeJs").trigger('change');
});


(function () {
    getCurrentFrmLangId = function () {
        return $("#addProductfrm [name='lang_id']").val();
    };

    getCurrentFrmRecordId = function () {
        return $("#addProductfrm [name='record_id']").val();
    };

    getCurrentFrmTempProductId = function () {
        return $("#addProductfrm [name='temp_product_id']").val();
    };

    setup = function (frm) {
        if (!$(frm).validate()) {
            $('html,body').stop().animate({
                scrollTop: $('.error:first').offset().top - ($('.mainHeaderJs').height() + 50),
            });
            return;
        }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Products', 'setup'), data, function (t) {
            $(".cartTypeJs").trigger('change');
            fcom.displaySuccessMessage(t.msg);
            langForm(t.langId, 0, t.recordId);
        });
    };

    langForm = function (langId = 0, autoFillLangData = 0, recordId = 0) {
        recordId = recordId || getCurrentFrmRecordId();
        langId = langId || $("#addProductfrm [name='lang_id']").val();
        $('.productWrapper').prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('Products', 'form', [recordId]), { langId, autoFillLangData }, function (res) {
            fcom.closeProcessing();
            $('.mainJs').replaceWith(res.html);
            $(".cartTypeJs").trigger('change');
        });
    };

    productType = function (el) {
        let recordId = getCurrentFrmRecordId();
        let langId = $("#addProductfrm [name='lang_id']").val();
        let productType = $(el).val();
        $('.productWrapper').prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('Products', 'form', [recordId, productType]), { langId }, function (res) {
            fcom.closeProcessing();
            $('.mainJs').replaceWith(res.html);
        });
    };

    addBrand = function () {
        fcom.resetEditorInstance();
        fcom.updateWithAjax(fcom.makeUrl('Brands', "form"), "", function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    addCategory = function () {
        fcom.resetEditorInstance();
        fcom.updateWithAjax(fcom.makeUrl('ProductCategories', "form"), "", function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };
    addTaxCategory = function () {
        fcom.resetEditorInstance();
        fcom.updateWithAjax(fcom.makeUrl('TaxCategories', "form"), "", function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };
    addShippingPackage = function () {
        fcom.resetEditorInstance();
        fcom.updateWithAjax(fcom.makeUrl('shippingPackages', "form"), "", function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };
    addTagData = function (e) {
        let rt_id = e.detail.data.id;
        if (rt_id == '' || rt_id == undefined) {
            if (1 > canEditTags) {
                fcom.displayErrorMessage(tagsEditErr);
                e.detail.tag.remove();
                return;
            }
        }
    };

    removeTagData = function (e) {
        var tag_id = e.detail.tag.id;
        var product_id = getCurrentFrmRecordId();
        if (1 > product_id || '' == tag_id) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Products', 'removeProductTag'), 'product_id=' + product_id + '&tag_id=' + tag_id, function (t) {
            fcom.closeProcessing();
        });
        tagifyProducts();
    };

    getTagsAutoComplete = function (e) {

        let keyword = e.detail.value;
        let langId = getCurrentFrmLangId();
        var list = [];
        fcom.ajax(fcom.makeUrl('Tags', 'autoComplete'), { keyword, langId }, function (t) {
            var ans = $.parseJSON(t);
            for (i = 0; i < ans.length; i++) {
                list.push({
                    "id": ans[i].tag_id,
                    "value": ans[i].tag_name,
                });
            }
            tagify.settings.whitelist = list;
            tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    };

    tagifyProducts = function () {
        var element = '#product_tags';
        if ('undefined' !== typeof $(element).attr('disabled')) {
            return;
        }
        $(element).siblings(".tagify").remove();
        tagify = new Tagify(document.querySelector(element), {
            whitelist: [],
            delimiters: "#",
            editTags: false,
        }).on('add', addTagData).on('remove', removeTagData).on('input', getTagsAutoComplete).on('dropdown:select', addTagData).on('focus', getTagsAutoComplete);
    };

    addSpecification = function () {
        let appendEle = $('#specificationsListJs');

        let label = $('#sp_label').val();
        let value = $('#sp_value').val();
        let group = $('#sp_group').val();
        let prodSpecId = parseInt($('#sp_id').val());
        if (prodSpecId == NaN) {
            prodSpecId = 0;
        }
        if (!validateSpeficationForm()) {
            return;
        }

        $('#specificationsListSeprJs').removeClass('hide');

        let rowCount = appendEle.find('tbody tr.editRowJs').length ? appendEle.find("tbody tr").index($(".editRowJs")) : appendEle.find('tbody tr').length;

        let html = '<tr data-id="' + prodSpecId + '">';
        html += '<td class="nameJs text-break">' + label + '<input type="hidden" name="specifications[' + rowCount + '][name]" value="' + label + '"  data-fatreq="{&quot;required&quot;:false}"/> </td>';
        html += '<td class="valueJs text-break">' + value + '<input type="hidden" name="specifications[' + rowCount + '][value]" value="' + value + '" data-fatreq="{&quot;required&quot;:false}" /> </td>';
        html += '<td class="groupJs text-break">' + group + '<input type="hidden" name="specifications[' + rowCount + '][group]"  value="' + group + '" data-fatreq="{&quot;required&quot;:false}" /> </td>';
        html += '<td class="align-right"><ul class="actions">' +
            '<li><input type="hidden" name="specifications[' + rowCount + '][id]" value="' + prodSpecId + '"  data-fatreq="{&quot;required&quot;:false}"/>' +
            '<a href="javascript:void(0)"  onclick="editProdSpec(this)">' +
            '<svg class="svg" width="18" height="18">' +
            '<use xlink:href="' + siteConstants.webroot + 'images/retina/sprite-actions.svg#edit">' +
            '</use>' +
            '</svg>' +
            '</a></li>' +
            '<li>' +
            '<a href="javascript:void(0)" onclick="deleteProdSpec(this)">' +
            '<svg class="svg" width="18" height="18">' +
            '<use xlink:href="' + siteConstants.webroot + 'images/retina/sprite-actions.svg#delete">' +
            '</use>' +
            '</svg>' +
            '</a></li>' +
            '</td>';
        html += '</ul></tr>';

        if (appendEle.find('.editRowJs').length) {
            appendEle.find('.editRowJs').replaceWith(html);
        } else {
            appendEle.find('tbody').append(html);
        }

        if (appendEle.find('table').hasClass('hide')) {
            appendEle.find('table').removeClass('hide');
            fixTableColumnWidth();
        }

        $('#sp_label').val('');
        $('#sp_value').val('');
        $('#sp_group').val('');
        $('#sp_id').val(0);
        $('#btnAddSpecJs').text($('#btnAddSpecJs').data('addlbl'));

    };
    validateSpeficationForm = function () {
        let validate = true;
        $('#specificationsFormJs input').each(function () {
            if ($(this).data('change-event-bind') != 1) {
                $("input").change(function () {
                    $(this).siblings('ul').remove();
                });
                $(this).data('change-event-bind', 1);
            }
            $(this).siblings('ul').remove();
            if ($(this).data('required') == 1 && '' == $(this).val()) {
                let caption = $(this).siblings('label').text().trim();
                errorlist = $(document.createElement("ul")).addClass('errorlist').append(
                    $(document.createElement('li')).append($(document.createElement('a')).html(caption + " " + langLbl.isMandatory,).attr({ 'href': 'javascript:void(0);' }))
                );
                $(this).after(errorlist);
                validate = false;
            }
        });
        return validate;
    };

    prodSpecifications = function () {
        var recordId = getCurrentFrmRecordId();
        var langId = $("#addProductfrm [name='lang_id']").val();
        fcom.ajax(fcom.makeUrl('Products', 'prodSpecifications'), { recordId, langId }, function (res) {
            $('#specificationsListJs').html(res.html);
            if ($('#specificationsListJs').find('table tbody tr').length == 0) {
                $('#specificationsListJs').find('table').addClass('hide');
                $('#specificationsListSeprJs').addClass('hide');
            }
            fixTableColumnWidth();
        }, { fOutMode: 'json' });
    };

    editProdSpec = function (el) {
        let trEle = $(el).closest('tr');
        let prodSpecId = parseInt(trEle.data('id'));
        if (prodSpecId == NaN) {
            prodSpecId = 0;
        }

        let label = trEle.find('.nameJs').text();
        let value = trEle.find('.valueJs').text();
        let group = trEle.find('.groupJs').text();
        trEle.siblings().removeClass('editRowJs');
        trEle.addClass('editRowJs');

        $('#sp_label').val(label);
        $('#sp_value').val(value);
        $('#sp_group').val(group);
        $('#sp_id').val(prodSpecId);
        $('#btnAddSpecJs').text($('#btnAddSpecJs').data('updatelbl'));
        $('html,body').stop().animate({
            scrollTop: $('#specifications').offset().top - ($('.mainHeaderJs').height() + 50),
        });
    };

    clearProdSpecForm = function () {
        $('#sp_label, #sp_value, #sp_group').val('');
        $('#sp_id').val(0);
        $('#btnAddSpecJs').text($('#btnAddSpecJs').data('addlbl'));
        $('#specificationsListJs tr.editRowJs').removeClass('editRowJs');
    };

    deleteProdSpec = function (el) {
        let prodSpecId = $(el).closest('tr').data('id');
        let prodSpecLangId = $(el).data('langId');
        if (1 > prodSpecId) {
            $(el).closest('tr').remove();
            if ($('#specificationsListJs').find('table tbody tr').length == 0) {
                $('#specificationsListJs').find('table').addClass('hide');
                $('#specificationsListSeprJs').addClass('hide');
            }
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Products', 'deleteProdSpec'), { prodSpecId, prodSpecLangId }, function (t) {
            fcom.displaySuccessMessage(t.msg);
            prodSpecifications();
        });
    };

    getShippingProfileOptions = function (userId) {
        let langId = getCurrentFrmLangId();
        fcom.ajax(fcom.makeUrl('Products', 'getShippingProfileOptions'), { userId, langId }, function (t) {
            if (t.showShippingProfile == 0) {
                $('#shipping_profile').data('showShippingProfile', t.showShippingProfile);
                $('#shipping_profile').html('').parent().parent().addClass('hide');
            } else {
                $('#shipping_profile').data('showShippingProfile', t.showShippingProfile);
                $('#shipping_profile').html('').parent().parent().removeClass('hide');
                $.each(t.shipProfileArr, function (id, name) {
                    $('#shipping_profile').append(`<option value="${id}">
                            ${name}
                    </option>`);
                });
                $('#shipping_profile').val(shippingProfileId);
            }
            $('#product_fulfillment_type').html('');
            $.each(t.fullfilmentOptions, function (id, name) {
                $('#product_fulfillment_type').append(`<option value="${id}">
                        ${name}
                </option>`);
            });
            $('#product_fulfillment_type').val(prodFulfilementType).trigger('change');
        }, { fOutMode: 'json' });
    };

    imageForm = function () {
        let recordId = getCurrentFrmRecordId();
        let tempProductId = getCurrentFrmTempProductId();
        if (1 > recordId) {
            if (tempProductId == undefined) {
                console.warn('temp product id is manatory');
                return;
            }
        }
        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('Products', "imageForm", [recordId, tempProductId]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            loadImageOptions();
            var fileType = $('#image_file_type').val();
            var recordId = $('#image_record_id').val();
            productImages(recordId, fileType);
        });
    };
    loadImageOptions = function () {
        $('#addProductfrm .optionsJs').each(function () {
            let data = $(this).select2('data');
            if (data.length) {
                data = data[0];
                if (data.option_is_separate_images == 1) {
                    let optionValueData = $.parseJSON($(this).closest('.rowJs').find('input.optionValuesJs').val());
                    let optionIdEl = $('#image_option_id');
                    optionIdEl.html(`<option value="0">
                    ${forAllOptionsLbl}
                    </option>`);

                    $.each(optionValueData, function (index, opval) {
                        optionIdEl.append(`<option value="${opval.id}">
                            ${opval.value}
                            </option>`);

                    });
                    return false;
                }
            }

        })
    };

    productImagesCallback = function (t) {
        productImages(t.product_id, t.file_type, t.option_id, t.lang_id)
        if (t.isDefaultLayout) {
            productDefaultImages();
        }

    };

    productImages = function (product_id, file_type, option_id = 0, lang_id = 0) {
        fcom.updateWithAjax(fcom.makeUrl('Products', 'images', [product_id, file_type, option_id, lang_id]), '', function (t) {
            fcom.closeProcessing();
            $('#productImagesJs').html(t.html);
            $("#productImagesJs").sortable({
                stop: function () {
                    var mysortarr = new Array();
                    $(this).find('li').each(function () {
                        mysortarr.push($(this).attr("id"));
                    });

                    var sort = mysortarr.join('-');
                    var lang_id = $('.language-js').val();
                    var record_id = $('#image_record_id').val();
                    var option_id = $('#image_option_id').val();
                    var option_id = $('#image_option_id').val();
                    var file_type = $('#image_file_type').val();
                    fcom.updateWithAjax(fcom.makeUrl('products', 'setImageOrder'), {
                        record_id,
                        file_type,
                        ids: sort
                    }, function () { fcom.closeProcessing(); });
                }
            }).disableSelection();

        });
    };

    deleteImage = function (product_id, image_id, file_type) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) { return false; }
        fcom.ajax(fcom.makeUrl('Products', 'deleteImage', [product_id, image_id, file_type]), '', function (t) {
            var ans = $.parseJSON(t);
            if (ans.status == 0) {
                fcom.displayErrorMessage(ans.msg);
                return;
            } else {
                fcom.displaySuccessMessage(ans.msg);
            }
            productImages(product_id, file_type, ans.optionId, ans.langId);
            if (ans.isDefaultLayout) {
                productDefaultImages();
            }
        });
    };

    optionValuesChanges = function (e) {
        upcType();
    }

    getOptionValues = function (e) {
        let optionId = $(e.detail.tagify.DOM.originalInput).closest('.rowJs').find('.optionsJs').val();
        if (optionId == null) {
            e.detail.tagify.settings.whitelist = [];
            e.detail.tagify.removeAllTags();
            return;
        }

        var keyword = e.detail.value;
        var list = [];
        fcom.ajax(fcom.makeUrl('OptionValues', 'autoComplete'), {
            keyword: keyword,
            optionId: optionId,
            langId: getCurrentFrmLangId()
        }, function (t) {
            var ans = JSON.parse(t);
            $(ans['results']).each(function (id, val) {
                list.push({
                    "id": val.id,
                    "value": val.text,
                });
            });
            e.detail.tagify.settings.whitelist = list;
            e.detail.tagify.loading(false).dropdown.show.call(tagify, keyword);
        });
    }

    tagifyOptionValue = function (element) {
        let index = $(element).data('index');
        let value = $.parseJSON($(element).val());
        $(element).siblings(".tagify").remove();
        var tagify = new Tagify(document.querySelector(element), {
            whitelist: value,
            delimiters: "#",
            dropdown: {
                enabled: 0,
                classname: "tags-look",
            },
            enforceWhitelist: true,
            skipInvalid: true,
            hooks: {
                beforeRemoveTag: function (tags) {
                    return new Promise((resolve, reject) => {
                        let recordId = getCurrentFrmRecordId();
                        if (0 < recordId) {
                            let optionId = $(element).closest('.rowJs').find('.optionsJs').val()
                            let optionValueId = tags[0]['data']['id'];
                            fcom.ajax(fcom.makeUrl('Products', "canDeleteOpValue"), { recordId, optionId, optionValueId }, function (t) {
                                t = $.parseJSON(t);
                                if (t.status == 0) {
                                    fcom.displayErrorMessage(t.msg);
                                    reject();
                                } else {
                                    resolve();
                                }
                            });
                        } else {
                            resolve();
                        }
                    })
                }
            },
        })
            .on('input', getOptionValues).on('focus', getOptionValues)
            .on('change', optionValuesChanges);
        tagifyObjs[index] = tagify;
    };

    upcType = function () {
        if (typeof upcTypeTriggerEvent != 'undefined') {
            clearTimeout(upcTypeTriggerEvent);
        }
        upcTypeTriggerEvent = setTimeout(function () {
            $('#variantsListJs').prepend(fcom.getLoader(false));
            let type = $('.upc_type:checked').val();
            let recordId = getCurrentFrmRecordId();
            let langId = getCurrentFrmLangId();

            let productOptions = {};
            if (type == 0) {
                $('#addProductfrm select.optionsJs').each(function () {
                    let optionData = $(this).select2('data');
                    if (1 < optionData.length) {
                        return;
                    }

                    optionData = optionData[0];
                    let optionValueData = $(this).closest('.rowJs').find('input.optionValuesJs').val();
                    if (optionValueData == '') {
                        return;
                    }
                    optionValueData = jQuery.parseJSON(optionValueData);

                    productOptions[optionData.id] = { option_id: optionData.id, option_name: optionData.text, optionValues: {} };

                    $.each(optionValueData, function (index, opval) {
                        productOptions[optionData.id]['optionValues'][opval.id] = opval.value;
                    });
                });
            }
            fcom.ajax(fcom.makeUrl('Products', "upcListing"), { recordId, langId, type, productOptions }, function (t) {
                $('#variantsListJs').html(t.html);
                fcom.removeLoader();
                $('.mainJs').removeClass('isLoading');
            }, { fOutMode: 'json' });
        }, 2000);
    };
    loadCropper = function (inputBtn) {
        if (inputBtn.files && inputBtn.files[0]) {
            if (!validateFileUpload(inputBtn.files[0])) {
                return;
            }
            loadCropperSkeleton(false);
            $("#modalBoxJs .modal-title").text($(inputBtn).attr('data-name'));
            fcom.ajax(fcom.makeUrl('Products', "imgCropper"), "", function (t) {
                t = $.parseJSON(t);
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);
                var file = inputBtn.files[0];

                var frmName = $(inputBtn).closest('form').attr('name');
                var minWidth = document[frmName].min_width.value;
                var minHeight = document[frmName].min_height.value;

                var options = {
                    aspectRatio: minWidth / minHeight,
                    data: {
                        width: minWidth,
                        height: minHeight,
                    },
                    minCropBoxWidth: minWidth,
                    minCropBoxHeight: minHeight,
                    toggleDragModeOnDblclick: false,
                    imageSmoothingQuality: "high",
                    imageSmoothingEnabled: true,
                };
                $(inputBtn).val("");
                setTimeout(function () { cropImage(file, options, "mediaUpload", inputBtn) }, 100);
                return;
            });
        }
    };

    mediaUpload = function (formData) {
        var frmName = formData.get("frmName");
        var frm = document.forms[frmName];
        var other_data = $('form[name="' + frmName + '"]').serializeArray();
        $.each(other_data, function (key, input) {
            formData.append(input.name, input.value);
        });

        $.ajax({
            url: fcom.makeUrl('Products', "uploadMedia"),
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#modalBoxJs .modal-body").prepend(fcom.getLoader());
            },
            success: function (ans) {
                if (ans.status == 0) {
                    fcom.displayErrorMessage(ans.msg);
                    return;
                }
                autoOpenSideBar = false;
                $("#modalBoxJs").modal("hide");
                fcom.displaySuccessMessage(ans.msg);
                if (ans.isDefaultLayout) {
                    productDefaultImages();
                }
                fcom.removeLoader();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                fcom.displayErrorMessage(
                    thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText
                );
            },
        });
    };

    productDefaultImages = function () {
        let recordId = getCurrentFrmRecordId();
        fileType = 0;
        if (1 > recordId) {
            recordId = getCurrentFrmTempProductId();
            fileType = tempImageType;
        }
        fcom.ajax(fcom.makeUrl('Products', 'images', [recordId, fileType, 0, 0]), { isDefaultLayout: 1 }, function (t) {
            $('#productDefaultImagesJs li').not(":first").remove();
            $('#productDefaultImagesJs').append(t.html);
            $("#productDefaultImagesJs").sortable({
                items: "li:not(.unsortableJs)",
                stop: function () {
                    var mysortarr = new Array();
                    $(this).find('li').each(function () {
                        mysortarr.push($(this).attr("id"));
                    });

                    var sort = mysortarr.join('-');
                    var record_id = $('#hiddenMediaFrmJs').find('[name="record_id"]').val();
                    var file_type = $('#hiddenMediaFrmJs').find('[name="file_type"]').val();
                    fcom.updateWithAjax(fcom.makeUrl('products', 'setImageOrder'), {
                        record_id,
                        file_type,
                        ids: sort
                    }, function (t) { fcom.displaySuccessMessage(t.msg) });
                }
            }).disableSelection();
        }, { fOutMode: 'json' });
    };

    digitalDownloadsForm = function (type, callback = '') {
        $.ykmodal(fcom.getLoader(), false, 'modal-dialog-vertical-md');
        let recordId = getCurrentFrmRecordId();
        fcom.updateWithAjax(fcom.makeUrl('Products', "digitalDownloadForm", [recordId, type]), "", function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, false, 'modal-dialog-vertical-md');
            if (typeof callback == 'function') {
                callback();
            } else {
                getDigitalDownloads(type, recordId);
            }
        });
    };

    setupDigitalDownload = function (frm) {
        if (!frm.validate()) { return; }
        var data = new FormData();
        data.append('fIsAjax', 1);
        frm.find('select,input[type=hidden],input[type=text]').each(function () {
            data.append(this.name, $(this).val());
        });

        frm.find('input[type=file]').each(function (i, v) {
            data.append(v.name, v.files[0]);
        });

        $.ykmodal(fcom.getLoader());
        $.ajax({
            url: fcom.makeUrl('Products', 'setupDigitalDownload'),
            type: "POST",
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (t) {
                fcom.removeLoader();
                if (t.status == 0) {
                    fcom.displayErrorMessage(t.msg);
                    return;
                }
                fcom.displaySuccessMessage(t.msg);
                frm.find('input[type=file],input[type=text]').each(function (i, v) {
                    $(v).val('');
                });
                digitalDownloadsForm(t.downloadType, function () {
                    $(".option-comb-id-js").val(t.optionComb);
                    $(".file-language-js").val(t.langId);
                    getDigitalDownloads(t.downloadType, t.recordId, t.langId, t.optionComb);
                })

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error Occurred.");
            }
        });
    };

    getDigitalDownloads = function (downloadType, recordId, langId = 0, optionCombi = 0) {
        let data = { recordId, download_type: downloadType, option_comb: optionCombi, langId: langId };
        if (downloadType == 1) {
            fcom.ajax(fcom.makeUrl('Products', 'getDigitalDownloadLinks'), data, function (res) {
                if (langId == 0 && optionCombi == 0) {
                    $("#digitalLinksDefaultListJs").html(res.html);
                    if (res.html == '') {
                        $('#digital-link-block').collapse('hide');
                        $('#digital-links').find('.dropdown-toggle-custom').attr('data-bs-toggle', '');
                        $('#digital-links').find('.dropdown-toggle-custom-arrow').addClass('hide');
                    } else {
                        $('#digital-links').find('.dropdown-toggle-custom').attr('data-bs-toggle', 'collapse');
                        $('#digital-links').find('.dropdown-toggle-custom-arrow').removeClass('hide');
                        $('#digital-link-block').collapse('show');
                    }
                }
                $("#digitalFrmListJs").html(res.html);
            }, { fOutMode: 'json' });
        } else {
            fcom.ajax(fcom.makeUrl('Products', 'getDigitalDownloadAttachments'), data, function (res) {
                if (langId == 0 && optionCombi == 0) {
                    $("#digitalFilesDefaultListJs").html(res.html);
                    if (res.html == '') {
                        $('#digital-file-block').collapse('hide');
                        $('#digital-files').find('.dropdown-toggle-custom').attr('data-bs-toggle', '');
                        $('#digital-files').find('.dropdown-toggle-custom-arrow').addClass('hide');
                    } else {
                        $('#digital-files').find('.dropdown-toggle-custom').attr('data-bs-toggle', 'collapse');
                        $('#digital-files').find('.dropdown-toggle-custom-arrow').removeClass('hide');
                        $('#digital-file-block').collapse('show');
                    }
                }

                $("#digitalFrmListJs").html(res.html);
            }, { fOutMode: 'json' });
        }
    };

    attachDigitalPreviewFile = function (option, langId, refId, subRefId) {
        digitalDownloadsForm(typeDigitalFile, function () {
            $(".option-comb-id-js").val(option);
            $(".file-language-js").val(langId);
            $('#digitalDownloadFrm input[name=dd_link_id]').val(refId);
            $('#digitalDownloadFrm input[name=dd_link_ref_id]').val(subRefId);
            $("#downloadableFileMainJs").hide();
            $('#digitalDownloadFrm input[name=is_preview]').val(1);
            $('#digitalDownloadFrm input[name=ref_file_id]').val(subRefId);

        });
    };

    deleteDigitalFile = function (afileId, prodId, isPreview, fullRow) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) { return false; }

        var isPreview = isPreview || 0;
        var fullRow = fullRow || 0;

        var data = '&afile_id=' + afileId + '&ref_id=' + prodId;
        if (1 == isPreview) {
            data += '&is_preview=1'
        }
        data += '&frow=' + fullRow;

        fcom.updateWithAjax(fcom.makeUrl('Products', 'deleteDigitalFile'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            let recordId = getCurrentFrmRecordId();
            let langId = $('#digitalFrmLangId').val() || 0;
            let optionComb = $('#digitalFrmOptionId').val() || 0;
            getDigitalDownloads(typeDigitalFile, recordId, langId, optionComb);
        });
    };

    deleteDigitallink = function (linkId, refId) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(fcom.makeUrl('Products', 'deleteDigitalLink', [linkId, refId]), '', function (t) {
            fcom.displaySuccessMessage(t.msg);
            let recordId = getCurrentFrmRecordId();
            getDigitalDownloads(typeDigitalLink, recordId);
        });
    };

    getUniqueSlugUrl = function (obj, str, recordId) {
        if (str == '') {
            return;
        }
        var data = { url_keyword: str, recordId: recordId }
        fcom.ajax(fcom.makeUrl('SellerProducts', 'isProductRewriteUrlUnique'), data, function (t) {
            var ans = $.parseJSON(t);
            $(obj).next().html(ans.msg);
            if (ans.status == 0) {
                $(obj).next().removeClass('text-muted').addClass('text-danger');
            } else {
                $(obj).next().addClass('text-muted').removeClass('text-danger');
            }
        });
    }
})();

/** on option select/deselect */
async function resetOptionValuesTag(e) {
    let recordId = getCurrentFrmRecordId();
    if (0 < recordId) {
        let optionId = e.params.args.data.id;
        if (e.type == 'select2:selecting') {
            optionId = 0;
            if ($(e.currentTarget).select2('data').length) {
                optionId = $(e.currentTarget).select2('data')[0].id || 0;
            }
        }

        if (0 < optionId) {
            e.preventDefault();
            let response = await $.ajax({
                url: fcom.makeUrl('Products', 'removeProductOption'),
                dataType: 'json',
                type: 'POST',
                data: { recordId, optionId, fIsAjax: 1 }
            });
            if (response.status != 1) {
                fcom.displayErrorMessage(response.msg);
                return;
            }
            if (e.type == 'select2:selecting') {
                var newOption = new Option(e.params.args.data.text, e.params.args.data.id, true, true);
                let currentEl = $(e.currentTarget);
                currentEl.append(newOption).trigger('change');
                currentEl.select2('close');
            } else {
                $(e.currentTarget).val(null).trigger("change");
            }
        }

        let index = $(e.target.closest('.rowJs')).find('input.optionValuesJs').data('index');
        if (index in tagifyObjs) {
            tagifyObjs[index].settings.whitelist = [];
            tagifyObjs[index].removeAllTags();
        }
    }

    let index = $(e.target.closest('.rowJs')).find('input.optionValuesJs').data('index');
    if (index in tagifyObjs) {
        tagifyObjs[index].settings.whitelist = [];
        tagifyObjs[index].removeAllTags();
    }

    if ('deleteRow' in e.params.args.data) {
        $(e.currentTarget).closest('.rowJs').remove();
    }
    upcType();
}

/** on select2 option  */
function optionDataCallback(ele) {
    let selectedSiblingOption = [];
    let hasSiblingWithImageOption = 0;
    ele.closest('.rowJs').siblings().find('.optionsJs')
        .each(function (i) {
            let data = $(this).select2('data');
            if (data.length) {
                data = data[0];
                if (hasSiblingWithImageOption == 0 && data['option_is_separate_images'] == 1) {
                    hasSiblingWithImageOption = 1;
                }
                selectedSiblingOption.push(data['id']);
            }
        });
    return {
        disAllowOptions: selectedSiblingOption,
        doNotIncludeImageOption: hasSiblingWithImageOption
    };
}

$(document).on('click', '.warrantyTypeJs', function () {
    let type = $(this).data('type');
    $(this).closest('div').siblings('.warrantyTypeButtonJs').text($(this).text());
    $("#product_warranty_unit").val(type);
});

$(document).on('change', '#product_fulfillment_type', function () {
    if ($('#shipping_profile').data('showShippingProfile') == 0) {
        return;
    }

    if ($(this).val() == fulfilmentTypePickup) {
        $('#shipping_profile').parent().parent().addClass('hide');
    } else {
        $('#shipping_profile').parent().parent().removeClass('hide');
    }
});

$(document).on('click', '.optionsAddJs', function () {
    let clonedRow = $('#variantCloneJs .rowJs').clone();
    let index = clonedRow.find('.optionValuesJs').data('index');
    let newIndex = $('#variantsJs .rowJs').length + 1;
    let optionId = clonedRow.find('.optionsJs').attr('id').replace(index, "");
    let newOptionId = optionId + newIndex;
    clonedRow.find('.optionsJs').attr('id', newOptionId);

    let optionValueId = clonedRow.find('.optionValuesJs').attr('id').replace(index, "");
    let newOptionValueId = optionValueId + newIndex;
    clonedRow.find('.optionValuesJs').attr('id', newOptionValueId);

    clonedRow.removeClass('hide');
    clonedRow.find('.optionsAddJs').removeClass('hide');
    clonedRow.insertAfter('#variantsJs .rowJs:last');

    select2(newOptionId, fcom.makeUrl('Options', 'autoComplete'), optionDataCallback,
        resetOptionValuesTag,
        resetOptionValuesTag,
    );

    $('#' + newOptionId).data("select2").$container.addClass("custom-select2-width");
    tagifyOptionValue("#" + newOptionValueId);
});

$(document).on('click', '.optionsDeleteJs', function () {
    let el = $(this).closest('.rowJs').find('.optionsJs');
    let optionId = el.val();
    if (0 < optionId) {
        el.trigger({
            type: 'select2:unselecting',
            params: {
                args: { data: { id: optionId, deleteRow: 1 } },
            }
        });
    } else {
        $(this).closest('.rowJs').remove();
    }
});

$(document).on('change', '#image_option_id', function () {
    let optionId = $(this).val();
    let fileType = $('#image_file_type').val();
    let recordId = $('#image_record_id').val();
    let langId = $('#image_lang_id').val();
    productImages(recordId, fileType, optionId, langId);
});

$(document).on('change', '#image_lang_id', function () {
    let langId = $(this).val();
    let fileType = $('#image_file_type').val();
    let recordId = $('#image_record_id').val();
    let optionId = $('#image_option_id').val();
    productImages(recordId, fileType, optionId, langId);
});

$(document).on('change', '#digitalFrmLangId', function () {
    let langId = $(this).val();
    let optionCombi = $('#digitalFrmOptionId').val() || 0;
    let recordId = $('#digitalFrmRecordId').val();
    let downloadType = $('#digitalFrmdownloadType').val();
    getDigitalDownloads(downloadType, recordId, langId, optionCombi);
});

$(document).on('change', '#digitalFrmOptionId', function () {
    let optionCombi = $(this).val();
    let langId = $('#digitalFrmLangId').val();
    let recordId = $('#digitalFrmRecordId').val();
    let downloadType = $('#digitalFrmdownloadType').val();
    getDigitalDownloads(downloadType, recordId, langId, optionCombi);
});

$(document).on('click', '.stockNavJs > ul > li a', function (e) {
    $(this).closest('li').siblings().removeClass('is-active');
    $(this).closest('li').addClass('is-active');
});