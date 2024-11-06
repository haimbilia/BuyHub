$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});

(function () {
	var runningAjaxReq = false;
	checkRunningAjax = function () {
		if (runningAjaxReq == true) {
			console.log(runningAjaxMsg);
			return;
		}
		runningAjaxReq = true;
	};

	searchRecords = function (frm) {
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/

		$("#ordersListing").prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Seller', 'orderSearchListing'), data, function (res) {
			fcom.removeLoader();
			$("#ordersListing").html(res);
		});
	};


	toggleAutoRenewal = function () {
		checkRunningAjax();
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'toggleAutoRenewalSubscription'), '', function (res) {
			runningAjaxReq = false;
			if (res.autoRenew) {
				$(".switch-button").addClass('is--active');
			} else {
				$(".switch-button").removeClass('is--active');
			}

		});
	};
	$(document).on('click', '.auto-renew-js', function () {
		toggleAutoRenewal();
	});

	goToOrderSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmOrderSrchPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	};

	clearSearch = function () {
		document.frmRecordSearch.reset();
		searchRecords(document.frmRecordSearch);
	};

	renewSubscription = function (ossubs_id) {
		if (!confirm(langLbl.subscriptionRenew)) {
			return false;
		}
		fcom.displayProcessing();
		location.href = fcom.makeUrl('SubscriptionCheckout', 'renewSubscriptionOrder', [ossubs_id]);
	};

})();