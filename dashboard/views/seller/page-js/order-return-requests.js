$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});
(function () {
	searchRecords = function (frm) {
		var data = fcom.frmData(frm);
		$("#returnOrderRequestsListing").html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Seller', 'orderReturnRequestSearch'), data, function (res) {
			$("#returnOrderRequestsListing").html(res);
			fcom.removeLoader();
		});
	};

	goToOrderReturnRequestSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmOrderReturnRequestSrchPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	}

})();