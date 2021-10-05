(function () {
    labelsForm = function (labelId, type, autoFillLangData = 0) {
        $.ykmodal(fcom.getLoader());
        data = 'recordId=' + labelId;
        fcom.ajax(fcom.makeUrl('Labels', 'langForm', [type, autoFillLangData]), data, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    updateFile = function (labelType = 1) {
        fcom.updateWithAjax(fcom.makeUrl('Labels', 'updateJsonFile', [labelType]), '', function (ans) {});
    };
})()
