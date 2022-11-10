$(document).on('click', '.dateJs', function () {
    var ele = $(this);
    ele.hide().bind('active');
    var inputFld = ele.siblings('input[type="text"]');
    inputFld.removeClass('hide').focus().addClass('hide');
    if (inputFld.val() != inputFld.attr('data-value')) {
        inputFld.val(inputFld.attr('data-value'));
    }
});

$(document).on('blur', ".inputDateJs", function (e) {
    e.stopPropagation();
    $(this).addClass('hide').siblings('.dateJs').show();
});

$(document).on('change', ".inputDateJs", function () {
    updateValues($(this));
});


(function () {
    showOrignal = function (ele) {
        var obj = $(ele);
        var value = obj.attr('data-value');
        obj.text(value);
    }

    updateValues = function (ele) {
        var obj = $(ele);
        var attribute = obj.attr('name');
        var value = ('tpr_custom_weightage' == attribute) ? ele.textContent : obj.val();
        var oldValue = obj.attr('data-value');
        var formattedValue = obj.attr('data-formated-value');
        var tagId = obj.attr('data-id');
        var productId = obj.attr('data-product-id');
        console.log(value);
        if ('tpr_custom_weightage' == attribute) {
            value = parseFloat(value);
            if (Number.isNaN(value)) {
                obj.text(formattedValue);
                fcom.displayErrorMessage(langLbl.notANumber);
                return;
            }
        }
        oldValue = parseFloat(oldValue);

        if ('' != value && value != oldValue) {
            var data = 'tag_id=' + tagId + '&product_id=' + productId + '&' + attribute + '=' + value;
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (ans) {
                fcom.closeProcessing();
                if (ans.status != 1) {                  
                    value = oldValue;
                    updatedValue = formattedValue;
                } else {
                    updatedValue = ans.data.value/* .toFixed(2); */
                }
                obj.attr('data-value', value);
                obj.attr('data-formated-value', updatedValue);

                if ('tpr_custom_weightage' == attribute) {
                    obj.text(updatedValue);
                } else {
                    obj.addClass('hide').siblings('.dateJs').text(updatedValue).show();
                }
            });
        } else if ('tpr_custom_weightage' == attribute) {
            obj.text(formattedValue);
        }
    };
})();
