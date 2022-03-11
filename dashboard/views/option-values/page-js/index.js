$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});
(function () {
	var currentPage = 1;
	var runningAjaxReq = false;

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmRecordSearch;
		$(frm.page).val(page);
		searchRecords(frm);
	}

	reloadList = function () {
		var frm = document.frmRecordSearch;
		searchRecords(frm);
	}
	
	form = function (optionId, id) {
		optionId = optionId || $('.navTabsJs').data('optionId');
		id = id || $('.navTabsJs').data('optionValueId');
		console.log();
		fcom.ajax(fcom.makeUrl('OptionValues', 'form', [optionId, id]), '', function (t) {
			try {
				res = jQuery.parseJSON(t);
				fcom.displayErrorMessage(res.msg);
			} catch (e) {
				$.ykmodal(t);
			}
		});
	};

	setup = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('OptionValues', 'setup'), data, function (t) {
			$.ykmsg.close();
			$('.navTabsJs').data('optionValueId', t.optionValueId);
			$('.navTabsJs').data('optionId', t.optionId);
			reloadList();		
			if (t.langId > 0) {
				langForm(t.optionValueId, t.langId);
				return;				
			}	
			form(t.optionId,t.optionValueId);		
		});
	};

	langForm = function (optionValueId, langId, autoFillLangData = 0) {
		optionValueId = optionValueId || $('.navTabsJs').data('optionValueId');
        if (optionValueId < 0 || typeof (optionValueId) == "undefined") {
            return false;
        }
        if (typeof (langId) == "undefined" || langId < 0) {
            return false;
        }     
		markPopupTabActive();       
        $('#editFormJs').prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('OptionValues', 'langForm', [optionValueId, langId, autoFillLangData]), '', function (t) {
			$('#editFormJs').html(t);
		});
	};

	langSetup = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('OptionValues', 'langSetup'), data, function (t) {
			$.ykmsg.close();
			reloadList();
			if (t.langId > 0) {
				langSetup(t.optionValueId, t.langId);
				return;
			}			
		});
	};

	searchRecords = function (form) {
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}	
		$('#optionValueListing').prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('OptionValues', 'search'), data, function (res) {
			$("#optionValueListing").html(res);
			fcom.removeLoader();
		});
	};

	deleteRecord = function (option_id, id) {
		if (!confirm(langLbl.confirmDelete)) { return; }		
		fcom.updateWithAjax(fcom.makeUrl('OptionValues', 'deleteRecord'), {option_id,id}, function (res) {
			reloadList();
		});
	};

	clearOptionValueSearch = function () {
		document.frmSearch.reset();
		searchRecords(document.frmSearch);
	};

})();
