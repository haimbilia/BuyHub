
(function () {
    getCombinedTaxes = function (taxStrId) {
        if (taxStrId == 0) {
            return;
        }
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('TaxCategoriesRule', 'getCombinedTaxes', [taxStrId, $('input[name="taxrule_id"]').val()]), '', function (t) {
            $('.combinedTaxDetails').html(t);
            fcom.removeLoader();
        });
    };

    addNew = function (recordId, displayInPopup = false, dialogClass = '') {
        if (false === checkControllerName()) {
            return false;
        }
        fcom.resetEditorInstance();

        /* Uncheck all if checked. */
        $(".selectAllJs, .selectItemJs").prop("checked", false)

        $.ykmodal(fcom.getLoader(), displayInPopup, dialogClass);
        var data = "parantId=" + recordId;
        fcom.ajax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            $.ykmodal(t, displayInPopup, dialogClass); 
            fcom.removeLoader();
        });
    };

})();

function checkStatesDefault(countryId, stateIds, field) {
    fcom.ajax(fcom.makeUrl('Users', 'getStates', [countryId, 0]), '', function (res) {
        $(field).empty();
        var firstChild = '<option value = "-1" >All</option>';
        $(field).append(firstChild);
        $(field).append(res);
        $(field).find("option[value='-1']:eq(1)").remove();
        if ($.isArray(stateIds)) {
            $(stateIds).each(function (index, val) {
                $(field).find("option[value=" + val + "]").attr('selected', 'selected');
            });
        }
    });
}
 