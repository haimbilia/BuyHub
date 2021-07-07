$(document).ready(function () {
	searchReport(document.frmReportSrch);
});

$(document).on("click", ".headerColumnJs", function (e) {
	var fld = $(this).attr('data-field');
	var frm = document.frmReportPaging;
	document.getElementById("sortBy").value = fld;
	$(frm.sortBy).val(fld);
	if (document.getElementById("sortOrder").value == 'ASC') {
		$(frm.sortOrder).val('DESC');
		document.getElementById("sortOrder").value = 'DESC';
	} else {
		$(frm.sortOrder).val('ASC');
		document.getElementById("sortOrder").value = 'ASC';
	}
	searchReport(frm, false);
});

$(function () {
	$("#sortable").sortable({
		stop: function () {
			reloadList(false);
		}
	}).disableSelection();
});

(function () {
	var dv = '#listingDiv';

	searchReport = function (frm, withloader) {
		setColumnsData(frm);
		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}
		var data = fcom.frmData(frm);
		fcom.ajax(fcom.makeUrl('Reports', 'searchSalesReport'), data, function (t) {
			$(dv).html(t);
		});
	};

	goToSalesReportSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmReportPaging;
		$(frm.page).val(page);
		searchReport(frm);
	}

	reloadList = function (withloader) {
		var frm = document.frmReportSrch;
		searchReport(frm, withloader);
	};

	clearSearch = function () {
		document.frmReportSrch.reset();
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			if ($(this).attr('disabled') != 'disabled') {
				$(this).prop('checked', false);
			}
		});
		searchReport(document.frmReportSrch);
	};

	exportReport = function () {
		setColumnsData(document.frmReportSrch);
		document.frmReportSrch.action = fcom.makeUrl('Reports', 'exportSalesReport');
		document.frmReportSrch.submit();
	};

	/* redirectBack = function (redirecrt) {
		var url = SITE_ROOT_URL + '' + redirecrt;
		window.location = url;
	} */

	setColumnsData = function (frm) {
		reportColumns = [];
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			reportColumns.push($(this).val());
		});
		$(frm.reportColumns).val(JSON.stringify(reportColumns));
	};

})();