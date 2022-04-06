$(function () {
    new ScrollHint(".js-scrollable", {
        i18n: {
            scrollable: langLbl.scrollable,
        },
    });
});
$(document).ajaxComplete(function () {
    new ScrollHint(".js-scrollable:not(.scroll-hint)", {
        i18n: {
            scrollable: langLbl.scrollable,
        },
    });
    if (
        0 < $("div.block--empty").length &&
        0 < $("div.scroll-hint-icon-wrap").length
    ) {
        $("div.block--empty")
            .siblings(".js-scrollable.scroll-hint")
            .children("div.scroll-hint-icon-wrap")
            .remove();
    }
});