window.recordCount = 0;
$(function () {
	faqRightPanel();
});

$(document).on("search", "#faqQuestionJs", function (e) {
	if ("" == $(this).val()) {
		faqRightPanel();
	}
});

(function () {
	var dv = '#listing';
	var dvCategoryPanel = '#categoryPanel';
	var currPage = 1;

	reloadListing = function () {
		searchFaqs('faq', 0);
	};

	$(document).on('click', 'a.selectedCat', function () {
		var catId = $(this).attr('id');		
		window.location.href = fcom.makeUrl('Custom', 'faqDetail', [parseInt(catId)]);
	});

	$(document).on('click', 'a.selectedFaq', function () {
		var faqId = $(this).attr('data-id');
		var faqcatId = $(this).attr('data-cat-id');
		window.location.href = fcom.makeUrl('Custom', 'faqDetail', [parseInt(faqcatId), parseInt(faqId)]);
	});

	searchFaqsListing = function (frm) {
		let ques = frm.question.value;
		if ('' == ques || 'undefined' == typeof ques) {
			return;
		}

		if (faqsSearchStringLength > ques.length) {
			$.ykmsg.info(langLbl.faqsSearchStringLengthMsg);
			return;
		}

		$(dv).prepend(fcom.getLoader());
		fcom.updateWithAjax(fcom.makeUrl('Custom', 'searchFaqsListing'), 'question=' + ques, function (ans) {
			fcom.closeProcessing();
			fcom.removeLoader();
			$('.faqSectionJs').replaceWith(ans.html);
			highlightSearchedString();
		});
	};

	searchFaqs = function (page, catId) {
		if (catId < 0) {
			catId = 0;
		}
		if (0 < catId) {
			$('.is--active').removeClass('is--active');
			$('#' + catId).addClass('is--active');
		}
		let data = '';
		if ('' != $('#faqQuestionJs').val()) {
			data = 'question=' + $('#faqQuestionJs').val();
		}
		$('.faqSectionJs').prepend(fcom.getLoader());
		fcom.updateWithAjax(fcom.makeUrl('Custom', 'searchFaqs', [page, catId]), data, function (ans) {
			fcom.closeProcessing();

			$('.faqSectionJs').find('.loader-yk').remove();
			$(dv).html(ans.html);
			highlightSearchedString();
			window.recordCount = ans.recordCount;
			fcom.removeLoader();

		});
	};

	faqRightPanel = function () {
		fcom.updateWithAjax(fcom.makeUrl('Custom', 'faqCategoriesPanel'), '', function (ans) {
			fcom.closeProcessing();
			fcom.removeLoader();

			$(dv).find('.loader-yk').remove();
			$(dvCategoryPanel).html(ans.categoriesPanelHtml);
			if (0 < $('.noRecordFoundJs').length && '' != ans.categoriesPanelHtml) {
				$('.noRecordFoundJs').remove();
			}
			window.recordCount = ans.recordCount;
			if (0 < $('.faqCatIdJs.is--active').length) {
				$('.faqCatIdJs.is--active').click();
			} else {
				$('.faqCatIdJs:first').click();
			}

		}, '', false);
	}

	goToLoadMore = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		currPage = page;

		var frm = document.frmSearchFaqsPaging;
		$(frm.page).val(page);
		searchFaqs('faq', 1);
	};

	highlightSearchedString = function () {
		var filter_text = $('#faqQuestionJs').val();
		$('#listing .faqHeading').each(function () {
			if ('' !== filter_text) {
				let headingText = $(this).text();
				var startAt = headingText.toLowerCase().indexOf(filter_text
					.toLowerCase());

				if (startAt >= 0) {
					var endAt = filter_text.length;
					filter_text = headingText.substr(startAt, endAt);
					var replaceWith = "<mark>" + filter_text +
						"</mark>";
					$(this).html(headingText.replace(filter_text, replaceWith));
				} else {
					$(this).text(headingText);
				}

				let faqTextEle = $(this).siblings('.faqText');
				let faqTextContent = faqTextEle.find('p').text();
				var startAt = faqTextContent.toLowerCase().indexOf(filter_text
					.toLowerCase());

				if (startAt >= 0) {
					var endAt = filter_text.length;
					filter_text = faqTextContent.substr(startAt, endAt);
					var replaceWith = "<mark>" + filter_text +
						"</mark>";
					faqTextEle.closest('.collapse').collapse('show');
					faqTextEle.find('p').html(faqTextContent.replace(filter_text, replaceWith));
				} else {
					faqTextEle.find('p').text(faqTextContent);
					faqTextEle.closest('.collapse').collapse('hide');
				}
			} else {
				$(this).text($(this).text());
				$(this).siblings('.faqText').text($(this).siblings('.faqText').find('p').text());
				$('#listing .faqText').collapse('hide');
			}
		});
	}

})();

/* for click scroll function */
$(document).on('click', ".scroll", function (event) {

	if (!window.recordCount) {
		document.frmSearchFaqs.reset();
		$this = $(this);//.find('a');
		searchFaqs(document.frmSearchFaqs, 0, function () { $this.trigger('click'); });
		event.stopPropagation();
		return false;
	}
	event.preventDefault();
	var full_url = this.href;
	var parts = full_url.split("#");
	var trgt = parts[1];
	if ($("#" + trgt).length) {
		var target_offset = $("#" + trgt).offset();
		var target_top = target_offset.top;
		$('html, body').animate({ scrollTop: target_top }, 1000);
	}
});
