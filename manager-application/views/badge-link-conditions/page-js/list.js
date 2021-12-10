$(document).ready(function () {
    if (0 < $('#searchFromSellerJs').length) {
        bindUserSelect2("searchFromSellerJs", { user_is_supplier: 1, joinShop: 1, credential_active: 1, credential_verified: 1 });
    }

    if (0 < $('#conditionTypeJs').length) {
        $('#conditionTypeJs').select2({
            allowClear: true,
            placeholder: $('#conditionTypeJs').attr("placeholder")
        }).on("select2:unselecting", function (e) {
            clearSearch();
        });
    }
});

(function () {
    editConditionRecord = function (badgeId, recordId = 0, displayInPopup = false) {
        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        $.ykmodal(fcom.getLoader(), displayInPopup);
        var data = (0 < recordId) ? ("recordId=" + recordId) : '';

        fcom.ajax(fcom.makeUrl(controllerName, 'form', [badgeId]), data, function (t) {
            $.ykmodal(t, displayInPopup);
            fcom.removeLoader();
        });
    };

    bindUserSelect2 = function (element, postedData) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), postedData, function (resp) {
            sellerId = resp.params.args.data.id
            recordType = $('#recordTypeJs').val();
            bindLinkToSelect2();
        }, clearSearch);
    };
    
    bindLinkToSelect2 = function (e) {
        select2('recordIdJs', getRecordTypeURL(), {}, '', function () {});
    };

    getRecordTypeURL = function () {
        if ("" == sellerId || 1 > sellerId || '' == recordType || 1 > recordType) {
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
            $.ykmsg.error(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }
})()