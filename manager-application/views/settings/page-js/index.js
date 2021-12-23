function searhSettings(e) {
    var value = e.val().toLowerCase();
    $(".settingListJs a").each(function () {
        if ($(this).find('h6').text().toLowerCase().search(value) > -1 || $(this).find('span').text()
            .toLowerCase().search(value) > -1) {
            $(this).show();
            $('.settingListJs').show();
        } else {
            $(this).hide();
            $('.settingListJs').show();
        }
    });
};

$(window).on('load', function () {
    /* Mark Sidebar Nav Active. */
    markNavActive($("[data-selector*=" + controllerName + "]"));
});

updateMaintenanceModeStatus = function (e, obj, status) {
    $('.settingListJs').prepend(fcom.getLoader());
    e.stopPropagation();
    var data = $(obj).attr('name') + '=' + status + '&form_type=' + formType;
    fcom.updateWithAjax(fcom.makeUrl('Configurations', 'setup'), data, function (t) {
        fcom.removeLoader();
    });
};

$(document).on("search", "#settingsSearch", function (e) {
    searhSettings($(this));
});

$(document).on("keyup", "#settingsSearch", function (e) {
    searhSettings($(this));
});

$(document).on("search", "input[name='search']", function () {
    if ("" == $(this).val()) {
        searhSettings($(this));
    }
});