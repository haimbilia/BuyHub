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
backgroundImage = function (recordId, fileType, langId) {
    fcom.ajax(fcom.makeUrl('ContentPages', 'images', [recordId, fileType, langId]), '', function (t) {		
        if (fileType == 'logo') {
            $('#logoListingJs').html(t);
        } else {
            $('#imageListingJs').html(t);
        }          
    });
};

$(document).on('change', '#logoLanguageJs', function() {
    var lang_id = $(this).val();
    var recordId = $(this).closest("form").find('input[name="cpage_id"]').val(); 
    backgroundImage(recordId, 'logo', lang_id);
});
$(document).on('change', '#imageLanguageJs', function() {
    var lang_id = $(this).val();
    var recordId = $(this).closest("form").find('input[name="cpage_id"]').val();
    backgroundImage(recordId, 'image', lang_id);
});