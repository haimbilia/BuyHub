(function () {
    updateWeightage = function (ele) {
        var obj = $(ele);
        var value = ele.textContent;
        if (obj.attr('data-value') == value) {
            return;
        }
        
        value = parseFloat(value);
        if (Number.isNaN(value)) {
            obj.text(obj.attr('data-value'));
            $.ykmsg.error(langLbl.notANumber);
            return;
        }

        var data = 'swsetting_key=' + obj.attr('data-id') + '&weightage=' + value;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {
            obj.attr('data-value', value);
        });
    };
})();
