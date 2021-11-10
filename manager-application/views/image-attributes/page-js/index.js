attributeForm = function (recordId) {
    $.ykmodal(fcom.getLoader());
    var moduleType = $('select[name=select_module] option').filter(':selected').val();
    data = "recordId=" + recordId;
    fcom.ajax(fcom.makeUrl(controllerName, "form", [recordId, moduleType]), data, function (t) {
        $.ykmodal(t);
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

$(document).on('change', '.languageJs', function () {
    var langId = $(this).val() || 0;
    var recordId = $('#frmImgAttributeJs input[name=record_id]').val();
    var module = $('#frmImgAttributeJs input[name=module_type]').val();
    var option_id = $('.optionJs').length ? $('.optionJs').val() : 0;
    $.ykmodal(fcom.getLoader());
    fcom.ajax(fcom.makeUrl(controllerName, 'form', [recordId, module, langId, option_id]), '', function (t) {
        $.ykmodal(t);
        $('#frmImgAttributeJs input[name=lang_id]').val(langId);
        fcom.removeLoader();
    });
});

$(document).on('change', '.optionJs', function () {
    var option_id = $(this).val();
    var recordId = $('#frmImgAttributeJs input[name=record_id]').val();
    var module = $('#frmImgAttributeJs input[name=module_type]').val();
    var langId = $('.languageJs').val() || 0;
    $.ykmodal(fcom.getLoader());
    fcom.ajax(fcom.makeUrl(controllerName, 'form', [recordId, module, langId, option_id]), '', function (t) {
        $.ykmodal(t);
        $('#frmImgAttributeJs input[name=lang_id]').val(langId);
        fcom.removeLoader();
    });
});