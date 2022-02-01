(function () {
    viewLog = function (id) {
        var data = 'recordId=' + id;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'viewLog', []), data, function (t) {
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };
})();
