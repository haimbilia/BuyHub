$(function () {

	$('.wrapper-menu').on('click', function () {
		$('html').toggleClass("nav-opened");
		$(this).toggleClass("open");

		$('.search-toggle').removeClass('active');
		$('html').removeClass("form-opened");
	});

	$('.search-toggle').on('click', function () {
		$(this).toggleClass('active');
		$('html').toggleClass("form-opened");

		$('.wrapper-menu').removeClass("open");
		$('html').removeClass("nav-opened");
	})

	$('.js-tabs li').on('click', function () {
		$(this).siblings().removeClass('is--active');
		$(this).addClass('is--active');
		moveToTargetDiv(this);
		return false;
	});

	var tabs = $(".js-tabs li a");

	tabs.click(function () {
		var content = this.hash.replace('/', '');
		tabs.removeClass("active");
		$(this).addClass("active");
		$(this).parents('.container').find('.tabs-content').find('.content-data').hide();
		$(content).fadeIn(200);

	});

	$("body").mouseup(function (e) {
		if (1 > $(event.target).parents('.social-toggle').length && $('.social-toggle').next().hasClass('open-menu')) {
			$('.social-toggle').next().toggleClass('open-menu');
		}
	});

});

$(document).on('click', '.social-toggle', function () {
	$(this).next().toggleClass('open-menu');
});

$("body").mouseup(function (e) {
	if (1 > $(event.target).parents('.social-toggle').length && $('.social-toggle').next().hasClass('open-menu')) {
		$('.social-toggle').next().toggleClass('open-menu');
	}
});

function submitBlogSearch(frm) {
	let url = fcom.makeUrl('Blog', 'search');
	url += setQueryParamSeperator(url);

	var qryParam = ($(frm).serialize_without_blank());
	var url_arr = [];
	if (qryParam.indexOf("keyword") > -1) {
		let keyword = ($(frm).find('input[name="keyword"]').val()).trim();
		let protomatch = /^(https?|ftp):\/\//;
		url += "keyword-" + encodeURIComponent(keyword.replace(protomatch, '').replace(/\//g, '-'));
	}

	if (qryParam.indexOf("category") > -1) {
		url += setQueryParamSeperator(url) + "category-" + $(frm).find('select[name="category"]').val();
	}

	let pageSize = parseInt($("#pageSizeJs").val());
	if (pageSize > 0) {
		url += setQueryParamSeperator(url) + 'pagesize-' + pageSize;
	}
	
	document.location.href = url;
}
