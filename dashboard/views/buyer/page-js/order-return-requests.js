$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});
(function () {
	searchRecords = function (frm) {
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/

		$("#returnOrderRequestsListing").prepend(fcom.getLoader());

		fcom.ajax(fcom.makeUrl('Buyer', 'orderReturnRequestSearch'), data, function (res) {
            fcom.removeLoader();
			$("#returnOrderRequestsListing").html(res);
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

	clearOrderReturnRequestSearch = function () {
		document.frmRecordSearch.reset();
		searchRecords(document.frmRecordSearch);
	};
})();