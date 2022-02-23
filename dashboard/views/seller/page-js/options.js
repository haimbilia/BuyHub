$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});

(function () {
	var dv = '#loadForm';

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmOptionsSearchPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	}

	reloadList = function () {
		var frm = document.frmOptionsSearchPaging;
		searchRecords(frm);
	}

	optionForm = function (optionId) {
		$.ykmodal(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Seller', 'optionForm', [optionId]), '', function (t) {
			try {
				res = jQuery.parseJSON(t);
				$.mbsmessage(res.msg, true, 'alert--danger');
			} catch (e) {
				$.ykmodal(t);
				addOptionForm(optionId);
				optionValueListing(optionId);
			}

		});
	}

	addOptionForm = function (optionId) {
		fcom.ajax(fcom.makeUrl('Seller', 'addOptionForm', [optionId]), '', function (t) {
			$(dv).html(t);
			fcom.removeLoader();
		});
	};

	optionValueListing = function (optionId) {
		if (optionId == 0) { $('#showHideContainer').addClass('hide'); return; }
		if ($("#optionValueListing").length == 0) {
			var dv = $('#optionValuesListing');
		} else {
			var dv = $('#optionValueListing');
		}
		dv.html('Loading....');
		var data = 'option_id=' + optionId;
		fcom.ajax(fcom.makeUrl('OptionValues', 'search'), data, function (res) {
			dv.html(res);
		});
	};

	optionValueForm = function (optionId, id) {
		fcom.ajax(fcom.makeUrl('OptionValues', 'form', [optionId, id]), '', function (t) {
			fcom.removeLoader();
			$(dv).html(t);
			optionValueListing(optionId);
		});
	};

	setUpOptionValues = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('OptionValues', 'setup'), data, function (t) {
			$.mbsmessage.close();
			if (t.optionId > 0) {
				optionValueForm(t.optionId, 0);
				return;
			}
			
		});
	};

	deleteOptionValue = function (optionId, id) {
		if (!confirm(langLbl.confirmDelete)) { return; }
		data = 'id=' + id + '&option_id=' + optionId;
		fcom.updateWithAjax(fcom.makeUrl('OptionValues', 'deleteRecord'), data, function (res) {
			$.mbsmessage.close();
			optionValueListing(optionId);
			optionValueForm(optionId, 0);
		});
	}

	optionValueSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmSearchOptionValuePaging;
		$(frm.page).val(page);
		searchOptionValueListing(frm);
	};

	searchOptionValueListing = function (form) {
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		$("#optionValueListing").html('Loading....');
		fcom.ajax(fcom.makeUrl('OptionValues', 'search'), data, function (res) {
			$("#optionValueListing").html(res);
		});
	};

	showHideValues = function (obj) {

		var type = obj.value;
		var data = 'optionType=' + type;
		fcom.ajax(fcom.makeUrl('Options', 'canSetValue'), data, function (t) {
			var res = $.parseJSON(t);
			if (res.hideBox == true) {
				$('#showHideContainer').addClass('hide'); return;
			}
			$('#showHideContainer').removeClass('hide');
		});
	};

	submitOptionForm = function (frm, fn) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'setupOptions'), data, function (t) {
			reloadList();
			if (t.optionId > 0) {
				if (1 > $("#showHideContainer").length) {
					optionForm(t.optionId);
				}
			}
			$.mbsmessage.close();
		});
	};

	searchRecords = function (form) {
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		/*]*/
		$("#optionListing").prepend(fcom.getLoader());

		fcom.ajax(fcom.makeUrl('seller', 'searchOptions'), data, function (res) {
			fcom.removeLoader();
			$("#optionListing").html(res);
		});
	};

	deleteOptionRecord = function (id) {
		if (!confirm(langLbl.confirmDelete)) { return; }
		data = 'id=' + id;
		fcom.ajax(fcom.makeUrl('seller', 'deleteSellerOption'), data, function (t) {
			$res = $.parseJSON(t);
			if ($res.status == 0) {
				$.mbsmessage($res.msg, true, 'alert--danger');
			} else {
				$.mbsmessage($res.msg, true, 'alert--success');
			}
			reloadList();
		});
	};

	deleteSelected = function () {
		if (!confirm(langLbl.confirmDelete)) { return; }
		$("#frmOptionListing").submit();
	};
})();
