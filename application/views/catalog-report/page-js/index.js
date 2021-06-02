$(document).ready(function () {
	searchReport(document.frmReportSrch);	
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
	var runningAjaxReq = false;
	var dv = '#listingDiv';

	searchReport = function (frm, withloader) {
		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}
		var data = fcom.frmData(frm);
		fcom.ajax(fcom.makeUrl('CatalogReport', 'search'), data, function (t) {
			$(dv).html(t);
		});
	};

	goToSalesReportSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmReportSrchPaging;
		$(frm.page).val(page);
		searchReport(frm);
	}

	clearSearch = function () {
		document.frmReportSrch.reset();
		searchReport(document.frmReportSrch);
	};

	exportSalesReport = function () {
		document.frmReportSrchPaging.action = fcom.makeUrl('CatalogReport', 'export');
		document.frmReportSrchPaging.submit();
	};

	/* redirectBack=function(redirecrt){
	var url=	SITE_ROOT_URL +''+redirecrt;
	window.location=url;
	} */

})();