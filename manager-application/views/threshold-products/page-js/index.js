
(function () { 
    sendMail = function (userId, selprodId) { 
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('ThresholdProducts', 'sendMailThresholdStock', [userId, selprodId]), '', function (res) {
            fcom.removeLoader();
            var t = JSON.parse(res);
            if (t.status == 1) {
                $.ykmsg.success(t.msg);
                searchRecords();
            }
            $.ykmsg.error(t.msg);
            return false;
        });
    };

})(); 