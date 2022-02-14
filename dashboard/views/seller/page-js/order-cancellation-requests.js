$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});

(function () {
	searchRecords = function (frm) {
		var data = fcom.frmData(frm);
		$("#cancelOrderRequestsListing").prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Seller', 'orderCancellationRequestSearch'), data, function (res) {
            fcom.removeLoader();
			$("#cancelOrderRequestsListing").html(res);
		});
	};

	goToOrderCancelRequestSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmOrderCancellationRequestSrchPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	}
})();