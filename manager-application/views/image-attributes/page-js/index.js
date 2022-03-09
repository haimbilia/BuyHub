attributeForm = function (recordId) {
    var moduleType = $('select[name=select_module] option').filter(':selected').val();
    data = "recordId=" + recordId;
    fcom.updateWithAjax(fcom.makeUrl(controllerName, "form", [recordId, moduleType]), data, function (t) {
        $.ykmodal(t.html);
        fcom.removeLoader();
    });
};

setup = function (frm) {
    if (!$(frm).validate()) return;
    var data = fcom.frmData(frm);
    $.ykmodal(fcom.getLoader());
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {});
};

$(document).on('change', '.languageJs', function () {
    var langId = $(this).val() || 0;
    var recordId = $('#frmImgAttributeJs input[name=record_id]').val();
    var module = $('#frmImgAttributeJs input[name=module_type]').val();
    var option_id = $('.optionJs').length ? $('.optionJs').val() : 0;
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'form', [recordId, module, langId, option_id]), '', function (t) {
        $.ykmodal(t.html);
        $('#frmImgAttributeJs input[name=lang_id]').val(langId);
        fcom.removeLoader();
    });
});

$(document).on('change', '.optionJs', function () {
    var option_id = $(this).val();
    var recordId = $('#frmImgAttributeJs input[name=record_id]').val();
    var module = $('#frmImgAttributeJs input[name=module_type]').val();
    var langId = $('.languageJs').val() || 0;
    fcom.updateWithAjax(fcom.makeUrl(controllerName, 'form', [recordId, module, langId, option_id]), '', function (t) {
        $.ykmodal(t.html);
        $('#frmImgAttributeJs input[name=lang_id]').val(langId);
        fcom.removeLoader();
    });
});