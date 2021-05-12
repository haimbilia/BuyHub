$(document).ready(function () {
	searchUsersReport(document.frmReportSearch);
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
	searchUsersReport(frm, false);
});

(function () {
	var currentPage = 1;
	var runningAjaxReq = false;
	var dv = '#listing';

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmReportSearchPaging;
		$(frm.page).val(page);
		searchUsersReport(frm);
	};

	reloadList = function () {
		var frm = document.frmReportSearchPaging;
		searchUsersReport(frm);
	};

	searchUsersReport = function (form) {
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}

		$(dv).html(fcom.getLoader());

		fcom.ajax(fcom.makeUrl('usersReport', 'search'), data, function (res) {
			$(dv).html(res);
		});
	};

	exportReport = function (dateFormat) {
		document.frmReportSearch.action = fcom.makeUrl('usersReport', 'export');
		document.frmReportSearch.submit();
	}

	clearSearch = function () {
		document.frmReportSearch.reset();
		searchUsersReport(document.frmReportSearch);
	};
})();