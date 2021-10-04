(function () {
    viewLog = function (id) {
        $.ykmodal(fcom.getLoader());
        var data = 'recordId=' + id;
        fcom.ajax(fcom.makeUrl(controllerName, 'viewLog', []), data, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };
})();
