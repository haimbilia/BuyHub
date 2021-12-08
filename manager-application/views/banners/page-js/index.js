addNewBanner = function(bannerLocationId) {
    fcom.resetEditorInstance();
    $(".selectAllJs, .selectItemJs").prop("checked", false)
    $.ykmodal(fcom.getLoader(), false, '');
    fcom.ajax(fcom.makeUrl(controllerName, 'form'), {bannerLocationId}, function (t) {
        $.ykmodal(t, false, '');
        fcom.removeLoader();
    });
};

editRecord = function(recordId, bannerLocationId) {
    fcom.resetEditorInstance();
    $.ykmodal(fcom.getLoader());
    data = {recordId, bannerLocationId};
    fcom.ajax(fcom.makeUrl(controllerName, 'form'), data, function (t) {
        $.ykmodal(t);   
        fcom.removeLoader();
    });
};

mediaForm = function (recordId, bannerLocationId, langId = 0, slide_screen = 1) {
    $.ykmodal(fcom.getLoader());
    fcom.ajax(
        fcom.makeUrl(controllerName, "media", [recordId, bannerLocationId, langId, slide_screen]),
        "",
        function (t) {
            fcom.removeLoader();
            loadImages(recordId, "logo", slide_screen, langId);
            $.ykmodal(t);
        }
    );
};