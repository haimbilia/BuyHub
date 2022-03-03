$(document).ready(function () {
    if ($(".rememberFldJs").parent().is("label")) {
        $(".rememberFldJs").unwrap();
    }
});

$('#showPass').on('click', function () {
    var passInput = $("#password");
    if (passInput.attr('type') === 'password') {
        passInput.attr('type', 'text');
    } else {
        passInput.attr('type', 'password');
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
                fcom.displayErrorMessage(t.errorMsg);
                return false;
            }
            fcom.displaySuccessMessage(t.msg);
        });
    };
})();
