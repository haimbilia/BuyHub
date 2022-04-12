$(document).on('click', '.showPassJs', function () {
	var passInput = $(this).closest('.passwordSectionJs').find('.passwordFieldJs');
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

$(function () {
	resetPassword = function (frm, v) {
		if (!$(frm).validate()) return;
		fcom.updateWithAjax(fcom.makeUrl("adminGuest", "resetPasswordSubmit"), fcom.frmData(frm), function (t) {
			fcom.displaySuccessMessage(t.msg);
			setTimeout(() => {
				window.location.href = fcom.makeUrl('adminGuest', 'loginForm');
			}, 2000);
		});
	}
})