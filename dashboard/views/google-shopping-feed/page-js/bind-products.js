var keyName = "GoogleShoppingFeed";
$(document).ready(function () {
	searchProducts();
});

(function () {
	var dv = "#listing";

	bindproductform = function (adsBatchId = 0, selProdId = 0) {
		$.ykmodal(fcom.getLoader());
		fcom.ajax(
			fcom.makeUrl(keyName, "bindProductForm", [adsBatchId, selProdId]),
			"",
			function (res) {
				fcom.removeLoader();
				$.ykmodal(res);
				bindProductsAutocomplete();
				bindGoogleCatAutocomplete();
			}
		);
	};

	clearForm = function () {
		bindproductform();
	};

	searchProducts = function (frm = '') {
		$(dv).prepend(fcom.getLoader());
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}
		var adsBatchId = $("input[name='adsBatchId']").val();
		fcom.ajax(
			fcom.makeUrl(keyName, "searchProducts", [adsBatchId]),
			data,
			function (res) {
				fcom.removeLoader();
				$(dv).html(res);
			}
		);
	};

	setupProductsToBatch = function (frm) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(
			fcom.makeUrl(keyName, "setupProductsToBatch"),
			data,
			function (t) {
				closeForm();
				searchProducts();
			}
		);
	};

	unlinkProduct = function (adsBatchId, selProdId) {
		var agree = confirm(langLbl.confirmDelete);
		if (!agree) {
			return false;
		}
		fcom.updateWithAjax(
			fcom.makeUrl(keyName, "unlinkProduct", [adsBatchId, selProdId]),
			"",
			function (t) {
				searchProducts();
			}
		);
	};

	unlinkproducts = function (adsBatchId) {
		if (typeof $(".selectItem--js:checked").val() === "undefined") {
			fcom.displayErrorMessage(langLbl.atleastOneRecord);
			return false;
		}
		var agree = confirm(langLbl.confirmDelete);
		if (!agree) {
			return false;
		}
		var data = fcom.frmData(document.getElementById("frmBatchSelprodListing"));
		fcom.displayProcessing();
		fcom.ajax(
			fcom.makeUrl(keyName, "unlinkProducts", [adsBatchId]),
			data,
			function (t) {
				var ans = $.parseJSON(t);
				if (ans.status == 1) {
					fcom.displaySuccessMessage(ans.msg);
					$(".formActionBtn-js").addClass("disabled");
				} else {
					fcom.displayErrorMessage(ans.msg);
				}
				searchProducts();
			}
		);
	};

	bindProductsAutocomplete = function () {
		var ele = $(".sellerProductJs");
		ele.select2({
			closeOnSelect: true,
			dropdownParent: ele.closest('form'),
			dir: langLbl.layoutDirection,
			allowClear: true,
			placeholder: ele.attr("placeholder"),
			ajax: {
				url: fcom.makeUrl("Seller", "autoCompleteProducts"),
				dataType: "json",
				delay: 250,
				method: "post",
				data: function (params) {
					return {
						keyword: params.term, // search term
						page: params.page,
					};
				},
				processResults: function (data, params) {
					params.page = params.page || 1;
					return {
						results: data.results,
						pagination: {
							more: params.page < data.pageCount,
						},
					};
				},
				cache: true,
			},
			minimumInputLength: 0,			
		}).on('select2:open', function(e) {   
			ele.data("select2").$dropdown.addClass("custom-select2 custom-select2-single"); 
		})
		.data("select2").$container.addClass("custom-select2-width custom-select2 custom-select2-single");

	}

	bindGoogleCatAutocomplete = function () {
		var ele = $(".googleCatIdJs");
		select2('googleCatIdJs', fcom.makeUrl(keyName, "getProductCategoryAutocomplete"));
	}

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmSearchPaging;
		$(frm.page).val(page);
		searchProducts(frm);
	};
})();
