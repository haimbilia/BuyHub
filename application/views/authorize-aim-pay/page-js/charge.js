var sendPayment = function (frm) {
    if (!$(frm).validate()) return;
    var data = fcom.frmData(frm);
    var action = $(frm).attr('action');
    fcom.ajax(action, data, function (t) {
        try {
            var json = $.parseJSON(t);
            var el = $('#ajax_message');
            if (json['error']) {
                fcom.displayErrorMessage(json['error']);
            }
            if (json['redirect']) {
                fcom.displaySuccessMessage(json['msg']);
                setTimeout(function () { $(location).attr("href", json['redirect']); }, 2000);
            }
        } catch (exc) {
            // console.log(t);
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
				obj.addClass('p-cards ' + card_type );
			}); */
        }
    });
});
