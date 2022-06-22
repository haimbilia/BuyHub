
(function () {
    addNewPlan = function (spackageId) {
        fcom.updateWithAjax(fcom.makeUrl('SellerPackagePlans', "form"), { spackageId: spackageId }, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    editPlanRecord = function (spackageId, spPlanId) {
        fcom.updateWithAjax(fcom.makeUrl('SellerPackagePlans', "form"), { spackageId: spackageId, spPlanId: spPlanId }, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };
})();
