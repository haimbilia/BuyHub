$(document).ready(function () {
    if ($(".rememberFldJs").parent().is("label")) {
        $(".rememberFldJs").unwrap();
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
            location.href = t.redirectUrl;
        });
    };

    sendResetPasswordLink = function (user) {
        if (user == '') {
            return false;
        }

        fcom.updateWithAjax(fcom.makeUrl("adminGuest", "sendResetPasswordLink", [user]), '', function (t) {
            if (0 == t.status) {
                $.ykmsg.error(t.errorMsg);
                return false;
            }
            $.ykmsg.success(t.msg);
        });
    };

    $('#showPass').on('click', function () {
        var passInput = $("#password");
        if (passInput.attr('type') === 'password') {
            passInput.attr('type', 'text');
            $(this).html(hideTxt);
        } else {
            $(this).html(showTxt);
            passInput.attr('type', 'password');
        }
    });
})();
