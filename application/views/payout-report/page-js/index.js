$(document).ready(function () {
	searchReport(document.frmReportSearch);
});

$(document).on("click", ".headerColumnJs", function (e) {
	var fld = $(this).attr('data-field');
	var frm = document.frmReportSrchPaging;
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

(function () {
	var dv = '#listingDiv';

	searchReport = function (frm, withloader) {
		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}

		var data = fcom.frmData(frm);		
		fcom.ajax(fcom.makeUrl('PayoutReport', 'search'), data, function (t) {
			$(dv).html(t);
		});
	};

	goToReportSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmReportSrchPaging;
		$(frm.page).val(page);
		searchReport(frm);
	}

	clearSearch = function () {
		document.frmReportSearch.reset();
		searchReport(document.frmReportSearch);
	};

	exportReport = function () {
		document.frmReportSrchPaging.action = fcom.makeUrl('PayoutReport', 'export');
		document.frmReportSrchPaging.submit();
	};
})();