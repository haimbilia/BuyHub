
(function () {
    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), {}, '', function () {
            clearSearch();
        });
    };
    editRecord = function (recordId, profileId, displayInPopup = false, dialogClass = '') {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();
        $.ykmodal(fcom.getLoader(), displayInPopup, dialogClass);
        data = "recordId=" + recordId + '&profileId=' + profileId;
        fcom.ajax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            $.ykmodal(t, true, dialogClass);
            fcom.removeLoader();
        });
    };

    viewSellerShip = function (productId) {
        fcom.ajax(fcom.makeUrl('ShippedProducts', 'viewSellerList'), {productId: productId}, function (t) {
            $.ykmodal(t, false, '');
        });
    };

    viewAdminSellerShip = function (productId) {
        fcom.ajax(fcom.makeUrl('ShippedProducts', 'viewSellerList'), {productId: productId, adminShip: 1}, function (t) {
            $.ykmodal(t, false, '');
        });
    };

})();
$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});
