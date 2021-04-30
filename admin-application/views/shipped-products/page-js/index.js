$(document).ready(function(){
	searchShippedProducts(document.frmShippedProductsSearch);
});
(function() {
	goToSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page = 1;
		}
		var frm = document.frmShippedProductsPaging;
		$(frm.page).val(page);
		searchShippedProducts(frm);
	}

	searchShippedProducts = function(form){
		var dv = $('#shippedProductsListing');
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		dv.html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('ShippedProducts','search'),data,function(res){
			dv.html(res);
		});
	};

	clearShippedProductsSearch = function(){
		document.frmShippedProductsSearch.reset();
		searchShippedProducts(document.frmShippedProductsSearch);
	};

})();