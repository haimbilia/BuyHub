$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
	$('.listingRecordJs .listItemJs.is-active').trigger('click');
});
(function () {
	var dv = '.listingRecordJs';

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
			$('[data-thread-id=' + $('.threadJs').data('threadId') + ']').addClass('is-active');
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
		document.frmRecordSearch.reset();
		searchRecords(document.frmRecordSearch);
	};

	viewThread = function (obj) {
		var currEle = $(obj);
		var threadId = currEle.data('threadId');
		$('.listItemJs.is-active').removeClass('is-active');
		currEle.addClass('is-active');
		$('.threadJs').prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Account', "viewThread", [threadId]), '', function (t) {
			fcom.removeLoader();
			$('.userJs').remove();
			$('.threadJs').replaceWith(t.html);
			$('.msg-count').html(t.todayUnreadMessageCount);
			$('.messages').scrollTop($('.messages')[0].scrollHeight);

		}, { fOutMode: 'json' });
	};

	sendMessage = function (frm) {
		if (!$(frm).validate()) { return; }
		if (frm.message_text.value == '') { return; }
		var data = fcom.frmData(frm);
		$('.threadJs').prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Account', 'sendMessage'), data, function (t) {
			fcom.removeLoader();
			$(frm.message_text).val('');
			searchRecords(document.frmRecordSearch);
			viewThread($('[data-thread-id="' + frm.message_thread_id.value + '"]'));
		}, { fOutMode: 'json' });
	};
})();	