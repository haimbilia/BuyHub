$(document).ready(function () {
    taxRulesSearch(document.frmSearchTaxRules);
});

(function () {


    taxRulesSearch = function (frm) {
        data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('seller', 'taxRulesSearch'), data, function (res) {
            $("#listing").html(res);
        });
    };

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSearchPaging;
        $(frm.page).val(page);
        taxRulesSearch(frm);
    }

    editRule = function (ruleId) {
        fcom.ajax(fcom.makeUrl('Seller', 'editTaxRuleForm', [ruleId]), '', function (t) {
            $.ykmodal(t);
            
        });
    };
    updateTaxRule = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'updateTaxRule'), data, function (t) {
            
            taxRulesSearch(document.frmSearchTaxRules);
        });
    };

})();


