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

$(function () {
	$("#sortable").sortable({
		stop: function () {
			reloadList(false);
		}
	}).disableSelection();
});

(function () {
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
	reloadList = function (withloader) {
		var frm = document.frmSalesReportSearchPaging;
		searchSalesReport(frm, withloader);
	};

	searchSalesReport = function (frm, withloader) {
		setColumnsData(frm);
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}

		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}

		fcom.ajax(fcom.makeUrl('SalesReport', 'search'), data, function (res) {
			$(dv).html(res);
		});
	};

	exportReport = function () {
		setColumnsData(document.frmSalesReportSearch);
		document.frmSalesReportSearch.action = fcom.makeUrl('SalesReport', 'search', ['export']);
		document.frmSalesReportSearch.submit();
	}

	clearSearch = function () {
		document.frmSalesReportSearch.reset();
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			if ($(this).attr('disabled') != 'disabled') {
				$(this).prop('checked', false);
			}
		});
		searchSalesReport(document.frmSalesReportSearch);
	};

	setColumnsData = function (frm) {
		reportColumns = [];
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			reportColumns.push($(this).val());
		});

		$(frm.reportColumns).val(JSON.stringify(reportColumns));
	};

})();