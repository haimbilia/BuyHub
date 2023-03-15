$(document).ready(function () {
    if ($(".rememberFldJs").parent().is("label")) {
        $(".rememberFldJs").unwrap();
    }
});

$(document).on('click', '#showPass', function () {
    var passInput = $("#password");
    if ('' == passInput.val()) {
        return;
    }
    
    if (passInput.attr('type') === 'password') {
        passInput.attr('type', 'text');
        $(this).addClass('field-password-show');
    } else {
        passInput.attr('type', 'password');
        $(this).removeClass('field-password-show');
    }
});

(function () {
    login = function (frm, v) {
        if (!$(frm).validate()) {
            return;
        }
        if (!v.isValid()) {
            return;
        }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('AdminGuest', 'login'), data, function (t) {
            if (typeof t.redirectUrl == 'undefined') {
				t.redirectUrl = fcom.makeUrl('AdminGuest', 'loginForm');
			}
            location.href = t.redirectUrl;
        });
    };

    sendResetPasswordLink = function (user) {
        if (user == '') {
            return false;
        }

        fcom.updateWithAjax(fcom.makeUrl("adminGuest", "sendResetPasswordLink", [user]), '', function (t) {
            fcom.displaySuccessMessage(t.msg);
        });
    };
})();
