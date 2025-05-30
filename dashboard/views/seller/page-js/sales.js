$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});
(function () {
	var dv = '#ordersListing';

	searchRecords = function (frm) {
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/

		$(dv).prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Seller', 'orderProductSearchListing'), data, function (res) {
            fcom.removeLoader();
			$(dv).html(res);
		});
	};

	goToOrderSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmOrderSrchPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	}

	clearSearch = function () {
		document.frmRecordSearch.reset();
		searchRecords(document.frmRecordSearch);
	};

	/* Shipping Services */
	generateLabel = function (opId) {
		fcom.updateWithAjax(fcom.makeUrl('ShippingServices', 'generateLabel', [opId]), '', function (t) {
			window.location.reload();
		});
	}
	/* Shipping Services */
})();