(function () {
	var dv = "#listing";
	

	deleteRecord = function (recordId) {
		if (false === checkControllerName()) {
			return false;
		}

		if (!confirm(langLbl.confirmDelete)) {
			return;
		}
		data = "recordId=" + recordId;
		fcom.updateWithAjax(
			fcom.makeUrl(controllerName, "deleteRecord"),
			data,
			function (t) {
				fcom.displaySuccessMessage(t.msg);
				var oldRecordParent = $('#' + recordId).parent().closest('.liJs');
				var oldRecordParentId = oldRecordParent.attr('id');
				if (1 == oldRecordParent.find('.ul-' + oldRecordParentId + ' > li').length) {
					oldRecordParent.find('.ul-' + oldRecordParentId).remove();
					$('.sortableListsOpener', oldRecordParent).remove();
				} else {
					$('#' + recordId).remove();
				}
			}
		);
	};

	goToProducts = function (prodCatId) {
		redirectToProduct(0, { prodcat_id: prodCatId });
	};

	updateStatus = function (e, obj, recordId, status) {
		if (false === checkControllerName()) {
			return false;
		}
		e.stopPropagation();
		fcom.displayProcessing();
		$("#sorting-categories").prepend(fcom.getLoader());

		var childEle = $(obj).closest('.liJs').find('.statusEleJs');
		var parentEle = $(obj).data('parentCatCode').split('_');
		var oldStatus = $(obj).attr("data-old-status");

		if (1 > recordId) {
			$(obj).prop("checked", 1 == oldStatus);
			fcom.displayErrorMessage(langLbl.invalidRequest);
			fcom.removeLoader();
			return false;
		}

		data = "recordId=" + recordId + "&status=" + status;
		fcom.ajax(fcom.makeUrl(controllerName, "updateStatus"), data,
			function (res) {
				fcom.removeLoader();
				fcom.closeProcessing();
				var ans = $.parseJSON(res);
				if (ans.status != 1) {
					$(obj).prop("checked", 1 == oldStatus);
					fcom.displayErrorMessage(ans.msg);
					return;
				}
				fcom.displaySuccessMessage(ans.msg);
				$(obj).prop("checked", 1 == status);
				$(obj).attr({
					"onclick": "updateStatus(event, this, " + recordId + ", " + oldStatus + ")",
					"data-old-status": status,
				});

				updateChildAndParentStatus(recordId, oldStatus, status, childEle, parentEle);
			}
		);
	};
	
	displaySubCategories = function (obj, catId = 0, data, callable = '') {
		$(obj).removeClass('clickable');
		if (catId > 0) {
			var prodCatId = catId;
		} else {
			var prodCatId = $(obj).closest('.liJs').attr('id');
		}

		if ($("#" + prodCatId + ' ul.append-ul').length) {
			$("#" + prodCatId + ' ul:first').slideDown();
			if (catId == 0) {
				togglePlusMinus(prodCatId);
			}
			if (catId > 0) {
				updateCatOrder(data);
			}
			return false;
		}

		fcom.updateWithAjax(fcom.makeUrl('productCategories', 'getSubCategories'), 'prodCatId=' + prodCatId, function (res) {
            fcom.closeProcessing();
			if ($("#" + prodCatId).children('ul.append-ul').length) {
				$("#" + prodCatId).children('ul.append-ul').append(res.html);
			} else {
				$("#" + prodCatId).append('<ul class="append-ul ulJs ul-' + prodCatId + '" style="display:none;">' + res.html + '</ul>');
			}

			$('.ul-' + prodCatId).slideDown();

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
			$("#" + prodCatId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-minus clickable sort-icon cat' + prodCatId + '-js" onclick="hideItems(this)"></i></span>');
		} else {
			$("#" + prodCatId).removeClass('sortableListsOpen').addClass('sortableListsClosed');
			$("#" + prodCatId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon cat' + prodCatId + '-js" onclick="displaySubCategories(this)"></i></span>');
		}

		$("#" + prodCatId + ' > ul:first > li:has(> ul)').children('div').children('.sortableListsOpener').remove();
		$("#" + prodCatId + ' > ul:first > li:has(> ul)').removeClass('sortableListsOpen').addClass('sortableListsClosed');
		$("#" + prodCatId + ' > ul:first > li:has(> ul)').children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon" onclick="displaySubCategories(this)"></i></span>');
	}

	hideItems = function (obj) {
		var prodCatId = $(obj).parent().parent().parent().attr('id');
		$("#" + prodCatId + ' ul').slideUp();
		$("#" + prodCatId).removeClass('sortableListsOpen').addClass('sortableListsClosed');
		var icon = $("#" + prodCatId).children('div').children('.sortableListsOpener').remove();
		$("#" + prodCatId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon" onclick="displaySubCategories(this)"></i></span>');
	}

	updateCatOrder = function (data) {
		$("#sorting-categories").prepend(fcom.getLoader());
		fcom.updateWithAjax(fcom.makeUrl('productCategories', 'updateOrder'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
			fcom.removeLoader();
		});
	}
	
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
            fcom.closeProcessing();
			$("input[name='prodcat_name[" + toLangId + "]']").val(t.prodCatName);
		});
	}
	
})();

