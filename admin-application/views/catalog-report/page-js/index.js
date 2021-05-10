$(document).ready(function () {
	searchCatalogReport(document.frmCatalogReportSearch);	
});

$(document).on("click", ".headerColumnJs", function (e) {
	var fld = $(this).attr('data-field');
	var frm = document.frmCatalogReportSearchPaging;
	document.getElementById("sortBy").value = fld;
	$(frm.sortBy).val(fld);
	if (document.getElementById("sortOrder").value == 'ASC') {
		$(frm.sortOrder).val('DESC');
		document.getElementById("sortOrder").value = 'DESC';
	} else {
		$(frm.sortOrder).val('ASC');
		document.getElementById("sortOrder").value = 'ASC';
	}
	searchCatalogReport(frm, false);
});

(function () {
	var currentPage = 1;
	var runningAjaxReq = false;
	var dv = '#listing';

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmCatalogReportSearchPaging;
		$(frm.page).val(page);
		searchCatalogReport(frm);
	};

	reloadList = function () {
		var frm = document.frmCatalogReportSearchPaging;
		searchCatalogReport(frm);
	};

	searchCatalogReport = function (form, withloader) {
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}

		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}

		fcom.ajax(fcom.makeUrl('CatalogReport', 'search'), data, function (res) {
			$(dv).html(res);
		});
		
	};

	exportReport = function (dateFormat) {
		document.frmCatalogReportSearch.action = fcom.makeUrl('CatalogReport', 'export');
		document.frmCatalogReportSearch.submit();
	}

	clearSearch = function () {
		document.frmCatalogReportSearch.reset();
		searchCatalogReport(document.frmCatalogReportSearch);
	};
})();