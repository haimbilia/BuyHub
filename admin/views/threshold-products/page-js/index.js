
(function () {
    sendMail = function (userId, selprodId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'sendMailThresholdStock', [userId, selprodId]), '', function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
            searchRecords();
        });
    };

})(); 