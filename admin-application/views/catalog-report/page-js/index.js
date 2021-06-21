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

$(function () {
	$("#sortable").sortable({
		stop: function () {
			reloadList(false);
		}
	}).disableSelection();
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

	reloadList = function (withloader) {
		var frm = document.frmCatalogReportSearchPaging;
		searchCatalogReport(frm, withloader);
	};

	searchCatalogReport = function (form, withloader) {
		setColumnsData(form);
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

	exportReport = function () {
		setColumnsData(document.frmCatalogReportSearch);
		document.frmCatalogReportSearch.action = fcom.makeUrl('CatalogReport', 'export');
		document.frmCatalogReportSearch.submit();
	}

	clearSearch = function () {
		document.frmCatalogReportSearch.reset();
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			if ($(this).attr('disabled') != 'disabled') {
				$(this).prop('checked', false);
			}
		});
		searchCatalogReport(document.frmCatalogReportSearch);
	};

	setColumnsData = function (frm) {
		reportColumns = [];
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			reportColumns.push($(this).val());
		});

		$(frm.reportColumns).val(JSON.stringify(reportColumns));
	};
})();