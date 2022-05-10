window.recordCount = 0;
$(function () {
	faqRightPanel();
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
		var faqId = 0;
		window.location.href = fcom.makeUrl('Custom', 'faqDetail', [catId, faqId]);
	});

	$(document).on('click', 'a.selectedFaq', function () {
		var faqId = $(this).attr('data-id');
		var faqcatId = $(this).attr('data-cat-id');
		window.location.href = fcom.makeUrl('Custom', 'faqDetail', [faqcatId, faqId]);
	});

	searchFaqs = function (page, catId) {
		if (catId < 0) {
			catId = 0;
		}
		$(dv).prepend(fcom.getLoader());
		if (0 < catId) {
			$('.is--active').removeClass('is--active');
			$('#' + catId).addClass('is--active');
		}
		fcom.updateWithAjax(fcom.makeUrl('Custom', 'SearchFaqs', [page, catId]), '', function (ans) {
			fcom.closeProcessing();

			$(dv).find('.loader-yk').remove();
			$(dv).html(ans.html);

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
