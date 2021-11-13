saveContentPageLangData = (frm, callback = '') =>{
    if (false === checkControllerName()) {
        return false;
    }

    if (!$(frm).validate()) {
        return;
    }
    $.ykmodal(fcom.getLoader());

    var data = fcom.frmData(frm);
    fcom.ajax(fcom.makeUrl('ContentPages', "languageSetup"), data, function (res) {
        fcom.removeLoader();
        var t = JSON.parse(res);
        if (t.status == 0) {
            $.ykmsg.error(t.msg);
            return false;
        }
        $.ykmsg.success(t.msg);
        reloadList();
        if (t.langId > 0) {
            editLangData(t.recordId, t.langId);
        } else if ("openMediaForm" in t) {
            mediaForm(t.recordId);
        }
    });
}

/**
 * cONTENT pAGE cHANGE
 */
backgroundImage = function (recordId, langId) {
    fcom.ajax(fcom.makeUrl('ContentPages', 'images', [recordId, 'IMAGE', langId]), '', function (t) {		
        $('#imageListingJs').html(t);
    });
};


deleteBackgroundImage = function (recordId, afileId ,langId) {
    if (!confirm(langLbl.confirmDelete)) { return; }
    fcom.updateWithAjax(fcom.makeUrl('ContentPages', 'removeMedia', [recordId,'image', afileId]), '', function (t) {
        backgroundImage(recordId, langId);
        reloadList();
    });
};    

$(document).on('change', '#logoLanguageJs', function() {
    var lang_id = $(this).val();
    var recordId = $(this).closest("form").find('input[name="cpage_id"]').val(); 
    backgroundImage(recordId, 'image',lang_id);
});
$(document).on('change', '#imageLanguageJs', function() {
    var lang_id = $(this).val();
    var recordId = $(this).closest("form").find('input[name="cpage_id"]').val();
    backgroundImage(recordId, lang_id);
});