$(document).on('click', '.dateJs', function () {
    var ele = $(this);
    ele.bind('active');
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

$(document).ready(function () {
    select2("productSellerJs", fcom.makeUrl('SpecialPrice', 'autoCompleteSeller'));
});

(function () {
    bindProductNameSelect2 = function () {
        select2("productNameJs", fcom.makeUrl('SellerProducts', 'autoComplete'), {showSellerPrice : 1},
            function (e) {
                var parentForm = $("#productNameJs").closest('form').attr('id');
                $("#" + parentForm + " input[name='splprice_selprod_id']").val(e.params.args.data.id);               
                $("#specialCurrentPrice").text(currentPriceLbl + ": "+ e.params.args.data.price);                
            }, function (e) {
                var parentForm = $("#productNameJs").closest('form').attr('id');
                $("#" + parentForm + " input[name='splprice_selprod_id']").val('');
                $("#specialCurrentPrice").text('');  
            });
    }

    showOrignal = function (ele) {
        var obj = $(ele);
        var value = obj.attr('data-value');
        obj.text(value);
    }

    updateValues = function (ele) {
        var obj = $(ele);
        var attribute = obj.attr('name');
        var percentDiv = obj.siblings('div.percentValJs');
        var value = ('splprice_price' == attribute) ? ele.textContent : obj.val();
        var price = obj.attr('data-price');
        var oldValue = obj.attr('data-value');
        var formattedValue = obj.attr('data-formated-value');
        var id = obj.attr('data-id');
        var selProdId = obj.attr('data-selprod-id');

        var discountPercentage = '';
        if ('splprice_price' == attribute) {
            value = parseFloat(value);
            if (Number.isNaN(value)) {
                obj.text(formattedValue);
                fcom.displayErrorMessage(langLbl.notANumber);
                return;
            }
            oldValue = parseFloat(oldValue);
            var discountPrice = price - value;
            if (0 < discountPrice) {
                var discountPercentage = ((discountPrice / price) * 100).toFixed(2);
                discountPercentage = discountPercentage + "%  " + langLbl.off;
            }
        }


        if ('' != value && value != oldValue) {
            var data = 'attribute=' + attribute + "&splprice_id=" + id + "&selProdId=" + selProdId + "&value=" + value;
            fcom.displayProcessing();
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updateColValue'), data, function (ans) {      
                fcom.displaySuccessMessage(ans.msg);        
                if (ans.status != 1) {                   
                    value = oldValue;
                    updatedValue = formattedValue;
                } else {
                    updatedValue = ans.data.value;
                    percentDiv.text(discountPercentage);
                }
                obj.attr('data-value', value);
                obj.attr('data-formated-value', updatedValue);
                if ('splprice_price' == attribute) {
                    obj.text(updatedValue);
                } else {
                    obj.addClass('hide').siblings('.dateJs').text(updatedValue).show();
                }
            });
        } else if ('splprice_price' == attribute) {
            obj.text(formattedValue);
        }
    };
})();