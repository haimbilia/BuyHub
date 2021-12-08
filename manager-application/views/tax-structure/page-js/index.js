(function () {

})();

$(document).on("change", "input[name=taxstr_is_combined]", function () {
    $('.component_link').closest('.col-md-12').addClass('hide');
    if ($("input[name=taxstr_is_combined]").prop('checked') == true) {
        $('.component_link').closest('.col-md-12').removeClass('hide');
    }
});

$(document).on("click", ".add-combined-form--js", function () {  
    $(this).closest('.component_link').find('.rows').last().after($(this).closest('.row').clone());
    $(this).closest('.component_link').find('.rows').last().find('input[type=text]').val('');
    $(this).closest('.component_link').find('.rows').last().find('.move-combined-form--js').removeClass('hide');
    
});
$(document).on("click", ".remove-combined-form--js", function () {
    if ($('.component_link .rows').length == 1) {
        return;
    }
    $(this).closest('.rows').remove();
});
    