$(document).ready(function () {
	searchProductsReport(document.frmProductsReportSearch);

	$('input[name=\'shop_name\']').autocomplete({
		'classes': {
			"ui-autocomplete": "custom-ui-autocomplete"
		},
		'source': function (request, response) {
			$.ajax({
				url: fcom.makeUrl('Shops', 'autoComplete'),
				data: { keyword: request['term'], fIsAjax: 1 },
				dataType: 'json',
				type: 'post',
				success: function (json) {
					response($.map(json, function (item) {
						return { label: item['name'], value: item['name'], id: item['id'] };
					}));
				},
			});
		},
		select: function (event, ui) {
			$("input[name='shop_id']").val(ui.item.id);
		}
	});

	$('input[name=\'brand_name\']').autocomplete({
		'classes': {
			"ui-autocomplete": "custom-ui-autocomplete"
		},
		'source': function (request, response) {
			$.ajax({
				url: fcom.makeUrl('Brands', 'autoComplete'),
				data: { keyword: request['term'], fIsAjax: 1 },
				dataType: 'json',
				type: 'post',
				success: function (json) {
					response($.map(json, function (item) {
						return { label: item['name'], value: item['name'], id: item['id'] };
					}));
				},
			});
		},
		select: function (event, ui) {
			$("input[name='brand_id']").val(ui.item.id);
		}
	});

	$('input[name=\'shop_name\']').keyup(function () {
		if ($(this).val() == "") {
			$("input[name='shop_id']").val(0);
		}
	});

	$('input[name=\'brand_name\']').keyup(function () {
		if ($(this).val() == "") {
			$("input[name='brand_id']").val(0);
		}
	});

});

$(document).on("click", ".headerColumnJs", function (e) {
	var fld = $(this).attr('data-field');
	var frm = document.frmProductsReportSearchPaging;
	document.getElementById("sortBy").value = fld;
	$(frm.sortBy).val(fld);
	if (document.getElementById("sortOrder").value == 'ASC') {
		$(frm.sortOrder).val('DESC');
		document.getElementById("sortOrder").value = 'DESC';
	} else {
		$(frm.sortOrder).val('ASC');
		document.getElementById("sortOrder").value = 'ASC';
	}
	searchProductsReport(frm, false);
});

$(function () {
	$("#sortable").sortable({
		stop: function () {
			reloadList(false);
		}
	}).disableSelection();
});

(function () {
	var dv = '#listing';

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmProductsReportSearchPaging;
		$(frm.page).val(page);
		searchProductsReport(frm);
	};

	reloadList = function (withloader) {
		var frm = document.frmProductsReportSearchPaging;
		searchProductsReport(frm, withloader);
	};

	searchProductsReport = function (frm, withloader) {
		setColumnsData(frm);

		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}

		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}
		fcom.ajax(fcom.makeUrl('ProductsReport', 'search'), data, function (res) {
			$(dv).html(res);
		});
	};

	exportReport = function () {
		setColumnsData(document.frmProductsReportSearch);
		document.frmProductsReportSearch.action = fcom.makeUrl('ProductsReport', 'export');
		document.frmProductsReportSearch.submit();
	}

	clearSearch = function () {
		document.frmProductsReportSearch.shop_id.value = '0';
		document.frmProductsReportSearch.brand_id.value = '0';
		document.frmProductsReportSearch.reset();
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			if ($(this).attr('disabled') != 'disabled') {
				$(this).prop('checked', false);
			}
		});
		searchProductsReport(document.frmProductsReportSearch);
	};

	setColumnsData = function (frm) {
		reportColumns = [];
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			reportColumns.push($(this).val());
		});

		$(frm.reportColumns).val(JSON.stringify(reportColumns));
	};
})();