$(document).ready(function () {
    if (0 < $('#searchFromSellerJs').length) {
        bindSearchUserSelect2("searchFromSellerJs", { user_is_supplier: 1, joinShop: 1, credential_active: 1, credential_verified: 1 });
    }

    if (0 < $('#searchFormConditionTypeJs').length) {
        $('#searchFormConditionTypeJs').select2({
            allowClear: true,
            placeholder: $('#searchFormConditionTypeJs').attr("placeholder")
        }).on("select2:unselecting", function (e) {
            clearSearch();
        }).on('select2:open', function(e) {   
			$('#searchFormConditionTypeJs').data("select2").$dropdown.addClass("custom-select2 custom-select2-single"); 
		})
		.data("select2").$container.addClass("custom-select2 custom-select2-single");
    }
});

$(document).on("change", "#recordTypeJs", function () {
    recordType = $(this).val();
    setRecordField();
});

$(window).on('load', function () {
    /* Mark Sidebar Nav Active. */
    markNavActive($("[data-selector*=" + objectCtrlName + "]"));
});

$(document).on('change', '#conditionTypeJs', function () {
    if ("" == $(this).val()) {
        $(this).val(COND_TYPE_AVG_RATING_SHOP).trigger('change');
        return;
    }

    var ratePercElements = [COND_TYPE_RETURN_ACCEPTANCE, COND_TYPE_ORDER_CANCELLED];

    var toSelector = $('#conditionToJs');

    toSelector.attr('data-fatreq', JSON.stringify({ required: true }));
    if (1 > $('#conditionToSectionJs label .spn_must_field').length) {
        $('#conditionToSectionJs label').append('<span class="spn_must_field">*</span>');
    }

    var htm = '<label class="label">' + langLbl.from + '<span class="spn_must_field">*</span></label>';
    $('#conditionFromSectionJs label').replaceWith(htm);

    if (-1 < jQuery.inArray(parseInt($(this).val()), ratePercElements)) {
        var htm = '<label class="label">' + langLbl.rateFromDecimal + '<span class="spn_must_field">*</span></label>';
        $('#conditionFromSectionJs label').replaceWith(htm);
        
        var htm = '<label class="label">' + langLbl.rateToDecimal + '<span class="spn_must_field">*</span></label>';
        $('#conditionToSectionJs label').replaceWith(htm);

    } else if (parseInt($(this).val()) == COND_TYPE_COMPLETED_ORDERS) {
        var htm = '<label class="label">' + langLbl.fromDigit + '<span class="spn_must_field">*</span></label>';
        $('#conditionFromSectionJs label').replaceWith(htm);

        var htm = '<label class="label">' + langLbl.toDigit + '<span class="spn_must_field">*</span></label>';
        $('#conditionToSectionJs label').replaceWith(htm);
    } else {
        var htm = '<label class="label">' + langLbl.fromDecimal + '<span class="spn_must_field">*</span></label>';
        $('#conditionFromSectionJs label').replaceWith(htm);

        var htm = '<label class="label">' + langLbl.toDecimal + '<span class="spn_must_field">*</span></label>';
        $('#conditionToSectionJs label').replaceWith(htm);
    }
});


(function () {
    editConditionRecord = function (badgeId, recordId = 0) {
        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        var data = (0 < recordId) ? ("recordId=" + recordId) : '';

        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'form', [badgeId]), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, false);
            fcom.removeLoader();
        });
    };

    bindSearchUserSelect2 = function (element, postedData) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), postedData, '', clearSearch);
    }

    bindUserSelect2 = function (element, postedData) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), postedData, function (resp) {
            sellerId = resp.params.args.data.id
            recordType = $('#recordTypeJs').val();
            setRecordField();
        }, clearSellerId);
    };

    clearSellerId = function () {
        sellerId = 0;
        setRecordField();
    }

    setRecordField = function () {
        $('#recordIdJs').val(null).trigger('change');
        if (RECORD_TYPE_SHOP == recordType) {
            $("#recordIdJs").prop('disabled', true);
            $("#recordIdSectionJs").hide();
        } else {
            bindRecordsSelect2();
        }
    }

    bindRecordsSelect2 = function (e) {
        $("#recordIdJs").removeAttr('disabled');
        $("#recordIdSectionJs").fadeIn();
        select2('recordIdJs', getRecordTypeURL(), function (obj) {
            var postedData = getRecordTypeSellerId();
            postedData['excludeRecords'] = obj.val();
            return postedData
        });
    };

    getRecordTypeSellerId = function () {
        if ("" == sellerId || 1 > sellerId) {
            console.error(langLbl.invalidRequest);
            return {};
        }

        if (RECORD_TYPE_PRODUCT == recordType) {
            return { product_seller_id: sellerId };
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return { selprod_user_id: sellerId };
        } else if (RECORD_TYPE_SHOP == recordType) {
            return { shop_user_id: sellerId };
        } else {
            console.error(langLbl.invalidRequest);
            return {};
        }
    }

    getRecordTypeURL = function () {
        if ("" == sellerId || 1 > sellerId) {
            console.error(langLbl.invalidRequest);
            return false;
        }
        if (RECORD_TYPE_PRODUCT == recordType) {
            return fcom.makeUrl('Products', 'autoComplete');
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return fcom.makeUrl('SellerProducts', 'autoComplete');
        } else if (RECORD_TYPE_SHOP == recordType) {
            return fcom.makeUrl('Shops', 'autoComplete');
        } else {
            console.error(langLbl.invalidRequest);
            return false;
        }
    }
})()