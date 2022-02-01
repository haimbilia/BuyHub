
(function () {
    sendMail = function (userId, selprodId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'sendMailThresholdStock', [userId, selprodId]), '', function (t) {
            fcom.removeLoader();
            searchRecords();
        });
    };

})(); 