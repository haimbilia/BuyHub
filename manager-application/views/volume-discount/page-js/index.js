$(document).ready(function () {
    select2("productSellerJs", fcom.makeUrl('VolumeDiscount', 'autoCompleteSeller'), {}, '', function (e) {
        searchRecords();
    });
});

(function () {
    bindProductNameSelect2 = function () {
        select2("productNameJs", fcom.makeUrl('VolumeDiscount', 'autoCompleteProducts'));
    }

    showOrignal = function (ele) {
        var obj = $(ele);
        var value = obj.attr('data-value');
        obj.text(value);
    }

    updateValues = function (ele) {
        var obj = $(ele);
        var attribute = obj.attr('name');
        var value = ele.textContent;
        var oldValue = obj.attr('data-value');
        var formattedValue = obj.attr('data-formated-value');
        var id = obj.attr('data-id');
        var selProdId = obj.attr('data-selprod-id');
        value = parseFloat(value);
        if (Number.isNaN(value)) {
            obj.text(formattedValue);
            $.ykmsg.error(langLbl.notANumber);
            return;
        }
        oldValue = parseFloat(oldValue);


        if ('' != value && value != oldValue) {
            fcom.displayProcessing();
            var data = 'attribute=' + attribute + "&voldiscount_id=" + id + "&selProdId=" + selProdId + "&value=" + value;
            fcom.ajax(fcom.makeUrl(controllerName, 'updateColValue'), data, function (t) {
                $.ykmsg.close();
                var ans = $.parseJSON(t);
                if (ans.status != 1) {
                    $.ykmsg.error(ans.msg);
                    value = oldValue;
                    updatedValue = formattedValue;
                } else {
                    updatedValue = ans.data.value;
                }
                obj.attr('data-value', value);
                obj.attr('data-formated-value', updatedValue);
                obj.text(updatedValue);
               
            });
        } else {
            obj.text(formattedValue);
        }
    };
})();