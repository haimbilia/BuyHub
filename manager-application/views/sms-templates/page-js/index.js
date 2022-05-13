$(document).ready(function () {
    $(document).on('keyup', '.stplBodyJs', function (e) {
        var maxLen = $(this).attr('maxlength');
        if (maxLen <= $(this).val().length) {
            e.preventDefault();
            return false;
        }
    });
});

(function () {
    editStplData = function (stplCode, langId, autoFillLangData = 0) {
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "editTemplate", [stplCode, langId, autoFillLangData]), '',
            function (t) {
                fcom.closeProcessing();
                $.ykmodal(t.html);
                fcom.removeLoader();
            }
        );
    };

    setup = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            reloadList();
        });
    };
})();
