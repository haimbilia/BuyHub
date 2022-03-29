(function () {
    labelsForm = function (labelId, type, autoFillLangData = 0) {
        data = 'recordId=' + labelId;
        fcom.updateWithAjax(fcom.makeUrl('Labels', 'langForm', [type, autoFillLangData]), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    updateFile = function (labelType = 1) {
        fcom.updateWithAjax(fcom.makeUrl('Labels', 'updateJsonFile', [labelType]), '', function (ans) {
            fcom.closeProcessing();
            fcom.displaySuccessMessage(ans.msg);
        });
    };
})()
