$(document).ready(function () {
	searchSalesReport(document.frmSalesReportSrch);
});

$(document).on("click", ".headerColumnJs", function (e) {
	var fld = $(this).attr('data-field');
	var frm = document.frmSalesReportSrchPaging;
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
	var runningAjaxReq = false;
	var dv = '#listingDiv';

	searchSalesReport = function (frm, withloader) {
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
		var frm = document.frmSalesReportSrchPaging;
		$(frm.page).val(page);
		searchSalesReport(frm);
	}

	clearSearch = function () {
		document.frmSalesReportSrch.reset();
		searchSalesReport(document.frmSalesReportSrch);
	};

	exportSalesReport = function () {
		document.frmSalesReportSrchPaging.action = fcom.makeUrl('Reports', 'exportSalesReport');
		document.frmSalesReportSrchPaging.submit();
	};

	/* redirectBack=function(redirecrt){
	var url=	SITE_ROOT_URL +''+redirecrt;
	window.location=url;
	} */

})();