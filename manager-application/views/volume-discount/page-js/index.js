$(document).on('click', '.editColJs', function(){
    $(this).addClass('hide');
    var input = $(this).siblings('input[type="text"]');
    var value = input.val();
    input.removeClass('hide');
    input.val('').focus().val(value);
});

$(document).on('blur', ".volDiscountColJs", function(){
    var currObj = $(this);
    var value = currObj.val();
    var oldValue = currObj.attr('data-oldval');
    var attribute = currObj.attr('name');
    var id = currObj.data('id');
    var selProdId = currObj.data('selprodid');
    if ('' != value && parseFloat(value) != parseFloat(oldValue)) {
        var data = 'attribute='+attribute+"&voldiscount_id="+id+"&selProdId="+selProdId+"&value="+value;
        fcom.ajax(fcom.makeUrl('VolumeDiscount', 'updateColValue'), data, function(t) {
            var ans = $.parseJSON(t);
            if( ans.status != 1 ){
                $.ykmsg.error(ans.msg);
                value = updatedValue = oldValue;
            } else {
                updatedValue = ans.data.value;
                currObj.attr('data-oldval', value);
            }
            currObj.val(value);
            showElement(currObj, updatedValue);
        });
    } else {
        showElement(currObj);
        currObj.val(oldValue);
    }
    return false;
});

$(document).ready(function() {
    select2("productSellerJs", fcom.makeUrl('VolumeDiscount', 'autoCompleteSeller'), {}, '', function (e) {
        searchRecords();
    });
});

(function () {
    bindProductNameSelect2 = function () {
        select2("productNameJs", fcom.makeUrl('VolumeDiscount', 'autoCompleteProducts'));
    }

    showElement = function(currObj, value){
        var sibling = currObj.siblings('div');
        if ('' != value){
            sibling.text(value);
        }
        sibling.removeClass('hide');
        currObj.addClass('hide');
    };
})();