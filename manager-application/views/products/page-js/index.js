$(document).ready(function () {
    select2('searchFrmUserIdJs', fcom.makeUrl('Users', 'autoComplete'), {'joinShop' : 1, 'user_is_supplier' : 1}, '', function () {
        clearSearch();
    });
    $("#prodcatIdJs").select2({
        dropdownParent: $("#prodcatIdJs").parent(),
        allowClear: true,
        placeholder: $("#prodcatIdJs").attr('placeholder')
    }).data("select2").$container.addClass("w-100");;
    
});