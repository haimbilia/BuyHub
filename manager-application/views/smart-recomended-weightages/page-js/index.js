(function () {
    updateWeightage = function (id, val) {
        var data = 'swsetting_key=' + id + '&weightage=' + val;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {
            reloadList();
        });
    };
})();
