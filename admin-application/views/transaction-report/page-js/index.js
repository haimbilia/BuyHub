$(document).ready(function () {
	searchReport(document.frmReportSearch);
});
$(document).on("click", ".headerColumnJs", function (e) {
	var fld = $(this).attr('data-field');
	var frm = document.frmReportSearchPaging;
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
	var dv = '#listing';

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmReportSearchPaging;
		$(frm.page).val(page);
		searchReport(frm);
	};

	reloadList = function (withloader) {
		var frm = document.frmReportSearchPaging;
		searchReport(frm, withloader);
	};

	searchReport = function (frm, withloader) {
		setColumnsData(frm);

		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}

		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}

		fcom.ajax(fcom.makeUrl('TransactionReport', 'search'), data, function (res) {
			$(dv).html(res);
		});
	};

	exportReport = function () {
		setColumnsData(document.frmReportSearch);
		document.frmReportSearch.action = fcom.makeUrl('TransactionReport', 'export');
		document.frmReportSearch.submit();
	}

	clearSearch = function () {
		document.frmReportSearch.reset();
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			if ($(this).attr('disabled') != 'disabled') {
				$(this).prop('checked', false);
			}
		});
		searchReport(document.frmReportSearch);
	};

	setColumnsData = function (frm) {
		reportColumns = [];
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			reportColumns.push($(this).val());
		});

		$(frm.reportColumns).val(JSON.stringify(reportColumns));
	};

})();