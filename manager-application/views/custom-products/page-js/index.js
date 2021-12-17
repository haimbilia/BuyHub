
$(function() {
    select2('searchFrmUserIdJs', fcom.makeUrl('Users', 'autoComplete'), {'joinShop' : 1, 'user_is_supplier' : 1}, '', function () {
        clearSearch();
    });
});