$(document).ready(function () {
	searchShopsReport(document.frmShopsReportSearch);

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
		'select': function (event, ui) {
			$("input[name='shop_id']").val(ui.item.id);
		}
	});

	$('input[name=\'user_name\']').autocomplete({
		'classes': {
			"ui-autocomplete": "custom-ui-autocomplete"
		},
		'source': function (request, response) {
			$.ajax({
				url: fcom.makeUrl('Users', 'autoCompleteJson'),
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
		'select': function (event, ui) {
			$("input[name='shop_user_id']").val(ui.item.id);
		}
	});

	$('input[name=\'shop_name\']').keyup(function () {
		if ($(this).val() == "") {
			$("input[name='shop_id']").val(0);
		}
	});

	$('input[name=\'user_name\']').keyup(function () {
		if ($(this).val() == "") {
			$("input[name='shop_user_id']").val(0);
		}
	});

});

$(document).on("click", ".headerColumnJs", function (e) {
	var fld = $(this).attr('data-field');
	var frm = document.frmShopsReportSearchPaging;
	document.getElementById("sortBy").value = fld;
	$(frm.sortBy).val(fld);
	if (document.getElementById("sortOrder").value == 'ASC') {
		$(frm.sortOrder).val('DESC');
		document.getElementById("sortOrder").value = 'DESC';
	} else {
		$(frm.sortOrder).val('ASC');
		document.getElementById("sortOrder").value = 'ASC';
	}
	searchShopsReport(frm, false);
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
		var frm = document.frmShopsReportSearchPaging;
		$(frm.page).val(page);
		searchShopsReport(frm);
	};

	reloadList = function (withloader) {
		var frm = document.frmShopsReportSearchPaging;
		searchShopsReport(frm, withloader);
	};

	searchShopsReport = function (frm, withloader) {
		setColumnsData(frm);
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}

		if (typeof withloader == 'undefined' || withloader != false) {
			$(dv).html(fcom.getLoader());
		}

		fcom.ajax(fcom.makeUrl('ShopsReport', 'search'), data, function (res) {
			$(dv).html(res);
		});
	};

	exportReport = function () {
		setColumnsData(document.frmShopsReportSearch);
		document.frmShopsReportSearch.action = fcom.makeUrl('ShopsReport', 'export');
		document.frmShopsReportSearch.submit();
		// location.href = fcom.makeUrl('ShopsReport', 'export');
	}

	clearSearch = function () {
		document.frmShopsReportSearch.shop_id.value = '0';
		document.frmShopsReportSearch.shop_user_id.value = '0';
		document.frmShopsReportSearch.reset();
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			if ($(this).attr('disabled') != 'disabled') {
				$(this).prop('checked', false);
			}
		});
		searchShopsReport(document.frmShopsReportSearch);
	};

	setColumnsData = function (frm) {
		reportColumns = [];
		$("input:checkbox[name=reportColumns]:checked").each(function () {
			reportColumns.push($(this).val());
		});

		$(frm.reportColumns).val(JSON.stringify(reportColumns));
	};
})();
