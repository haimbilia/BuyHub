(function () {
	var runningAjaxReq = false;
	setUpSendMessage = function (frm) {
		if (!$(frm).validate()) return;
		if (runningAjaxReq == true) {
			console.log(langLbl.requestProcessing);
			return;
		}
		runningAjaxReq = true;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Shops', 'setUpSendMessage'), data, function (t) {
			fcom.closeProcessing();
			fcom.removeLoader();
			runningAjaxReq = false;
			if (t.status) {
				document.frmSendMessage.reset();
			}
		});
		return false;
	}
})();