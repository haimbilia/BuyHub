$(document).ready(function(){
	searchProductsInventory(document.frmProductInventorySrch);
});

$(document).on("click", ".headerColumnJs", function (e) {
	var fld = $(this).attr('data-field');	
	var frm = document.frmProductInventorySrchPaging;
	document.getElementById("sortBy").value = fld;
	$(frm.sortBy).val(fld);
	if (document.getElementById("sortOrder").value == 'ASC') {
		$(frm.sortOrder).val('DESC');
		document.getElementById("sortOrder").value = 'DESC';
	} else {
		$(frm.sortOrder).val('ASC');
		document.getElementById("sortOrder").value = 'ASC';
	}
	searchProductsInventory(frm, false);
});

(function() {
	var runningAjaxReq = false;
	var dv = '#listingDiv';
	
	searchProductsInventory = function(frm, withloader){
		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}

		var data = fcom.frmData(frm);
		fcom.ajax(fcom.makeUrl('Reports', 'searchProductsInventory'), data, function(t) {			
			$(dv).html(t);
		});
	};
	
	goToProductsInventorySearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page = 1;
		}		
		var frm = document.frmProductInventorySrchPaging;		
		$( frm.page ).val( page );
		searchProductsInventory( frm );
	}
	
	clearSearch = function(){
		document.frmProductInventorySrch.reset();
		searchProductsInventory(document.frmProductInventorySrch);
	};
	
	exportProductsInventoryReport = function(){
		document.frmProductInventorySrchPaging.action = fcom.makeUrl('Reports','exportProductsInventoryReport');
		document.frmProductInventorySrchPaging.submit();
	};
})();