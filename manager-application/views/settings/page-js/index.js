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

        $('.noRecordFoundJs').parent().hide();
        if (1 > $('.settingListJs .setting:visible').length) {
            $('.noRecordFoundJs').parent().show();
        }
    });
};

$(window).on('load', function () {
    /* Mark Sidebar Nav Active. */
    markNavActive($("[data-selector*=" + controllerName + "]"));
});

updateMaintenanceModeStatus = function (event,obj, status,langId) {
    $('.settingListJs').prepend(fcom.getLoader());
    fcom.displayProcessing();
    event.stopPropagation();
    var data = $(obj).attr('name') + '=' + status + '&lang_id=' + langId;
    var oldStatus = $(obj).attr("data-old-status");
    var nextStatus = status == 1 ? 0 : 1;
    fcom.ajax(fcom.makeUrl('Configurations', 'updateMaintenanceMode'), data, function (ans) {
        fcom.closeProcessing();
        var ans = JSON.parse(ans);
        $(obj).prop("checked", 1 == status);
        if (ans.status == 1) {
            fcom.displaySuccessMessage(ans.msg);
            $(obj).attr("data-old-status",status);
            $(obj).val(status);
            $(obj).attr({ onclick: "updateMaintenanceModeStatus(event, this, " + nextStatus + ", " + langId + ")"});
        } else {
            $(obj).prop("checked", 1 == oldStatus);
            fcom.displayErrorMessage(ans.msg);
        }
        fcom.removeLoader();
    },);
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