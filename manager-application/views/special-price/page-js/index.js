$(document).on('click', 'table#splPriceListJs tr td .editColJs', function () {
    $(this).hide();
    var input = $(this).siblings('input[type="text"]');
    var value = input.attr('value');
    input.removeClass('hide');
    input.val('').focus().val(value);
});

$(document).on('blur', ".splPriceColJs.dateJs", function () {
    var currObj = $(this);
    var oldValue = currObj.attr('data-oldval');
    showElement(currObj, oldValue);
});

$(document).on('change', ".splPriceColJs.dateJs", function () {
    updateValues($(this));
});

$(document).on('blur', ".splPriceColJs:not(.dateJs)", function () {
    updateValues($(this));
});

$(document).ready(function() {
    select2("productSellerJs", fcom.makeUrl('SpecialPrice', 'autoCompleteSeller'));
});

(function () {
    bindProductNameSelect2 = function () {
        select2("productNameJs", fcom.makeUrl('SpecialPrice', 'autoCompleteProducts'), {},
            function (e) {
                var parentForm = $("#productNameJs").closest('form').attr('id');
                $("#" + parentForm + " input[name='splprice_selprod_id']").val(e.params.args.data.id);
            }, function (e) {
                var parentForm = $("#productNameJs").closest('form').attr('id');
                $("#" + parentForm + " input[name='splprice_selprod_id']").val('');
            });
    }

    updateValues = function (currObj) {
        var value = currObj.val();
        var oldValue = currObj.attr('data-oldval');
        var displayOldValue = currObj.attr('data-displayoldval');
        displayOldValue = typeof displayOldValue == 'undefined' ? oldValue : displayOldValue;
        var attribute = currObj.attr('name');
        var id = currObj.data('id');
        var selProdId = currObj.data('selprodid');
        if ('splprice_price' == attribute) {
            value = parseFloat(value);
            oldValue = parseFloat(oldValue);
        }
        if ('' != value && value != oldValue) {
            var data = 'attribute=' + attribute + "&splprice_id=" + id + "&selProdId=" + selProdId + "&value=" + value;
            fcom.ajax(fcom.makeUrl('SpecialPrice', 'updateColValue'), data, function (t) {
                var ans = $.parseJSON(t);
                if (ans.status != 1) {
                    $.ykmsg.error(ans.msg);
                    value = oldValue;
                    updatedValue = displayOldValue;
                } else {
                    updatedValue = ans.data.value;
                    currObj.attr('data-oldval', value);
                }
                currObj.attr('value', value);
                showElement(currObj, updatedValue);
            });
        } else {
            showElement(currObj);
            currObj.val(oldValue);
        }
    };

    showElement = function (currObj, value) {
        var sibling = currObj.siblings('div.editColJs');
        var percentDiv = currObj.siblings('div.percentValJs');
        if ('' != value) {
            sibling.text(value);
            var price = currObj.attr('data-price');
            var value = currObj.attr('value');
            var discountPrice = price - value;
            var discountPercentage = ((discountPrice / price) * 100).toFixed(2);
            discountPercentage = discountPercentage + "% off";
            percentDiv.text(discountPercentage);
        }
        sibling.fadeIn();
        currObj.addClass('hide');
    };
})();