$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});
(function () {
    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), { user_is_buyer: 1, joinOrder: 1, order_type: 1 }, '', function () {
            clearSearch();
        });
    }

    redirectUser = function (id) {
        redirectfunc(fcom.makeUrl('Users'), { user_id: id }, 0, true);
    };
    
    viewSellerOrder = function (id) {
        redirectfunc(fcom.makeUrl('SellerOrders'), { order_id: id }, 0, true);
    };
})();
