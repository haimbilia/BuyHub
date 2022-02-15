$(document).ready(function () {
    bindUserSelect2("buyerJs", { user_is_buyer: 1});
    bindUserSelect2("sellerJs", { user_is_supplier: 1, joinShop : 1});
    bindSellerProductsSelect2();
});
(function () {
    bindUserSelect2 = function (element, obj) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), obj);
    }

    bindSellerProductsSelect2 = function () {
        select2("oProductJs", fcom.makeUrl('Orders', 'itemAutoComplete'), {return_order : 1});
    };
    
    viewAdminComment = function (orrequestId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "viewAdminComment",[orrequestId]), '', function (t) {
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };
})();