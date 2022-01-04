
(function () {
    sendMail = function (userId, selprodId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'sendMailThresholdStock', [userId, selprodId]), '', function (t) {
            $.ykmsg.close();
            fcom.removeLoader();
            $.ykmsg.success(t.msg);
            searchRecords();
        });
    };

})(); 