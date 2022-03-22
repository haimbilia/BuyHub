
(function () {
    
    getCombinedTaxes = function (taxStrId) {
        if (taxStrId == 0) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('TaxCategoriesRule', 'getCombinedTaxes', [taxStrId, $('input[name="taxrule_id"]').val()]), '', function (t) {
            fcom.removeLoader();
            $('.combinedTaxDetails').html(t.html);
        });
    };

    addNew = function (recordId, displayInPopup = false, dialogClass = '') {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();

        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        var data = "parantId=" + recordId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            $.ykmodal(t.html, displayInPopup, dialogClass);
            fcom.removeLoader();
        });
    };

})();

function checkStatesDefault(countryId, stateIds, field) {
    fcom.updateWithAjax(fcom.makeUrl('Users', 'getStates', [countryId, 0]), '', function (res) {
        fcom.removeLoader();
        $(field).empty();
        var firstChild = '<option value = "-1" >All</option>';
        $(field).append(firstChild);
        $(field).append(res.html);
        $(field).find("option[value='']").remove();
        if( $(field).attr('id') !=   'taxruleloc_from_state_id'){
            $(field).find("option[value='-1']").hide();   
        }       
        if ($.isArray(stateIds)) {
            $(stateIds).each(function (index, val) {
                $(field).find("option[value=" + val + "]").attr('selected', 'selected');
            });
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
        $(dv).val( "");
        $(dv + " option[value='-1']").hide();
    }
   
});
