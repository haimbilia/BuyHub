$(function () {
	$(document).on('click', ".btnProductBuy--js", function (event) {
		event.preventDefault();

		var selprod_id = $(this).attr('data-id');
		var quantity = $(this).attr('data-min-qty');
		cart.add(selprod_id, quantity, true);
		return false;
	});

	$(document).on('click', ".btnAddToCart--js", function (event) {
		event.preventDefault();
		var data = $("#frmBuyProduct").serialize();
		var selprod_id = $(this).attr('data-id');
		var quantity = $(this).attr('data-min-qty');
		var cartHasProducts = $(this).data('cartHasProduct');
		if (0 < cartHasProducts && !confirm(langLbl.overwriteCartItems)) {
			return false;
		}
		data = "selprod_id=" + selprod_id + "&quantity=" + quantity;
		ykevents.addToCart();
		fcom.updateWithAjax(fcom.makeUrl('cart', 'add'), data, function (ans) {
			fcom.closeProcessing();
			fcom.removeLoader();
			if (ans['redirect']) {
				location = ans['redirect'];
				return false;
			}
			$('span.cartQuantity').html(ans.total);
			cart.loadCartSummary();
		});
		return false;
	});
});

