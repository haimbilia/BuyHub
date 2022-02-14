$(document).ready(function () {
	searchRecords(document.frmMessageSrch);
});
(function () {
	var dv = '#messageListing';

	searchRecords = function (frm) {
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = '';
		if (frm) {
			data = fcom.frmData(frm);
		}
		/*]*/
		$(dv).prepend(fcom.getLoader());

		fcom.ajax(fcom.makeUrl('Account', 'messageSearch'), data, function (res) {
            fcom.removeLoader();
			$(dv).html(res);
		});
	};

	goToMessageSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmMessageSrchPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	};

	clearSearch = function () {
		document.frmMessageSrch.reset();
		searchRecords(document.frmMessageSrch);
	};

	viewThread = function (obj) {
		var currEle = $(obj);
		var threadId = currEle.data('threadId');
		$('.listItemJs.is-active').removeClass('is-active');
		currEle.addClass('is-active');
		$('.threadJs').prepend(fcom.getLoader());
		fcom.updateWithAjax(fcom.makeUrl('Account', "viewThread", [threadId]), '', function (t) {
            fcom.removeLoader();
			$('.userJs').remove();
			$('.threadJs').replaceWith(t.html);
		});
	};
})();	