$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});
(function () {
    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), { user_is_supplier: 1, joinOrder: 1, order_type: 2 });
    }
})();
