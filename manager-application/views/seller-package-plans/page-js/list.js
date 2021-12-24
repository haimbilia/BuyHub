
(function () {
    addNewPlan = function (spackageId) {
        fcom.updateWithAjax(fcom.makeUrl('SellerPackagePlans', "form"), { spackageId: spackageId }, function (t) {
            $.ykmodal(t.html);
            fcom.removeLoader();
            $.ykmsg.close();
        });
    };

    editPlanRecord = function (spackageId, spPlanId) {
        fcom.updateWithAjax(fcom.makeUrl('SellerPackagePlans', "form"), { spackageId: spackageId, spPlanId: spPlanId }, function (t) {
            $.ykmodal(t.html);
            fcom.removeLoader();
            $.ykmsg.close();
        });
    };
})();
