$(document).ready(function () {
	loadSellerProducts(document.frmSearchSellerProducts);
});

$(document).on('change', '.selprodoption_optionvalue_id', function () {
	var frm = document.frmSellerProduct;
	var selprodId = $(frm.selprod_id).val();
	$(frm.selprod_id).val('');
	var data = fcom.frmData(frm);
	fcom.ajax(fcom.makeUrl('Seller', 'checkSellProdAvailableForUser'), data, function (t) {
		var ans = $.parseJSON(t);
		$(frm.selprod_id).val(selprodId);
		if (ans.status == 0) {
			fcom.displayErrorMessage(ans.msg);
			return;
		}
		$.ykmsg.close();
	});
});

(function () {
	var runningAjaxReq = false;
	//var dv = '#sellerProductsForm';
	var dv = '#listing';

	checkRunningAjax = function () {
		if (runningAjaxReq == true) {
			console.log(runningAjaxMsg);
			return;
		}
		runningAjaxReq = true;
	};

	loadSellerProducts = function (frm) {
		searchRecords(frm, 1);
	};

	searchRecords = function (frm, page) {
		if (typeof page !== undefined) {
			$(frm.page).val(page);
		}
		$('#listing').prepend(fcom.getLoader());
		/* if product id is not passed, then it will become or will fetch custom products of that seller. */
		var product_id = frm.product_id.value;
		if (typeof product_id == undefined || product_id == null) {
			product_id = 0;
		}
		var data = fcom.frmData(document.frmRecordSearch);
		fcom.ajax(fcom.makeUrl('Seller', 'sellerProducts', [product_id]), data, function (t) {
			fcom.removeLoader();
			$('#listing').html(t);
		});
	}

	goToSellerProductSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmRecordSearch;
		$(frm.page).val(page);
		searchRecords(frm, page);
	}

	productInstructions = function (type) {
		fcom.ajax(fcom.makeUrl('Seller', 'productTooltipInstruction', [type]), '', function (t) {
			$.ykmodal(t);
		});
	};

	sellerProductForm = function (product_id, selprod_id) {
		$(dv).prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Seller', 'sellerProductForm', [product_id, selprod_id]), '', function (t) {
			fcom.removeLoader();
			$(dv).html(t);
		});
	};

	sellerProductDelete = function (id) {
		if (!confirm(langLbl.confirmDelete)) { return; }
		data = 'id=' + id;
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'sellerProductDelete'), data, function (res) {
			fcom.removeLoader();
			loadSellerProducts(document.frmSearchSellerProducts);
		});
	};

	deleteSelected = function () {
		if (!confirm(langLbl.confirmDelete)) { return; }
		$("#frmSellerProductsListing").attr("action", fcom.makeUrl('Seller', 'deleteBulkSellerProducts')).submit();
	};

	sellerProductCloneForm = function (product_id, selprod_id) {
		fcom.ajax(fcom.makeUrl('Seller', 'sellerProductCloneForm', [product_id, selprod_id]), '', function (t) {
			$.ykmodal(t);
		});
	};

	setUpSellerProductClone = function (frm) {
		if (!$(frm).validate()) { return; }
		runningAjaxReq = true;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'setUpSellerProductClone'), data, function (t) {
			runningAjaxReq = false;
			$.ykmodal.close();
			loadSellerProducts(document.frmSearchSellerProducts);
			/* if(t.selprod_id > 0){
				$(frm.splprice_selprod_id).val(t.selprod_id);
			}	 */
		});
	};

	reloadList = function () {
		loadSellerProducts(document.frmRecordSearch);
	};

	toggleBulkStatues = function (status) {
		if (!confirm(langLbl.confirmUpdateStatus)) {
			return false;
		}
		$("#frmSellerProductsListing input[name='status']").val(status);
		$("#frmSellerProductsListing").submit();
	};

	toggleSellerProductStatus = function (e, obj) {
		if (!confirm(langLbl.confirmUpdateStatus)) {
			e.preventDefault();
			return;
		}
		var selprodId = parseInt(obj.value);
		if (selprodId < 1) {
			return false;
		}
		data = 'selprodId=' + selprodId;
		fcom.ajax(fcom.makeUrl('Seller', 'changeProductStatus'), data, function (res) {
			var ans = $.parseJSON(res);
			if (ans.status == 1) {
				fcom.displaySuccessMessage(ans.msg);
			} else {
				fcom.displayErrorMessage(ans.msg);
				$(obj).prop('checked', !$(obj).prop('checked'));
			}
			/* loadSellerProducts(document.frmSearchSellerProducts); */
		});
	};

	addSpecialPrice = function () {
		if (typeof $(".selectItem--js:checked").val() === 'undefined') {
			fcom.displayErrorMessage(langLbl.atleastOneRecord);
			return false;
		}
		$("#frmSellerProductsListing").attr({ 'action': fcom.makeUrl('Seller', 'specialPrice'), 'target': "_blank" }).removeAttr('onsubmit').submit();
		loadSellerProducts(document.frmRecordSearch);
	}

	addVolumeDiscount = function () {
		if (typeof $(".selectItem--js:checked").val() === 'undefined') {
			fcom.displayErrorMessage(langLbl.atleastOneRecord);
			return false;
		}
		$("#frmSellerProductsListing").attr({ 'action': fcom.makeUrl('Seller', 'volumeDiscount'), 'target': "_blank" }).removeAttr('onsubmit').submit();
		loadSellerProducts(document.frmRecordSearch);
	};
	productMissingInfo = function(selProdId){     
        fcom.updateWithAjax(fcom.makeUrl('Seller', 'productMissingInfo'), {recordId: selProdId}, function(t) { 
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
            
        });
    }
})();