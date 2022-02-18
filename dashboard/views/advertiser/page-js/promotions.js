$(document).ready(function () {
	searchRecords(document.frmRecordSearch);
});
$(document).on('change', '.banner-language-js', function () {
	;
	// $(document).delegate('.banner-language-js','change',function(){
	var lang_id = $(this).val();
	var promotion_id = $("input[name='promotion_id']").val();
	var screen_id = $(".banner-screen-js").val();
	images(promotion_id, lang_id, screen_id);
});
$(document).on('change', '.banner-screen-js', function () {
	;
	// $(document).delegate('.banner-screen-js','change',function(){
	var screen_id = $(this).val();
	var promotion_id = $("input[name='promotion_id']").val();
	var lang_id = $(".banner-language-js").val();
	images(promotion_id, lang_id, screen_id);
});
$(document).on('blur', "input[name='promotion_budget']", function () {
	;
	// $(document).delegate("input[name='promotion_budget']",'blur',function(){
	if ('' != $(this).val()) {
		var frm = document.frmPromotion;
		var data = fcom.frmData(frm);
		fcom.ajax(fcom.makeUrl('Advertiser', 'checkValidPromotionBudget'), data, function (t) {
			var ans = $.parseJSON(t);
			if (ans.status == 0) {
				$("select[name='banner_blocation_id']").val('');
				$.mbsmessage(ans.msg, false, 'alert--danger');
				return;
			}
			$.mbsmessage.close();
		});
	}
});
$(document).on('change', "select[name='banner_blocation_id']", function () {
	// $(document).delegate("select[name='banner_blocation_id']",'change',function(){
	if ('' != $("input[name='promotion_budget']").val()) {
		$("input[name='promotion_budget']").trigger('blur');
	}
});
(function () {
	var dv = '#listing';

	goToSearchPage = function (page) {
		if (typeof page == undefined || page == null) {
			page = 1;
		}
		var frm = document.frmPromotionSearchPaging;
		$(frm.page).val(page);
		searchRecords(frm);
	};

	reloadList = function () {
		var frm = document.frmPromotionSearchPaging;
		searchRecords(frm);
		$('.formshowhide-js').show();
	};

	searchRecords = function (form) {
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		$(dv).prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Advertiser', 'searchPromotions'), data, function (t) {
			fcom.removeLoader();
			$(dv).html(t);
			if (!$(dv).hasClass('card-body')) {
				$(dv).addClass('card-body')
			}
		});
	};

	promotionForm = function (promotionId) {
		fcom.ajax(fcom.makeUrl('Advertiser', 'promotionForm', [promotionId]), '', function (t) {
			fcom.removeLoader();
			$.ykmodal(t, false, 'modal-dialog-vertical-md');
			bindProductsAutocomplete();
		});
	};

	promotionLangForm = function (promotionId, langId, autoFillLangData = 0) {		
		$('#promotionsChildBlockJs').prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Advertiser', 'promotionLangForm', [promotionId, langId, autoFillLangData]), '', function (t) {
			fcom.removeLoader();
			$('#promotionsChildBlockJs').html(t);	
			setNavTab('lang');		
		});
	};

	promotionMediaForm = function (promotionId) {
		$('#promotionsChildBlockJs').prepend(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Advertiser', 'promotionMediaForm', [promotionId]), '', function (t) {
			fcom.removeLoader();
			$('#promotionsChildBlockJs').html(t);
			images(promotionId, 0, $(".banner-screen-js").val());
		});
	};

	images = function (promotion_id, lang_id, screen_id) {
		fcom.ajax(fcom.makeUrl('Advertiser', 'images', [promotion_id, lang_id, screen_id]), '', function (t) {
			fcom.removeLoader();
			$('#image-listing-js').html(t);
		});
	};

	setupPromotion = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);		
		fcom.updateWithAjax(fcom.makeUrl('Advertiser', 'setupPromotion'), data, function (t) {
			if (t.langId) {
				promotionForm(t.promotionId);
				promotionLangForm(t.promotionId, t.langId);				
				return;
			}			
			return;
		});
	};

	setupPromotionLang = function (frm) {
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Advertiser', 'setupPromotionLang'), data, function (t) {
			if (t.langId) {
				promotionLangForm(t.promotionId, t.langId);
				return;
			} else if (typeof t.noMediaTab == undefined || t.noMediaTab == null) {
				promotionMediaForm(t.promotionId);
				setNavTab('media');
			}
			//promotionForm(t.promotionId);
			return;
		});
	};

	removePromotionBanner = function (promotionId, bannerId, langId, screen) {
		if (!confirm(langLbl.confirmDelete)) { return; }
		data = 'promotionId=' + promotionId + '&bannerId=' + bannerId + '&langId=' + langId + '&screen=' + screen;
		fcom.updateWithAjax(fcom.makeUrl('Advertiser', 'removePromotionBanner'), data, function (res) {
			images(promotionId, langId, screen);
		});
	};

	/* deletepromotionRecord = function(id){
		if(!confirm(langLbl.confirmDelete)){return;}
		data='id='+id;
		fcom.updateWithAjax(fcom.makeUrl('Advertiser','deletePromotionRecord'),data,function(res){
			reloadList();
		});
	}; */

	clearPromotionSearch = function () {
		document.frmRecordSearch.reset();
		document.frmRecordSearch.active_promotion.value = '-1';
		searchRecords(document.frmRecordSearch);
	};

	viewWrieFrame = function (locationId) {
		if (locationId) {
			fcom.ajax(fcom.makeUrl('Banner', 'locationFrames', [locationId]), '', function (t) {
				$.ykmodal(t);
			});
			
		} else {
			alert(langLbl.selectLocation);
		}
	};

	popupImage = function (inputBtn) {
		if (inputBtn.files && inputBtn.files[0]) {
			$.ykmodal(fcom.getLoader(), '', 'cropper-body');
			fcom.ajax(fcom.makeUrl('Advertiser', 'imgCropper'), '', function (t) {
				$.ykmodal(t);
				var file = inputBtn.files[0];
				var minWidth = document.frmPromotionMedia.banner_min_width.value;
				var minHeight = document.frmPromotionMedia.banner_min_height.value;
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
				return cropImage(file, options, 'promotionUpload');
			});
		}
	};

	promotionUpload = function (formData) {
		var promotionId = document.frmPromotionMedia.promotion_id.value;
		var promotionType = document.frmPromotionMedia.promotion_type.value;
		var langId = document.frmPromotionMedia.lang_id.value;
		var banner_screen = document.frmPromotionMedia.banner_screen.value;
		formData.append('promotion_id', promotionId);
		formData.append('promotion_type', promotionType);
		formData.append('lang_id', langId);
		formData.append("banner_screen", banner_screen);
		$.ajax({
			url: fcom.makeUrl('Advertiser', 'promotionUpload', [promotionId]),
			type: 'post',
			dataType: 'json',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('#loader-js').prepend(fcom.getLoader());
			},
			success: function (ans) {
				fcom.removeLoader();
				$.mbsmessage.close();
				if (ans.status == true) {
					$.mbsmessage(ans.msg, '', 'alert--success');
				} else {
					$.mbsmessage(ans.msg, '', 'alert--danger');
				}
				$('#form-upload').remove();
				images(promotionId, langId, banner_screen);
				$(document).trigger('close.facebox');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}

	togglePromotionStatus = function (e, obj) {
		if (!confirm(langLbl.confirmUpdateStatus)) {
			e.preventDefault();
			return;
		}
		var promotionId = parseInt(obj.value);
		if (promotionId < 1) {
			return false;
		}
		data = 'promotionId=' + promotionId;
		fcom.ajax(fcom.makeUrl('Advertiser', 'changePromotionStatus'), data, function (res) {
			var ans = $.parseJSON(res);
			if (ans.status == 1) {
				$.mbsmessage(ans.msg, true, 'alert--success');
			} else {
				$.mbsmessage(ans.msg, true, 'alert--danger');
			}
			/* loadSellerProducts(document.frmSearchSellerProducts); */
		});
	};

	getRecordTypeURL = function () {
		/* if ("" == sellerId || 1 > sellerId) {
			console.error(langLbl.invalidRequest);
			return false;
		}
		if (RECORD_TYPE_PRODUCT == recordType) {
			return fcom.makeUrl('Products', 'autoComplete');
		} else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
			return fcom.makeUrl('SellerProducts', 'autoComplete');
		} else if (RECORD_TYPE_SHOP == recordType) {
			return fcom.makeUrl('Shops', 'autoComplete');
		} else {
			console.error(langLbl.invalidRequest);
			return false;
		} */
		return fcom.makeUrl("Advertiser", "autoCompleteSelprods");
	}

	bindProductsAutocomplete = function () {
		select2('promotionProductJs', getRecordTypeURL());
	}

})();