$(document).ready(function () {
    select2("searchFromSellerJs", fcom.makeUrl('Users', 'autoComplete'), { user_is_supplier: 1, joinShop: 1, credential_active: 1, credential_verified: 1 });
});

(function () {
    getRecordTypeURL = function () {
        var recordType = $('input[name="breq_record_type"]').val();
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

    getRecordTypeSellerId = function () {
        var recordType = $('input[name="breq_record_type"]').val();
        var sellerId = $("input[name='breq_user_id']").val();

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

    bindRecordsSelect2 = function (e) {
        select2('recordIdJs', getRecordTypeURL(), function (obj) {
            var postedData = getRecordTypeSellerId();
            postedData['excludeRecords'] = obj.val();
            return postedData
        });
    };
})();