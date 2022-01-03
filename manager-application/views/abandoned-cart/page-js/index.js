$(document).ready(function () {
	select2('searchFrmUserIdJs', fcom.makeUrl('Users', 'autoComplete'), { user_is_buyer: 1, credential_active: 1, credential_verified: 1 }, '', function () {
		clearSearch();
	});

	select2('searchFrmSellerProductJs', fcom.makeUrl('SellerProducts', 'autoComplete'), {}, '', function () {
		clearSearch();
	});
});


(function () {
	var abandonedcartId = 0;
	var userId = 0;

	discountNotification = function (abandonedcart_id, user_id, product_id) {
		fcom.updateWithAjax(fcom.makeUrl('AbandonedCart', "validateProductForNotification", [product_id]), '', function (t) {
			$.ykmodal(fcom.getLoader());
			var data = 'includeTabs=0&onClear=discountNotification(' + abandonedcart_id + ', ' + user_id + ', ' + product_id + ')';
			fcom.updateWithAjax(fcom.makeUrl('DiscountCoupons', "form"), data, function (t) {
				/* Overwritten with Discount Coupons. */
				controllerName = 'AbandonedCart';

				$.ykmodal(t.html);
				$.ykmsg.close();
				fcom.removeLoader();
			});
			abandonedcartId = abandonedcart_id;
			userId = user_id;
		});
	};

	saveRecord = function (frm) {
		if (!$(frm).validate()) { return; }
		$.ykmodal(fcom.getLoader());

		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('DiscountCoupons', 'setup'), data, function (t) {
			/* Overwritten with Discount Coupons. */
			controllerName = 'AbandonedCart';

			fcom.removeLoader();
			$.ykmsg.success(t.msg);
			$.ykmodal.close();
			reloadList();

			updateCouponUser(t.recordId, userId);
			sendDiscountNotification(abandonedcartId, t.recordId);
			return;
		});
	};

	updateCouponUser = function (couponId, userId) {
		var data = 'linkType=users&id=' + userId + '&recordId=' + couponId;
		fcom.ajax(fcom.makeUrl('DiscountCoupons', 'bindItem'), data, function (t) {
			/* Overwritten with Discount Coupons. */
			controllerName = 'AbandonedCart';
		});
	};

	sendDiscountNotification = function (abandonedcartId, couponId) {
		var data = 'abandonedcartId=' + abandonedcartId + '&couponId=' + couponId;
		fcom.updateWithAjax(fcom.makeUrl('AbandonedCart', 'discountNotification'), data, function (t) {
			reloadList();
		});
	};

	callCouponDiscountIn = function (val, DISCOUNT_IN_PERCENTAGE, DISCOUNT_IN_FLAT) {
		if (val == DISCOUNT_IN_PERCENTAGE) {
			$("#coupon_max_discount_value_div").show();
			if (100 < $('.discountValueJs').val()) {
				$('.discountValueJs').val(100);
			}
		}
		if (val == DISCOUNT_IN_FLAT) {
			$("#coupon_max_discount_value_div").hide();
		}
	};

	callCouponTypePopulate = function (val) {
		if (val == 1) {
			$("#couponMinorderDivJs").show();
			$("#couponValidforDivJs").hide();

		} if (val == 3) {
			$("#couponMinorderDivJs").hide();
			$("#couponValidforDivJs").show();
		}
	};
})();

