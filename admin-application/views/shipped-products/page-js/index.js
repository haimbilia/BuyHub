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

	reloadList = function() {
        var frm = document.frmShippedProductsPaging;
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

	updateProductsShipping = function(productId, shipProfileId) {
		$.facebox(function() {
			updateProductsShippingForm(productId, shipProfileId);
		});
	}

	updateProductsShippingForm = function(productId, shipProfileId) {
		fcom.ajax(fcom.makeUrl('ShippedProducts', 'updateProductsShipping', [productId, shipProfileId]), '', function(t) {
			fcom.updateFaceboxContent(t);
		});
	};

    updateStatus = function (frm){
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('ShippedProducts', 'updateStatus'), data, function(t) {			
			reloadList();			
			$(document).trigger('close.facebox');
	    });
    };

	clearShippedProductsSearch = function(){
		document.frmShippedProductsSearch.reset();
		searchShippedProducts(document.frmShippedProductsSearch);
	};

})();