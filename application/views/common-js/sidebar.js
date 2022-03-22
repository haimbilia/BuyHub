
$(document).on("click", ".resetModalFormJs", function (e) {
    if ($.ykmodal.isSideBarView()) {
        $.ykmodal(fcom.getLoader());
    }

    var onClear = $(".modalFormJs").data("onclear");
    if ('undefined' != typeof onClear) {
        eval(onClear);
    } else if (0 < $("." + $.ykmodal.element + " .navTabsJs .nav-link").length) {
        $("." + $.ykmodal.element + " .navTabsJs .nav-link.active").click();
    }
});