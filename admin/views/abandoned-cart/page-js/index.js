$(document).ready(function () {
	select2('searchFrmUserIdJs', fcom.makeUrl('Users', 'autoComplete'), { user_is_buyer: 1, credential_active: 1 });
	select2('searchFrmSellerProductJs', fcom.makeUrl('SellerProducts', 'autoComplete'));
});


(function () {
	var abandonedcartId = 0;
	var userId = 0;
	var productId = 0;
	var dv = ".listingRecordJs";
    var paginationDv = ".listingPaginationJs";
    var listingTableJs = ".listingTableJs";

	searchRecords = function (frm, page) {
        
        setColumnsData(frm);
        var data = "";
        if (frm) {
            data = fcom.frmData(frm);
        }
		data = data + '&loadPagination=0';

        $(listingTableJs).prepend(fcom.getLoader());

        fcom.ajax(fcom.makeUrl('AbandonedCart', "search"), data, function (res) {
            if (0 == res.status) {
                fcom.displayErrorMessage(res.msg);
                return;
            }
            if (res.headSection) {
                $('.tableHeadJs').replaceWith(res.headSection);
            }
            $(dv).replaceWith(res.listingHtml);
            $(paginationDv).replaceWith(res.paginationHtml);
            fcom.removeLoader();
            var pageVal = $(document.frmRecordSearchPaging.page).val();
            if (typeof pageVal == 'undefined' || pageVal != page) {
                loadPagination(document.frmRecordSearchPaging, page);
            }
        }, { fOutMode: 'json' });
    };

	discountNotification = function (abandonedcart_id, user_id, product_id) {
		fcom.updateWithAjax(fcom.makeUrl('AbandonedCart', "validateProductForNotification", [product_id]), '', function (t) {
			fcom.closeProcessing();
			var data = 'onClear=discountNotification(' + abandonedcart_id + ', ' + user_id + ', ' + product_id + ')';
			fcom.updateWithAjax(fcom.makeUrl('DiscountCoupons', "form"), data, function (t) {
				fcom.closeProcessing();
				$.ykmodal(t.html);
				fcom.removeLoader();
				$('#couponType').val(PRODUCT_DISCOUNT).parents('.form-group').parent().hide();								
			});
			abandonedcartId = abandonedcart_id;
			userId = user_id;
			productId = product_id;			
		});
	};

	saveRecord = function (frm) {
		if (!$(frm).validate()) { return; }
		$.ykmodal(fcom.getLoader());

		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('DiscountCoupons', 'setup'), data, function (t) {
		
			fcom.removeLoader();
			fcom.displaySuccessMessage(t.msg);
			updateCouponUser(t.recordId, userId);
			updateCouponProduct(t.recordId, productId);
			sendDiscountNotification(abandonedcartId, t.recordId);
			if (t.langId > 0) {
                editLangData(t.recordId, t.langId);
            } else if ("openMediaForm" in t) {
                mediaForm(t.recordId);
            }
			reloadList();
			return;
		});
	};

	updateCouponUser = function (couponId, userId) {
		var data = 'linkType=users&id=' + userId + '&recordId=' + couponId;
		fcom.ajax(fcom.makeUrl('DiscountCoupons', 'bindItem'), data, function (t) {
			
		});
	};
	updateCouponProduct = function (couponId, productId) {
		var data = 'linkType=products&id=' + productId + '&recordId=' + couponId;
		fcom.ajax(fcom.makeUrl('DiscountCoupons', 'bindItem'), data, function (t) {		
		});
	};

	sendDiscountNotification = function (abandonedcartId, couponId) {
		var data = 'abandonedcartId=' + abandonedcartId + '&couponId=' + couponId;
		fcom.ajax(fcom.makeUrl('AbandonedCart', 'discountNotification'), data, function (t) {			
		});
	};

	callCouponDiscountIn = function (val, DISCOUNT_IN_PERCENTAGE, DISCOUNT_IN_FLAT) {
		if (val == DISCOUNT_IN_PERCENTAGE) {
			$("#coupon_max_discount_value_div").show();
			if (100 < $('.discountValueJs').val()) {
				$('.discountValueJs').val(100);
			}
		}
		if (val == DISCOUNT_IN_FLAT) {
			$("#coupon_max_discount_value_div").hide();
		}
	};

	callCouponTypePopulate = function (val) {
		if (val == 1) {
			$("#couponMinorderDivJs").show();
			$("#couponValidforDivJs").hide();

		} if (val == 3) {
			$("#couponMinorderDivJs").hide();
			$("#couponValidforDivJs").show();
		}
	};
	loadImages = function (recordId, lang_id) {
        fcom.updateWithAjax(fcom.makeUrl('DiscountCoupons', 'images', [recordId, lang_id]), '', function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            var uploadedContentEle = $(".dropzoneContainerJs .dropzoneUploadedJs");
            if (0 < uploadedContentEle.length) {
                uploadedContentEle.remove();
            }

            if ('' != t.html) {
                $(".dropzoneContainerJs").append(t.html);
                $(".dropzoneUploadJs").hide();
            } else {
                $(".dropzoneUploadJs").show();
            }
        });
    };
})();

