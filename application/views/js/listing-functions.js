$(function () {
    $(document).on('click', '#accordian li span.acc-trigger', function (e) {
        var link = $(this);
        var closest_ul = link.siblings("ul");
    });


    $('.productFilters-js').on('click', function (e) {
        /*  e.stopPropagation(); */
    });

});