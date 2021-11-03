var rightSectionDv = '.rightSectionJs';
attributeForm = function (recordId) {
    $(rightSectionDv).html(fcom.getLoader());
    var moduleType = $('select[name=select_module] option').filter(':selected').val();
    data = "recordId=" + recordId;
    fcom.ajax(fcom.makeUrl(controllerName, "form", [recordId, moduleType]), data, function (t) {
        $(rightSectionDv).html(t);
        fcom.removeLoader();
    });
};

setup = function (frm) {
    if (!$(frm).validate()) return;
    var data = fcom.frmData(frm);
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {
        /* reloadList(); */
    });
};

discardForm = function () {
    /* $("#dvForm").hide();
    $("#dvAlert").show(); */
};

$(document).on('change', '.language-js', function () {
    var langId = $(this).val();
    var recordId = $('#frmImgAttribute input[name=record_id]').val();
    var module = $('#frmImgAttribute input[name=module_type]').val();
    var option_id = $('.option-js').length ? $('.option-js').val() : 0;
    fcom.ajax(fcom.makeUrl('ImageAttributes', 'attributeForm', [recordId, module, langId, option_id]), '', function (t) {
        $(rightSectionDv).html(t);
        $('#frmImgAttribute input[name=lang_id]').val(langId);
    });
});

$(document).on('change', '.option-js', function () {
    var option_id = $(this).val();
    var recordId = $('#frmImgAttribute input[name=record_id]').val();
    var module = $('#frmImgAttribute input[name=module_type]').val();
    var langId = $('.language-js').val() || 0;
    fcom.ajax(fcom.makeUrl('ImageAttributes', 'attributeForm', [recordId, module, langId, option_id]), '', function (t) {
        $(rightSectionDv).html(t);
        $('#frmImgAttribute input[name=lang_id]').val(langId);
    });
});