$(document).ready(function () {
    select2('searchFrmUserIdJs', fcom.makeUrl('Users', 'autoComplete'), { 'joinShop': 1, 'user_is_supplier': 1 });
    $("#prodcatIdJs").select2({
        dropdownParent: $("#prodcatIdJs").closest('form'),
        allowClear: true,
        placeholder: $("#prodcatIdJs").attr('placeholder')
    }).on('select2:open', function(e) {        
        $("#prodcatIdJs").data("select2").$dropdown.addClass("custom-select2 custom-select2-single");
    }).data("select2").$container.addClass("custom-select2-width custom-select2 custom-select2-single");

});