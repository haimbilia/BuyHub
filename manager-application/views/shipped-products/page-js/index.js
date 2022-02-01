
(function () {
    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), {}, '', function () {
            clearSearch();
        });
    };

    editRecord = function (recordId, profileId) {
        $.ykmodal(fcom.getLoader(), true);
        data = "recordId=" + recordId + '&profileId=' + profileId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };

    viewSellerShip = function (productId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippedProducts', 'viewSellerList'), { productId: productId }, function (t) {
            $.ykmodal(t.html, false, '');
            fcom.removeLoader();
        });
    };

    viewAdminSellerShip = function (productId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippedProducts', 'viewSellerList'), { productId: productId, adminShip: 1 }, function (t) {
            $.ykmodal(t.html, false, '');
            fcom.removeLoader();
        });
    };

})();
$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});
