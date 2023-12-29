$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
	$(document).ready(function () {
		$(document).on('click', '.showMoreJs', function () {
			$('.lessContentJs').hide();
			$('.moreContentJs').show();
		});
		$(document).on('click', '.showLessJs', function () {
			$('.moreContentJs').hide();
			$('.lessContentJs').show();
		});
	});
});
(function () {
	searchRecords = function (frm) {
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/

		$("#listing").html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl(controllerName, 'search'), data, function (res) {
			$("#listing").html(res);
			fcom.removeLoader();
		});
	};

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmSrchPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	};

	viewRfq = function (rfqId) {
		fcom.updateWithAjax(fcom.makeUrl(controllerName, 'view', [rfqId]), [], function (ans) {
			fcom.closeProcessing();
			fcom.removeLoader();
			$.ykmodal(ans.html, false, 'modal-lg');
		});
	};
})();

