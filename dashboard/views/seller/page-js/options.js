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
		optionId = optionId || $('.navTabsJs').data('optionId');
		$.ykmodal(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Seller', 'optionForm', [optionId]), '', function (t) {
			try {
				res = jQuery.parseJSON(t);
				fcom.displayErrorMessage(res.msg);
			} catch (e) {
				$.ykmodal(t);
			}

		});
	}	

	optionLangForm = function (optionId, langId, autoFillLangData = 0) {
        optionId = optionId || $('.navTabsJs').data('optionId');
        if (optionId < 0 || typeof (optionId) == "undefined") {
            return false;
        }
        if (typeof (langId) == "undefined" || langId < 0) {
            return false;
        }
        markPopupTabActive();       
        $('#editFormJs').prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('seller', 'optionLangForm', [optionId, langId, autoFillLangData]), '', function (t) {
            fcom.removeLoader();
            $('#editFormJs').html(t);
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

	optionValueForm = function (optionId, id = 0) {
		$.ykmodal(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('OptionValues', 'form', [optionId, id]), '', function (t) {
			fcom.removeLoader();
			$.ykmodal(t);		
			optionValueListing(optionId);
		});
	};

	setUpOptionValues = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('OptionValues', 'setup'), data, function (t) {
			$.ykmsg.close();
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
			$.ykmsg.close();
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
			$('.navTabsJs').data('optionId', t.optionId);			
			reloadList();
			if (t.langId > 0) {
				optionLangForm(t.optionId,t.langId)
			}
			$.ykmsg.close();
		});
	};

	optionLangSetup = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'optionLangSetup'), data, function (t) {
            if (t.langId > 0) {
                optionLangForm(t.optionId,t.langId)
                return;
            }                      
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
				fcom.displayErrorMessage($res.msg);
			} else {
				fcom.displaySuccessMessage($res.msg);
			}
			reloadList();
		});
	};

	deleteSelected = function () {
		if (!confirm(langLbl.confirmDelete)) { return; }
		$("#frmOptionListing").submit();
	};
})();
