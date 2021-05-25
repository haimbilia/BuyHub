$(document).ready(function () {
	searchSalesReport(document.frmSalesReportSearch);
});

$(document).on("click", ".headerColumnJs", function (e) {
	var fld = $(this).attr('data-field');
	var frm = document.frmSalesReportSearchPaging;
	document.getElementById("sortBy").value = fld;
	$(frm.sortBy).val(fld);
	if (document.getElementById("sortOrder").value == 'ASC') {
		$(frm.sortOrder).val('DESC');
		document.getElementById("sortOrder").value = 'DESC';
	} else {
		$(frm.sortOrder).val('ASC');
		document.getElementById("sortOrder").value = 'ASC';
	}
	searchSalesReport(frm, false);
});

(function () {
	var currentPage = 1;
	var runningAjaxReq = false;
	var dv = '#listing';

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmSalesReportSearchPaging;
		$(frm.page).val(page);
		searchSalesReport(frm);
	};
	redirectBack = function (redirecrt) {
		window.location = redirecrt;
	}
	reloadList = function () {
		var frm = document.frmSalesReportSearchPaging;
		searchSalesReport(frm);
	};

	searchSalesReport = function (form, withloader) {
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}

		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}

		fcom.ajax(fcom.makeUrl('SalesReport', 'search'), data, function (res) {
			$(dv).html(res);
		});
	};

	exportReport = function (dateFormat) {
		document.frmSalesReportSearch.action = fcom.makeUrl('SalesReport', 'search', ['export']);
		document.frmSalesReportSearch.submit();
	}

	clearSearch = function () {
		document.frmSalesReportSearch.reset();
		searchSalesReport(document.frmSalesReportSearch);
	};


})();