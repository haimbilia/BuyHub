function setSiteDefaultLang(langId) {
    fcom.displayProcessing();
    fcom.updateWithAjax(fcom.makeUrl('Home', 'setLanguage', [langId]), '', function (res) {
        document.location.reload();
    });
}

function getNotifications() {
    $("#notificationList").prepend(fcom.getLoader());

    fcom.ajax(fcom.makeUrl('Notifications', 'notificationList'), '', function (res) {
        $("#notificationList").html(res);
    });
}

function getHelpCenterContent(controller, action = "") {
    /* fcom.ajax(fcom.makeUrl('HelpCenter', 'getContent', [controller, action]), '', function (t) {
        var res = $.parseJSON(t);
        if (0 == res.status) {
            return;
        }

        if (1 > $('#helpCenterJs').length) {
            $(".mainJs").after('<div id="helpCenterJs"></div>');
        }

        if ('undefined' != typeof res.html) {
            $("#helpCenterJs").html(res.html);
        }
    }); */
}