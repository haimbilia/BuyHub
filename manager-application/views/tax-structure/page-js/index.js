(function () {

})();

$(document).on("change", "input[name=taxstr_is_combined]", function () {
    $('.component_link').closest('.col-md-12').addClass('hide');
    if ($("input[name=taxstr_is_combined]").prop('checked') == true) {
        $('.component_link').closest('.col-md-12').removeClass('hide');
    }
});

$(document).on("click", ".add-combined-form--js", function () {
    $(this).closest('.row').after($(this).closest('.row').clone());
});
$(document).on("click", ".remove-combined-form--js", function () {
    if ($('.component_link .row').length == 1) {
        return;
    }
    $(this).closest('.row').remove();
});
    