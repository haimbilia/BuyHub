viewDetails = function (id, langId) {
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'viewDetails', [id, langId]), '', function (t) {
        fcom.closeProcessing();
        $.ykmodal(t.html);
        fcom.removeLoader();
    });
};     