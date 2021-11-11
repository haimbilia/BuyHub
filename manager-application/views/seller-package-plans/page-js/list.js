
(function () {
    addNewPlan = function (spackageId) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerPackagePlans', "form"), { spackageId: spackageId }, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

    editPlanRecord = function (spackageId, spPlanId) {
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerPackagePlans', "form"), { spackageId: spackageId, spPlanId: spPlanId }, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };
})();
