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
		var dv = $('#listing');
		$(dv).prepend(fcom.getLoader());

		fcom.ajax(fcom.makeUrl('Seller', 'searchUrlRewritingProducts'), data, function (res) {
            fcom.removeLoader();
			$("#listing").html(res);
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
	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmsearchUrlRewritingProductsPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	}

	reloadList = function () {
		searchRecords(document.frmRecordSearch);
	}

	editUrlForm = function (selprod_id) {
		fcom.ajax(fcom.makeUrl('seller', 'productUrlForm', [selprod_id]), '', function (t) {
			$("#dvForm").html(t);
			$("#dvAlert").hide();
		});

	};

	setupProductUrl = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('seller', 'setupCustomUrl'), data, function (t) {

		});
	}

	$(document).on('change', "input[name='custom_url']", function () {
		var selprod_id = $(this).attr('data-selprod_id');
		var url_rewriting_id = $(this).attr('data-url_rewriting_id');
		var custom_url = $(this).val();
		if (custom_url == '') {
			$(this).addClass('error');
			return false;
		}
		fcom.updateWithAjax(fcom.makeUrl('seller', 'setupCustomUrl', [selprod_id, url_rewriting_id, custom_url]), '', function (t) {
			reloadList();
		});
	});

})();
