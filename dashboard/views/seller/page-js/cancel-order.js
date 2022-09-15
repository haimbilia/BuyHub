$(document).ready(function () {
	$('html, body').animate({ scrollTop: $(".cancelReason-js").offset().top }, 1000);
});

function pageRedirect() {
	window.location.replace(fcom.makeUrl('Seller', 'Sales'));
}
(function () {
	cancelReason = function (frm) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'cancelReason'), data, function (t) {
			/* window.location.href = fcom.makeUrl('Seller' ,'Sales'); */
			setTimeout("pageRedirect()", 1000);
		});
	};
	
	loadOpShippingCharges = function (orderId, chargeType, opId = 0) {
		if (0 < $(".opShippingChargesJs").length) {
			$.ykmodal.show();
		} else {
			$.ykmodal(fcom.getLoader());
			fcom.ajax(fcom.makeUrl('Order', 'orderProductsCharges', [orderId, chargeType, opId]), '', function (ans) {
				fcom.removeLoader();
				$.ykmsg.close();
				$.ykmodal(ans, false, 'modal-dialog-vertical-md opShippingChargesJs');
			});
		}
	};

})();
