$(document).on('click', '.editColJs', function () {
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

$(document).ready(function () {
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

    showOrignal = function (ele) {
        var obj = $(ele);
        var value = obj.attr('data-value');
        obj.text(value);

        if (obj.hasClass('dateJs')) {
            $(".dateJs").datepicker("show");
        }
    }

    updateValues = function (ele) {
        var obj = $(ele);
        var percentDiv = obj.siblings('div.percentValJs');
        var value = ele.textContent;
        var price = obj.attr('data-price');
        var oldValue = obj.attr('data-value');
        var formattedValue = obj.attr('data-formated-value');
        var attribute = obj.attr('name');
        var id = obj.attr('data-id');
        var selProdId = obj.attr('data-selprod-id');

        if ('splprice_price' == attribute) {
            value = parseFloat(value);
            oldValue = parseFloat(oldValue);
        }

        if (Number.isNaN(value)) {
            $.ykmsg.error(langLbl.notANumber);
            return;
        }

        var discountPrice = price - value;
        var discountPercentage = '';
        if (0 < discountPrice) {
            var discountPercentage = ((discountPrice / price) * 100).toFixed(2);
            discountPercentage = discountPercentage + "% off";
        }

        if ('' != value && value != oldValue) {
            var data = 'attribute=' + attribute + "&splprice_id=" + id + "&selProdId=" + selProdId + "&value=" + value;
            fcom.displayProcessing();
            fcom.ajax(fcom.makeUrl(controllerName, 'updateColValue'), data, function (t) {
                $.ykmsg.close();
                var ans = $.parseJSON(t);
                if (ans.status != 1) {
                    $.ykmsg.error(ans.msg);
                    value = oldValue;
                    updatedValue = formattedValue;
                } else {
                    updatedValue = ans.data.value;

                    percentDiv.text(discountPercentage);
                }
                obj.attr('data-value', value);
                obj.attr('data-formated-value', updatedValue);
                obj.text(updatedValue);
            });
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