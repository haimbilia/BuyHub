$(document).ready(function () {
	select2('searchFrmSellerProductJs', fcom.makeUrl('SellerProducts', 'autoComplete'), {}, '', function () {
		clearSearch();
	});
});