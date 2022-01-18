(function () {
    saveRecord = function (frm, callback = '') {
        if (false === checkControllerName()) {
            return false;
        }
        if (!$(frm).validate()) {
            return;
        }
        $.ykmodal(fcom.getLoader(), !$.ykmodal.isSideBarView());

        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controllerName, 'setup'), data, function (res) {
            $("." + $.ykmodal.element + ' .submitBtnJs').removeClass('loading');
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
            } else {
                editRecord(t.recordId);
            }

            return;
        });
    };
})();

$(document).on("change", "input[name=taxstr_is_combined]", function () {
    $('.component_link').closest('.col-md-12').addClass('hide');
    if ($("input[name=taxstr_is_combined]").prop('checked') == true) {
        $('.component_link').closest('.col-md-12').removeClass('hide');
    }
});

$(document).on("click", ".add-combined-form--js", function () {
    $(this).closest('.component_link').find('.component-row--js').last().after($(this).closest('.component-row--js').clone());
    $(this).closest('.component_link').find('.component-row--js').last().find('input[type=text]').val('');
    $(this).closest('.component_link').find('.component-row--js').last().find('.remove-combined-form--js').removeClass('hide');
    $(this).closest('.component_link').find('.component-row--js').last().find('.remove-combined-form--js').attr('data-id', '0');
    $(this).closest('.component_link').find('.component-row--js').last().find('.remove-combined-form--js').removeClass('invisible');
    placeholderUpdate();
    setVisibliltyForAddBtn();
});
$(document).on("click", ".remove-combined-form--js", function () {
    if ($('.component_link .component-row--js').length == 1) {
        return;
    }
    $('#frmTaxStructure').append('<input data-field-caption="" data-fatreq="{&quot;required&quot;:false}" type="hidden" name="deleted_taxstr_id[]" value="' + $(this).data('id') + '">');
    $(this).closest('.component-row--js').remove();
    placeholderUpdate();
    setVisibliltyForAddBtn();
});

function placeholderUpdate() {
    $('.component_link input[type=text]').each(function (index) {
        index = index + 1;
        $(this).attr('placeholder', placeholder + ' ' + index);
    });
}

function setVisibliltyForAddBtn() {
    var countCompontents = $('.add-combined-form--js').length - 1;
    $('.add-combined-form--js').each(function (index) {
        $(this).removeClass('invisible');
        if (countCompontents != index) {
            $(this).addClass('invisible');
        }

    });
}
    