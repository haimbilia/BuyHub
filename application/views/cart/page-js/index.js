$(function () {
	var type = $('input[name="fulfillment_type"]:checked').val();
	listCartProducts(type);
});
(function () {
	listCartProducts = function (fulfilmentType = 2) {
		if (true === isAjaxRunning) { return; }
		if (fulfilmentType == 2) {
			$("#shipping").prop("checked", true);
			$("#pickup").prop("checked", false);
			$(".shippingLblJs").addClass("is-active");
			$(".pickupLblJs").removeClass("is-active");
		}
		if (fulfilmentType == 1) {
			$("#pickup").prop("checked", true);
			$("#shipping").prop("checked", false);
			$(".pickupLblJs").addClass("is-active");
			$(".shippingLblJs").removeClass("is-active");
		}
		$('#cartList').prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Cart', 'listing', [fulfilmentType]), '', function (res) {
			fcom.removeLoader();
			var json = $.parseJSON(res);
			if (json.hasPhysicalProduct == false) {
				$("#js-shiporpickup").remove();
			}

			if (json.cartProductsCount == 0) {
				$("#js-cart-listing").html(json.html);
			} else {
				$("#cartList").html(json.html);
				getCartFinancialSummary(fulfilmentType);
			}

			if (json.shipProductsCount == 0) {
				$("#pickup").prop("checked", true);
				$("#shipping").prop("checked", false).prop("disabled", true).next('label').addClass("disabled").parent().attr("onclick", null);
			} else {
				$("#shipping").prop("disabled", false).next('label').removeClass("disabled").parent().attr("onclick", "listCartProducts(2)");
			}

			if (json.pickUpProductsCount == 0) {
				$("#shipping").prop("checked", true);
				$("#pickup").prop("checked", false).prop("disabled", true).next('label').addClass("disabled").parent().attr("onclick", null);
			} else {
				$("#pickup").prop("disabled", false).next('label').removeClass("disabled").parent().attr("onclick", "listCartProducts(1)");
			}
		});
	};

	getPromoCode = function () {
		fcom.updateWithAjax(fcom.makeUrl('Checkout', "getCoupons"), '', function (res) {
			fcom.removeLoader();
            $.ykmodal(res.html, true);
        });
	};

	triggerApplyCoupon = function (coupon_code) {
		$(".couponCodeJs").val(coupon_code);
		applyPromoCode(document.frmPromoCoupons);
		return false;
	};

	applyPromoCode = function (frm) {
		if (!$(frm).validate()) {return};
        if ('undefined' == typeof frm.coupon_code.value || '' == frm.coupon_code.value) {return;}		
		var data = fcom.frmData(frm);
		$("#js-cartFinancialSummary").prepend(fcom.getLoader());
		fcom.updateWithAjax(fcom.makeUrl('Cart', 'applyPromoCode'), data, function (res) {
			$.ykmodal.close();
			listCartProducts();
		});
	};

	goToCheckout = function () {
		var type = $('input[name="fulfillment_type"]:checked').val();
		var data = "type=" + type;
		fcom.updateWithAjax(fcom.makeUrl('Cart', 'setCartCheckoutType'), data, function (ans) {
			if (isUserLogged() == 0) {
				loginPopUpBox(true);
				return false;
			}
			document.location.href = fcom.makeUrl('Checkout');
		});
	};

	removePromoCode = function () {
		$("#js-cartFinancialSummary").prepend(fcom.getLoader());
		fcom.updateWithAjax(fcom.makeUrl('Cart', 'removePromoCode'), '', function (res) {
			listCartProducts();
		});
	};

	moveToWishlist = function (selprod_id, event, key) {
		event.stopPropagation();
		fcom.ajax(fcom.makeUrl('Account', 'moveToWishList', [selprod_id], siteConstants.webroot_dashboard), '', function (resp) {
			removeFromCart(key);
		});
	};

	addToFavourite = function (key, selProdId) {
		if (isUserLogged() == 0) {
			loginPopUpBox();
			return false;
		}
		$.ykmsg.close();
		fcom.updateWithAjax(fcom.makeUrl('Account', 'markAsFavorite', [selProdId], siteConstants.webroot_dashboard), '', function (ans) {
			if (ans.status) {
				removeFromCart(key);
			}
		});
	};

	moveToSaveForLater = function (key, selProdId, fulfilmentType) {
		if (isUserLogged() == 0) {
			loginPopUpBox();
			return false;
		}
		$.ykmsg.close();
		fcom.updateWithAjax(fcom.makeUrl('Account', 'moveToSaveForLater', [selProdId], siteConstants.webroot_dashboard), '', function (ans) {
			if (ans.status) {
				listCartProducts(fulfilmentType);
				fcom.displaySuccessMessage(langLbl.MovedSuccessfully);
			}
		});
	};

	removeFromWishlist = function (selprod_id, wish_list_id, event) {
		if (!confirm(langLbl.confirmDelete)) { return false; };
		addRemoveWishListProduct(selprod_id, wish_list_id, event);
		listCartProducts();
	};

	moveToCart = function (selprod_id, wish_list_id, event, fulfilmentType) {
		var data = 'selprod_id[0]=' + selprod_id;
		fcom.updateWithAjax(fcom.makeUrl('cart', 'addSelectedToCart'), data, function (ans) {
			addRemoveWishListProduct(selprod_id, wish_list_id, event);
			listCartProducts(fulfilmentType);
			cart.loadCartSummary();
			setTimeout(function () {
				if (1 > $("#cartList").length) {
					location.reload();
				}
			}, 500);
		});
	};

	removePickupOnlyProducts = function () {
		if (confirm(langLbl.confirmRemove)) {
			fcom.updateWithAjax(fcom.makeUrl('Cart', 'removePickupOnlyProducts'), '', function (ans) {
				listCartProducts(2);
				cart.loadCartSummary();
			});
		}
	}

	removeShippedOnlyProducts = function () {
		if (confirm(langLbl.confirmRemove)) {
			fcom.updateWithAjax(fcom.makeUrl('Cart', 'removeShippedOnlyProducts'), '', function (ans) {
				listCartProducts(1);
				cart.loadCartSummary();
			});
		}
	}

	setCheckoutType = function (type) {
		var data = "type=" + type;
		fcom.updateWithAjax(fcom.makeUrl('Cart', 'setCartCheckoutType'), data, function (ans) {
			if (isUserLogged() == 0) {
				loginPopUpBox(true);
				return false;
			}
			document.location.href = fcom.makeUrl('Checkout');
		});
	}

	getCartFinancialSummary = function (type) {
		$("#js-cartFinancialSummary").prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Cart', 'getCartFinancialSummary', [type]), '', function (res) {
			$("#js-cartFinancialSummary").hide().html(res).fadeIn();
			fcom.removeLoader();
		});
	}

})();
