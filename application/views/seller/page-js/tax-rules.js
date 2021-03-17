(function () {
    editRule = function (ruleId) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('Seller', 'editTaxRuleForm', [ruleId]), '', function (t) {
                $.facebox(t, 'faceboxWidth');
                fcom.resetFaceboxHeight();
            });
        });

    };
    updateTaxRule = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'updateTaxRule'), data, function (t) {
            $(document).trigger('close.facebox');
        });
    };
})();


