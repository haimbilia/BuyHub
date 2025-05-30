var sendPayment = function (frm) {
    if (!$(frm).validate()) return;
    var data = fcom.frmData(frm);
    var action = $(frm).attr('action');
    var btnText = $('input[type=submit]').val();
    $('input[type=submit]').val($('input[type=submit]').data('processing-text'));
    fcom.displayProcessing();
    fcom.ajax(action, data, function (t) {
        $('input[type=submit]').val("Processing..");
        try {
            var json = $.parseJSON(t);
            var el = $('#ajax_message');
            if (json['error']) {
                $('input[type=submit]').val(btnText);
                el.html('<div class="alert alert-danger">' + json['error'] + '<div>');
            }
            if (json['redirect']) {
                $(location).attr("href", json['redirect']);
            }
        } catch (exc) {
            console.log(t);
        }
    });
};

$(function () {
    $("#cc_number").keydown(function () {
        var obj = $(this);
        var cc = obj.val();
        obj.attr('class', 'p-cards');
        if (cc != '') {
            var card_type = getCardType(cc).toLowerCase();
            obj.addClass('p-cards ' + card_type);
            /* var data="cc="+cc;
            fcom.ajax(fcom.makeUrl('AuthorizeAimPay', 'checkCardType'), data, function(t){
                var ans = $.parseJSON(t);
                var card_type = ans.card_type.toLowerCase();
                obj.addClass('type-bg p-cards ' + card_type );
            }); */
        }
    });
});
