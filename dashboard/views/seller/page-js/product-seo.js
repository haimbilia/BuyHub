$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});

(function () {
	var dv = '#listing';
	searchRecords = function (frm) {

		/*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}
		/*]*/
		var dv = $('#listing');
		$(dv).prepend(fcom.getLoader());

		fcom.ajax(fcom.makeUrl('Seller', 'searchSeoProducts'), data, function (res) {
            fcom.removeLoader();
			$("#listing").html(res);
		});
	};
	clearSearch = function (selProd_id) {
		if (0 < selProd_id) {
			location.href = fcom.makeUrl('Seller', 'volumeDiscount');
		} else {
			document.frmRecordSearch.reset();
			searchRecords(document.frmRecordSearch);
		}
	};
	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmSearchSeoProductsPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	}

	reloadList = function () {
		searchRecords(document.frmRecordSearch);
	}

	editProductMetaTagLangForm = function (selprod_id, langId, autoFillLangData = 0) {
		$("#dvForm").prepend(fcom.getLoader())
		fcom.ajax(fcom.makeUrl('seller', 'productSeoLangForm', [selprod_id, langId, autoFillLangData]), '', function (t) {
			$("#dvForm").replaceWith(t).show();
			fcom.removeLoader();
			$("#dvAlert").hide();
		});

	};

	setupProductLangMetaTag = function (frm, exit) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('seller', 'setupProdMetaLang'), data, function (t) {
			if (!exit && t.langId > 0) {
				editProductMetaTagLangForm(t.metaRecordId, t.langId);
				return;
			} else {
				$("#dvForm").hide();
				$("#dvAlert").show();
			}
		});
	}

})();
