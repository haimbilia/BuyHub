$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});

(function () {
	searchRecords = function (frm) {
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/

		$("#ordersListing").prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Buyer', 'orderSearchListing'), data, function (res) {
            fcom.removeLoader();
			$("#ordersListing").html(res);
		});
	};

	addItemsToCart = function (orderId) {
		fcom.displayProcessing();
		$("#ordersListing").prepend(fcom.getLoader());
		fcom.updateWithAjax(fcom.makeUrl('Buyer', 'addItemsToCart', [orderId]), '', function (ans) {
			window.location = fcom.makeUrl('Cart', '', '', siteConstants.dashboard_redirect);
			return true;
		});
	};

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmRecordSearchPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	};

	clearSearch = function () {
		document.frmRecordSearch.reset();
		searchRecords(document.frmRecordSearch);
	};

})();