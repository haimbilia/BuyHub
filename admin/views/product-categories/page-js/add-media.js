(function () {
	var dv = "#listing";
	bannerPopupImage = function (inputBtn) {
		loadCropperSkeleton();
		if (inputBtn.files && inputBtn.files[0]) {
			fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'imgCropper'), '', function (t) {
				fcom.closeProcessing();
				$("#modalBoxJs .modal-body").html(t.body);
				$("#modalBoxJs .modal-footer").html(t.footer);
				var file = inputBtn.files[0];
				var minWidth = document.frmRecordImage.banner_min_width.value;
				var minHeight = document.frmRecordImage.banner_min_height.value;
				var options = {
					aspectRatio: minWidth / minHeight,
					data: {
						width: minWidth,
						height: minHeight,
					},
					minCropBoxWidth: minWidth,
					minCropBoxHeight: minHeight,
					toggleDragModeOnDblclick: false,
					imageSmoothingQuality: 'high',
					imageSmoothingEnabled: true,
				};
				$(inputBtn).val('');
				setTimeout(function () { cropImage(file, options, "uploadCatImages", inputBtn); }, 100);
				return;
			});
		}
	};

	iconPopupImage = function (inputBtn) {
		loadCropperSkeleton();
		if (inputBtn.files && inputBtn.files[0]) {
			fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'imgCropper'), '', function (t) {
				fcom.closeProcessing();
				$("#modalBoxJs .modal-body").html(t.body);
				$("#modalBoxJs .modal-footer").html(t.footer);
				var file = inputBtn.files[0];
				var minWidth = document.frmRecordImage.logo_min_width.value;
				var minHeight = document.frmRecordImage.logo_min_height.value;
				var options = {
					aspectRatio: 1 / 1,
					data: {
						width: minWidth,
						height: minHeight,
					},
					minCropBoxWidth: minWidth,
					minCropBoxHeight: minHeight,
					toggleDragModeOnDblclick: false,
					imageSmoothingQuality: 'high',
					imageSmoothingEnabled: true,
				};
				$(inputBtn).val('');
				setTimeout(function () { cropImage(file, options, "uploadCatImages", inputBtn); }, 100);
				return;
			});
		}
	};

	thumbPopupImage = function (inputBtn) {
		loadCropperSkeleton();
		if (inputBtn.files && inputBtn.files[0]) {
			fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'imgCropper'), '', function (t) {
				fcom.closeProcessing();
				$("#modalBoxJs .modal-body").html(t.body);
				$("#modalBoxJs .modal-footer").html(t.footer);
				var file = inputBtn.files[0];
				var minWidth = document.frmRecordImage.thumb_min_width.value;
				var minHeight = document.frmRecordImage.thumb_min_height.value;
				var options = {
					aspectRatio: 1 / 1,
					data: {
						width: minWidth,
						height: minHeight,
					},
					minCropBoxWidth: minWidth,
					minCropBoxHeight: minHeight,
					toggleDragModeOnDblclick: false,
					imageSmoothingQuality: 'high',
					imageSmoothingEnabled: true,
				};
				$(inputBtn).val('');
				setTimeout(function () { cropImage(file, options, "uploadCatImages", inputBtn); }, 100);
				return;
			});
		}
	};

	uploadCatImages = function (formData) {
		var slideScreen = 0;
		var prodcatId = $("[name='prodcat_id']").val();
		if (formData.get("file_type") == 'icon') {
			var afileId = $("#icon-imageListingJs img").data('afile_id');
			var langId = $("[name='icon_lang_id']").val();
			var fileType = $("[name='icon_file_type']").val();
			var imageType = 'icon';
		} else if (formData.get("file_type") == 'thumb') {
			var afileId = $("#thumb-imageListingJs img").data('afile_id');
			var langId = $("[name='thumb_lang_id']").val();
			var fileType = $("[name='thumb_file_type']").val();
			var imageType = 'thumb';
		} else {
			var afileId = $("#banner-imageListingJs img").data('afile_id');
			var langId = $("[name='banner_lang_id']").val();
			var fileType = $("[name='banner_file_type']").val();
			slideScreen = $("[name='slide_screen']").val();
			var imageType = 'banner';
		}
		formData.append('prodcat_id', prodcatId);
		formData.append('slide_screen', slideScreen);
		formData.append('lang_id', langId);
		formData.append('file_type', fileType);
		formData.append('afile_id', afileId);
		$.ajax({
			url: fcom.makeUrl('ProductCategories', 'setUpCatImages'),
			type: 'post',
			dataType: 'json',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$.ykmodal(fcom.getLoader());
			},
			success: function (ans) {
				fcom.removeLoader();
				if (ans.status == 0) {
					fcom.displayErrorMessage(ans.msg);
					return;
				}
				fcom.displaySuccessMessage(ans.msg);
				categoryImages(prodcatId, imageType, slideScreen, langId);
				$("#modalBoxJs").modal("hide");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}

	deleteCatImage = function (fileId, prodcatId, imageType, langId, slide_screen) {
		if (!confirm(langLbl.confirmDeleteImage)) { return; }
		fcom.updateWithAjax(fcom.makeUrl('productCategories', 'removeImage', [fileId, prodcatId, imageType, langId, slide_screen]), '', function (t) {
			fcom.displaySuccessMessage(t.msg);
			categoryImages(prodcatId, imageType, slide_screen, langId);

		});
	};

	categoryImages = function (prodCatId, imageType, slide_screen, lang_id = 0) {
		if (imageType == 'icon') {
			var selector = $('#icon-imageListingJs');
		} else if (imageType == 'banner') {
			var selector = $('#banner-imageListingJs');
		} else if (imageType == 'thumb') {
			var selector = $('#thumb-imageListingJs');
		}
		selector.prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('ProductCategories', 'images', [prodCatId, imageType, lang_id, slide_screen]), '', function (t) {
			fcom.closeProcessing();
			fcom.removeLoader();
			selector.html(t.html);
			if (imageType == 'icon') {
				var prodCatId = $("[name='prodcat_id']").val();
				if (prodCatId == 0) {
					var iconImageId = $("#icon-imageListingJs li").attr('id');
					var selectedLangId = $(".icon-language-js").val();
					$("[name='cat_icon_image_id[" + selectedLangId + "]']").val(iconImageId);
				}
			}
		}, { fOutMode: 'json' });
	};
	catMediaForm = function (record_id) {
		fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'imagesForm', [record_id]), '', function (t) {
			fcom.closeProcessing();
			$.ykmodal(t.html);
			fcom.removeLoader();
			if (record_id > 0) {
				categoryImages(record_id, 'icon', 0);
				categoryImages(record_id, 'banner', 1);
				categoryImages(record_id, 'thumb', 0);
			}
		});
	};

})();

$(document).on('change', '.catIconLanguageJs', function () {
	var lang_id = $(this).val();
	var prodcat_id = $("input[name='prodcat_id']").val();
	categoryImages(prodcat_id, 'icon', 0, lang_id);
});

$(document).on('change', '.catBannerLanguageJs', function () {
	var lang_id = $(this).val();
	var prodcat_id = $("input[name='prodcat_id']").val();
	var slide_screen = $(".catPrefDimensionsJs").val();
	categoryImages(prodcat_id, 'banner', slide_screen, lang_id);
});

$(document).on('change', '.thumbLanguageJs', function () {
	var lang_id = $(this).val();
	var prodcat_id = $("input[name='prodcat_id']").val();
	categoryImages(prodcat_id, 'thumb', 0, lang_id);
});

