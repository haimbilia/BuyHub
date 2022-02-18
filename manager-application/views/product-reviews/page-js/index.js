$(document).ready(function () {
    bindUserSelect2('searchFrmSellerIdJs');
});
(function () {
    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), { user_is_seller: 1, joinOrder: 1, order_type: 1 }, '', function () {
            clearSearch();
        });
    }

    displayImageInFacebox = function (href) {
        loadCropperSkeleton();
        $("#modalBoxJs .modal-body").html(`<image width='100%' src='${href}' />`);
    }
})();