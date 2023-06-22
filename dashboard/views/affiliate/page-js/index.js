var facebookScope = "email";
$(document).ready(function () {
	$('.showbutton').click(function () {
		$(this).toggleClass("active");
		$('.showwrap').slideToggle("600");
	});

	$("#twitter_btn").click(function (event) {
		event.preventDefault();
		twitter_login();
	});
	personalInfo();

	$('.openBulkEmailForm').click(function () {
		$('#bulkEmailForm').appendTo("body").modal('show');

	});
});

(function () {
	var tabListing = "#tabListing";

	personalInfo = function (el) {
		$(tabListing).html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Account', 'personalInfo'), '', function (res) {
			fcom.removeLoader();
			$(tabListing).html(res);
			$(el).parent().siblings().removeClass('is-active');
			$(el).parent().addClass('is-active');
		});
	};

	addressInfo = function (el) {
		$(tabListing).html(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Affiliate', 'addressInfo'), '', function (res) {
			$(tabListing).html(res);
			$(el).parent().siblings().removeClass('is-active');
			$(el).parent().addClass('is-active');
		});
	};

	setUpMailAffiliateSharing = function (frm) {
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Affiliate', 'setUpMailAffiliateSharing'), data, function (t) {
			frm.reset();
			$("#bulkEmailForm").modal('hide');
		});
	};
})();
