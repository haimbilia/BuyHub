
(function () {

    getCombinedTaxes = function (taxStrId) {
        if (taxStrId == 0) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('TaxCategoriesRule', 'getCombinedTaxes', [taxStrId, $('input[name="taxrule_id"]').val()]), '', function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $('.combinedTaxDetails').html(t.html);
        });
    };

    addNew = function (taxCatId, displayInPopup = false, dialogClass = '') {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();

        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        var data = "taxCatId=" + taxCatId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, displayInPopup, dialogClass);
            fcom.removeLoader();
        });
    };

})();

function checkStatesDefault(element, stateIds, field) {
    let countryId = element.value;
    if (-1 == countryId) {
        if ($(element).hasClass('toCountyElementJs')) {
            $('select[name="taxruleloc_type"]').val(-1).trigger('change').attr('disabled', 'disabled');
        }
        $(field).val(-1).attr('disabled', 'disabled');
        $(field + ' option:not(:first)').remove().val(-1);
        return;
    } else {
        $(field).removeAttr('disabled');
        if ($(element).hasClass('toCountyElementJs')) {
            $('select[name="taxruleloc_type"]').trigger('change').removeAttr('disabled');
        }
    }
    fcom.updateWithAjax(fcom.makeUrl('Users', 'getStates', [countryId, 0]), '', function (res) {
        fcom.closeProcessing();
        fcom.removeLoader();
        $(field).empty();
        var firstChild = '<option value="-1" selected>All</option>';
        $(field).append(firstChild);
        $(field).append(res.html);
        $(field).find("option[value='']").remove();
        if ($(field).attr('id') != 'taxruleloc_from_state_id') {
            $(field).find("option[value='-1']").hide().removeAttr('selected');
            $(field).find("option:not([value='-1']):first").attr('selected', 'selected');
        }
        if ($.isArray(stateIds)) {
            setTimeout(function () {
                $(field).val(stateIds);
            }, 500);
        }
        $('select[name="taxruleloc_type"]').trigger('change');
    });
}

$('body').on('change', 'select[name="taxruleloc_type"]', function () {
    var dv = '#taxruleloc_to_state_id';
    if ($(this).val() == -1) {
        $(dv).val(-1);
        $(dv).attr('disabled', true);
        $(dv + " option[value='-1']").show();
    } else {
        $(dv).removeAttr('disabled');
        $(dv).val("");
        $(dv + " option[value='-1']").hide();
    }

});
