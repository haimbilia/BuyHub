
(function () {
    sendMail = function (userId, selprodId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl(controllerName, 'sendMailThresholdStock', [userId, selprodId]), '', function (res) {
            $.ykmsg.close();
            fcom.removeLoader();
            var t = JSON.parse(res);
            if (t.status != 1) {
                $.ykmsg.error(t.msg);
                return false;
            }
            $.ykmsg.success(t.msg);
            searchRecords();
        });
    };

})(); 