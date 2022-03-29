$(document).on('change', '#logoLanguageJs', function () {
    var lang_id = $(this).val();
    var recordId = $(this).closest("form").find('input[name="cpage_id"]').val();
    backgroundImage(recordId, 'image', lang_id);
});

$(document).on('change', '#imageLanguageJs', function () {
    var lang_id = $(this).val();
    var recordId = $(this).closest("form").find('input[name="cpage_id"]').val();
    backgroundImage(recordId, lang_id);
});

(function () {
    saveContentPageLangData = (frm, callback = '') => {
        if (!$(frm).validate()) {
            return;
        }
        $.ykmodal(fcom.getLoader());

        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('ContentPages', "languageSetup"), data, function (res) {
            fcom.removeLoader();
            var t = JSON.parse(res);
            if (t.status == 0) {
                fcom.displayErrorMessage(t.msg);
                return false;
            }
            fcom.displaySuccessMessage(t.msg);
            reloadList();
            if (t.langId > 0) {
                editLangData(t.recordId, t.langId);
            }
        });
    }

    /**
     * cONTENT pAGE cHANGE
     */
    backgroundImage = function (recordId, langId) {
        fcom.updateWithAjax(fcom.makeUrl('ContentPages', 'images', [recordId, langId]), '', function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $('#imageListingJs').html(t.html);
        });
    };


    deleteBackgroundImage = function (recordId, afileId, langId) {
        if (!confirm(langLbl.confirmDelete)) { return; }
        fcom.updateWithAjax(fcom.makeUrl('ContentPages', 'removeMedia', [recordId, afileId]), '', function (t) {
            fcom.closeProcessing();
            backgroundImage(recordId, langId);
            reloadList();
            $('.resetModalFormJs').click();
        });
    };

    pagesLayouts = function () {
        fcom.updateWithAjax(fcom.makeUrl('ContentPages', 'layouts'), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
        });
    };
})();