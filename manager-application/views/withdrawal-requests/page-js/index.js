viewDetails = function (id, langId) {
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'viewDetails', [id, langId]), '', function (t) {
        $.ykmodal(t.html);
        fcom.removeLoader();
    });
};     