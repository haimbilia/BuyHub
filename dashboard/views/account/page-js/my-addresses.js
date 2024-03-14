$(document).ready(function () {
	searchAddresses();
});

(function () {
	var runningAjaxReq = false;
	var dv = '#listing';

	checkRunningAjax = function () {
		if (runningAjaxReq == true) {
			console.log(runningAjaxMsg);
			return;
		}
		runningAjaxReq = true;
	};

	searchAddresses = function () {
		$(dv).prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Account', 'searchAddresses'), '', function (res) {
			fcom.removeLoader();
			$(dv).html(res);
		});
	};

	addAddressForm = function (id, langId = 0) {
		fcom.ajax(fcom.makeUrl('Account', 'addAddressForm', [id, langId]), '', function (t) {
			fcom.removeLoader();
			$.ykmodal(t);
		});
	};

	setupAddress = function (frm) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Addresses', 'setUpAddress'), data, function (t) {
			searchAddresses();
			closeForm();
			if ($(frm.addr_id).val() == 0) {
				setDefaultAddress(t.addr_id);
			}
		});
	};

	setDefaultAddress = function (id, e) {
		if (!confirm(langLbl.confirmDefault)) {
			e.preventDefault();
			return;
		}
		data = 'id=' + id;
		fcom.updateWithAjax(fcom.makeUrl('Addresses', 'setDefault'), data, function (res) {
			searchAddresses();
		});
	};

	removeAddress = function (id) {
		var agree = confirm(langLbl.confirmDeleteAddress);
		if (!agree) {
			return false;
		}
		data = 'id=' + id;
		fcom.updateWithAjax(fcom.makeUrl('Addresses', 'deleteRecord'), data, function (res) {
			searchAddresses();
		});
	};

})();
