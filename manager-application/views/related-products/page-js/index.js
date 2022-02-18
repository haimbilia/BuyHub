(function () {
    bindProductNameSelect2 = function () {
        select2("productNameJs", fcom.makeUrl(controllerName, 'autoCompleteProducts'), {}, function (res) {
            $('#sellerIdJs').val(res.params.args.data.selprod_user_id);
            $('#relatedProductsJs').removeAttr('disabled');
        }, function (res) {
            $('#relatedProductsJs option').remove();
            $('#relatedProductsJs').trigger('change').attr('disabled', 'disabled');
        });
    }
    
    bindlRelatedProdSelect2 = function () {
        select2('relatedProductsJs', fcom.makeUrl(controllerName, 'autoCompleteProducts'), function (obj) {
            return {
                'mainRecordId' : $('#productNameJs').val(),
                'selprod_user_id' : $('#sellerIdJs').val(),
                'excludeRecords' : obj.val(),
            };
        });
    }
})();