(function () {
	setupOrderReturnRequest = function (frm) {
		fcom.addTrailingSlash();
		if (!$(frm).validate()) { return; }
		fcom.displayProcessing();
		$.ajax({
			url: fcom.makeUrl('Buyer', 'setupOrderReturnRequest'),
			type: 'post',
			dataType: 'json',
			data: new FormData($(frm)[0]),
			cache: false,
			contentType: false,
			processData: false,

			success: function (ans) {
				if (ans.status == true) {
					fcom.displaySuccessMessage(ans.msg);
					document.frmOrderReturnRequest.reset();
					setTimeout(function () { window.location.href = fcom.makeUrl('Buyer', 'Orders'); }, 2000);
				} else {
					fcom.displayErrorMessage(ans.msg);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	};

})();
