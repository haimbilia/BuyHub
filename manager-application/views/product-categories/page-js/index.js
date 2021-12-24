$(document).ready(function () {
	reloadList();
});

(function () {
	var dv = "#listing";

	reloadList = function () {
		fcom.updateWithAjax(fcom.makeUrl('productCategories', 'search'), '', function (res) {
			$(dv).html(res.html);
			$.ykmsg.close();
			fcom.removeLoader();
		});
	};

	categoryForm = function (prodCatId) {
		fcom.updateWithAjax(fcom.makeUrl('productCategories', 'form', [prodCatId]), '', function (res) {
			$.ykmsg.close();
			fcom.removeLoader();
			$(dv).html(res.html);
			if (prodCatId > 0) {
				categoryImages(prodCatId, 'icon', 1);
				categoryImages(prodCatId, 'banner', 1);
			}
		});
	}

	setupCategory = function () {
		var frm = $('#frmProdCategory');
		var validator = $(frm).validation({ errordisplay: 3 });
		if (validator.validate() == false) {
			return false;
		}
		if (!$(frm).validate()) {
			return false;
		}
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'setup'), data, function (t) {
			if (t.status == 1) {
				editRecord(t.categoryId);
			}
		});
	};

	discardForm = function () {
		reloadList();
	}

	goToProduct = function (prodCatId) {
		window.location.href = fcom.makeUrl('Products', 'form', [0, prodCatId]);
	};

	updateStatus = function (e, obj, recordId, status) {
		if (false === checkControllerName()) {
			return false;
		}

		e.stopPropagation();
		/* if (!confirm(langLbl.confirmUpdateStatus)) {
			e.preventDefault();
			return false;
		} */

		var oldStatus = $(obj).attr("data-old-status");
		$('.listingTableJs').prepend(fcom.getLoader());

		if (1 > recordId) {
			$(obj).prop("checked", 1 == oldStatus);
			$.ykmsg.error(langLbl.invalidRequest);
			fcom.removeLoader();
			return false;
		}

		data = "recordId=" + recordId + "&status=" + status;
		fcom.ajax(
			fcom.makeUrl(controllerName, "updateStatus"),
			data,
			function (res) {
				$(obj).prop("checked", 1 == status);
				var ans = JSON.parse(res);
				if (ans.status == 1) {
					$.ykmsg.success(ans.msg);
					$(obj).attr({
						onclick:
							"updateStatus(event, this, " + recordId + ", " + oldStatus + ")",
						"data-old-status": status,
					});
					reloadList();
				} else {
					$(obj).prop("checked", 1 == oldStatus);
					$.ykmsg.error(ans.msg);
				}
				fcom.removeLoader();
			}
		);
	};

	displaySubCategories = function (obj, catId = 0, data, callable = '') {
		$(obj).removeClass('clickable');
		if (catId > 0) {
			var prodCatId = catId;
		} else {
			var prodCatId = $(obj).parent().parent().parent().attr('id');
		}

		if ($("#" + prodCatId + ' ul.append-ul').length) {
			$("#" + prodCatId + ' ul:first').show();
			if (catId == 0) {
				togglePlusMinus(prodCatId);
			}
			if (catId > 0) {
				updateCatOrder(data);
			}
			return false;
		}

		fcom.updateWithAjax(fcom.makeUrl('productCategories', 'getSubCategories'), 'prodCatId=' + prodCatId, function (res) {
			if ($("#" + prodCatId).children('ul.append-ul').length) {
				$("#" + prodCatId).children('ul.append-ul').append(res.html);
			} else {
				$("#" + prodCatId).append('<ul class="append-ul">' + res.html + '</ul>');
			}
			if (catId == 0) {
				togglePlusMinus(prodCatId);
			}
			if (catId > 0) {
				updateCatOrder(data);
			}

			if ('' != callable) {
				window[callable]();
			}
		});
	}

	togglePlusMinus = function (prodCatId) {
		$("#" + prodCatId).children('div').children('.sortableListsOpener').remove();
		if ($("#" + prodCatId).hasClass('sortableListsClosed')) {
			$("#" + prodCatId).removeClass('sortableListsClosed').addClass('sortableListsOpen');
			$("#" + prodCatId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-minus clickable sort-icon cat' + prodCatId + '-js" onClick="hideItems(this)"></i></span>');
		} else {
			$("#" + prodCatId).removeClass('sortableListsOpen').addClass('sortableListsClosed');
			$("#" + prodCatId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon cat' + prodCatId + '-js" onClick="displaySubCategories(this)"></i></span>');
		}

		$("#" + prodCatId + ' > ul:first > li:has(> ul)').children('div').children('.sortableListsOpener').remove();
		$("#" + prodCatId + ' > ul:first > li:has(> ul)').removeClass('sortableListsOpen').addClass('sortableListsClosed');
		$("#" + prodCatId + ' > ul:first > li:has(> ul)').children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon" onClick="displaySubCategories(this)"></i></span>');
	}

	hideItems = function (obj) {
		var prodCatId = $(obj).parent().parent().parent().attr('id');
		$("#" + prodCatId + ' ul').hide();
		$("#" + prodCatId).removeClass('sortableListsOpen').addClass('sortableListsClosed');
		var icon = $("#" + prodCatId).children('div').children('.sortableListsOpener').remove();
		$("#" + prodCatId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon" onClick="displaySubCategories(this)"></i></span>');
	}

	updateCatOrder = function (data) {
		fcom.updateWithAjax(fcom.makeUrl('productCategories', 'updateOrder'), data, function (res) {
			reloadList();
			$("#js-cat-section").removeClass('overlay-blur');
			setTimeout(function () {
				data = queryStringToJSON(data);
				goToCategory(data.catId);
			}, 1000);
		});
	}

	categoryImages = function (prodCatId, imageType, slide_screen, lang_id = 0) {
		fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'images', [prodCatId, imageType, lang_id, slide_screen]), '', function (t) {
			fcom.removeLoader();
			$.ykmsg.close();
			if (imageType == 'icon') {
				$('#icon-imageListingJs').html(t.html);
				var prodCatId = $("[name='prodcat_id']").val();
				if (prodCatId == 0) {
					var iconImageId = $("#icon-imageListingJs li").attr('id');
					var selectedLangId = $(".icon-language-js").val();
					$("[name='cat_icon_image_id[" + selectedLangId + "]']").val(iconImageId);
				}
			} else if (imageType == 'banner') {
				$('#banner-imageListingJs').html(t.html);
				var bannerImageId = $("#banner-imageListingJs li").attr('id');
				var selectedLangId = $(".banner-language-js").val();
				var screen = $(".prefDimensions-js").val();
				$("[name='cat_banner_image_id[" + selectedLangId + "_" + screen + "]']").val(bannerImageId);
			}
		});
	};

	deleteImage = function (fileId, prodcatId, imageType, langId, slide_screen) {
		if (!confirm(langLbl.confirmDeleteImage)) { return; }
		fcom.updateWithAjax(fcom.makeUrl('productCategories', 'removeImage', [fileId, prodcatId, imageType, langId, slide_screen]), '', function (t) {
			categoryImages(prodcatId, imageType, slide_screen, langId);

		});
	};

	translateData = function (item) {
		var autoTranslate = $("input[name='auto_update_other_langs_data']:checked").length;
		var defaultLang = $(item).attr('defaultLang');
		var catName = $("input[name='prodcat_name[" + defaultLang + "]']").val();
		var toLangId = $(item).attr('language');
		var alreadyOpen = $('#collapse_' + toLangId).hasClass('active');
		if (autoTranslate == 0 || catName == "" || alreadyOpen == true) {
			return false;
		}
		var data = "catName=" + catName + "&toLangId=" + toLangId;
		fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'translatedCategoryData'), data, function (t) {
			if (t.status == 1) {
				$("input[name='prodcat_name[" + toLangId + "]']").val(t.prodCatName);
			}
		});
	}

	bannerPopupImage = function (inputBtn) {
		loadCropperSkeleton();
		if (inputBtn.files && inputBtn.files[0]) {
			fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'imgCropper'), '', function (t) {
				$("#modalBoxJs .modal-body").html(t.body);
				$("#modalBoxJs .modal-footer").html(t.footer);
				var file = inputBtn.files[0];
				var minWidth = document.frmRecordImage.banner_min_width.value;
				var minHeight = document.frmRecordImage.banner_min_height.value;
				var options = {
					aspectRatio: aspectRatio,
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

	uploadCatImages = function (formData) {
		var slideScreen = 0;
		var prodcatId = $("[name='prodcat_id']").val();
		if (formData.get("file_type") == 'icon') {
			var afileId = $("#icon-imageListingJs img").data('afile_id');
			var langId = $("[name='icon_lang_id']").val();
			var fileType = $("[name='icon_file_type']").val();
			var imageType = 'icon';
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
					$.ykmsg.error(ans.msg);
					return;
				}
				$.ykmsg.success(ans.msg);
				categoryImages(prodcatId, imageType, slideScreen, langId);
				$("#modalBoxJs").modal("hide");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}

	var parentIds = [];
	var i = 0;
	goToCategory = function (catId = 0) {
		if (0 < parentIds.length) {
			parentIds = i >= parentIds.length ? [] : parentIds;

			if (i < parentIds.length) {
				const element = $('.cat' + parentIds[i] + '-js')[0];
				i = i + 1;
				displaySubCategories(element, 0, '', 'goToCategory');
			}
			return;
		} else {
			i = 0;
			fcom.ajax(fcom.makeUrl('ProductCategories', 'getParentIds', [catId]), '', function (t) {
				var ans = JSON.parse(t);
				if (0 < ans.status) {
					parentIds = ans.data;
					if (i < parentIds.length) {
						const element = $('.cat' + parentIds[i] + '-js')[0];
						i = i + 1;
						displaySubCategories(element, 0, '', 'goToCategory');
					}
				}
			});
		}
	}

	mediaForm = function (record_id) {
		fcom.updateWithAjax(fcom.makeUrl('ProductCategories', 'imagesForm', [record_id]), '', function (t) {
			$.ykmodal(t.html);
			$.ykmsg.close();
			fcom.removeLoader();
			if (record_id > 0) {
				categoryImages(record_id, 'icon', 1);
				categoryImages(record_id, 'banner', 1);
			}
		});
	};
})();


$(document).on('change', '.icon-language-js', function () {
	var lang_id = $(this).val();
	var prodcat_id = $("input[name='prodcat_id']").val();
	var imageId = $("[name='cat_icon_image_id[" + lang_id + "]']").val();
	if (prodcat_id == 0) {
		if (imageId > 0) {
			categoryImages(prodcat_id, 'icon', 0, lang_id);
		} else {
			$("#icon-imageListingJs").html('');
		}
	} else {
		categoryImages(prodcat_id, 'icon', 0, lang_id);
	}

});

$(document).on('change', '.banner-language-js', function () {
	var lang_id = $(this).val();
	var prodcat_id = $("input[name='prodcat_id']").val();
	var slide_screen = $("input[name='slide_screen']").val();
	var imageId = $("[name='cat_banner_image_id[" + lang_id + "_" + slide_screen + "]']").val();
	if (prodcat_id == 0) {
		if (imageId > 0) {
			categoryImages(prodcat_id, 'banner', slide_screen, lang_id);
		} else {
			$("#banner-imageListingJs").html('');
		}
	} else {
		categoryImages(prodcat_id, 'banner', slide_screen, lang_id);
	}

});

$(document).on('change', '.prefDimensions-js', function () {
	var slide_screen = $(this).val();
	var prodcat_id = $("input[name='prodcat_id']").val();
	var lang_id = $(".banner-language-js").val();
	var imageId = $("[name='cat_banner_image_id[" + lang_id + "_" + slide_screen + "]']").val();
	if (prodcat_id == 0) {
		if (imageId > 0) {
			categoryImages(prodcat_id, 'banner', slide_screen, lang_id);
		} else {
			$("#banner-imageListingJs").html('');
		}
	} else {
		categoryImages(prodcat_id, 'banner', slide_screen, lang_id);
	}
});
