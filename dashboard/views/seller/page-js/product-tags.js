$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});

(function () {
	var dv = '#listing';
	searchRecords = function (frm) {
		/*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}
		/*]*/
		$(dv).prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Seller', 'searchProductTags'), data, function (res) {
			fcom.removeLoader();
			$(dv).html(res);
		});
	};
	clearSearch = function (selProd_id) {
		if (0 < selProd_id) {
			location.href = fcom.makeUrl('Seller', 'volumeDiscount');
		} else {
			document.frmRecordSearch.reset();
			searchRecords(document.frmRecordSearch);
		}
	};
	goToCatalogProductSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmCatalogProductSearchPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	}

	reloadList = function () {
		var frm = document.frmRecordSearch;
		searchRecords(frm);
	}

	attachTag = function (e) {
		let tag_id = e.detail.data.id;
		let product_id = $(e.detail.tagify.DOM.originalInput).attr('data-product_id');
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'updateProductTag'), 'product_id=' + product_id + '&tag_id=' + tag_id, function (t) { });
	}

	addTagData = function (e) {
		var product_id = $(e.detail.tagify.DOM.originalInput).attr('data-product_id');
		var tag_id = e.detail.data.id;

		if (tag_id == undefined || tag_id == '') {
			var tag_name = e.detail.tag.title;
			var lang_id = $('input[name=lang_id]').val() || 0;
			var data = { tag_name, lang_id };
			fcom.updateWithAjax(fcom.makeUrl('Seller', 'tagSetup'), data, function (t) {
				fcom.updateWithAjax(fcom.makeUrl('Seller', 'updateProductTag'), 'product_id=' + product_id + '&tag_id=' + t.tagId, function (t3) {
					e.detail.tag.id = t.tagId;
				});
			});
		}

	}

	removeTagData = function (e) {
		var tag_id = e.detail.tag.id;
		var product_id = $(e.detail.tagify.DOM.originalInput).attr('data-product_id');
		fcom.updateWithAjax(fcom.makeUrl('Seller', 'removeProductTag'), 'product_id=' + product_id + '&tag_id=' + tag_id, function (t) {
		});
	}

	setupProductLangMetaTag = function (frm, exit) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('seller', 'setupProdMetaLang'), data, function (t) {
			if (!exit && t.langId > 0) {
				editProductMetaTagLangForm(t.metaRecordId, t.langId);
				return;
			} else {
				$("#dvForm").hide();
				$("#dvAlert").show();
			}
		});
	}

	langForm = function (obj) {
		document.frmRecordSearch.lang_id.value = $(obj).val();
		searchRecords(document.frmRecordSearch);
	}

})();
