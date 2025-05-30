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
            fcom.displayErrorMessage(langLbl.notANumber);
            return;
        }

        var data = 'swsetting_key=' + obj.attr('data-id') + '&weightage=' + value;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            obj.attr('data-value', value);
        });
    };
})();
