$(document).ready(function () {
	searchAdvertisersReport(document.frmReportSearch);
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
	searchAdvertisersReport(frm, false);
});
(function () {
	var dv = '#listing';

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmReportSearchPaging;
		$(frm.page).val(page);
		searchAdvertisersReport(frm);
	};

	reloadList = function () {
		var frm = document.frmReportSearchPaging;
		searchAdvertisersReport(frm);
	};

	searchAdvertisersReport = function (form, withloader) {
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}

		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}

		fcom.ajax(fcom.makeUrl('AdvertisersReport', 'search'), data, function (res) {
			$(dv).html(res);
		});
	};

	exportReport = function (dateFormat) {
		document.frmReportSearch.action = fcom.makeUrl('AdvertisersReport', 'export');
		document.frmReportSearch.submit();
	}

	clearSearch = function () {
		document.frmReportSearch.reset();
		searchAdvertisersReport(document.frmReportSearch);
	};
})();