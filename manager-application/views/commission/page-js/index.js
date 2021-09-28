(function () {
    viewHistory = function (id) {
        $.ykmodal(fcom.getLoader());
        var data = 'recordId=' + id;
        fcom.ajax(fcom.makeUrl(controllerName, 'viewHistory', []), data, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };
})();
