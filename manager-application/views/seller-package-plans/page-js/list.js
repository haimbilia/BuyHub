
(function () {
    addNewRecord = function (packageId) {

        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerPackagePlans', "form",[packageId]), "", function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };

})();
