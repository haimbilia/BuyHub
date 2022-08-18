(function () {
	saveRecord = function (frm) {
		if (false === checkControllerName()) {
			return false;
		}
		if (!$(frm).validate()) { return; }

		$.ykmodal(fcom.getLoader(), !$.ykmodal.isSideBarView());
		var oldParentId = frm.bpcategory_parent.dataset.oldParentId;
		var newParendId = frm.bpcategory_parent.value;
		var recordId = frm.bpcategory_id.value;

		var childEle = [];
		var parentEle = [];
		if (0 < $('#' + recordId).length) {
			childEle = $('#' + recordId).find('.statusEleJs');
			parentEle = $('#' + recordId).data('parentCatCode').split('_');
		}

		var isActiveBefore = frm.bpcategory_active.dataset.oldValue;
		var isActive = Number($(frm.bpcategory_active).is(":checked"));

		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {
			fcom.removeLoader();
			fcom.displaySuccessMessage(t.msg);

			if (0 < $('.noRecordFoundJs').length) {
				$('.noRecordFoundJs').remove();
			}

			var oldRecordParent = $('#' + t.recordId).parent().closest('.liJs');
			var oldRecordParentId = oldRecordParent.attr('id');
			if (oldParentId != newParendId && 1 == oldRecordParent.find('.ul-' + oldRecordParentId + ' > li').length) {
				oldRecordParent.find('.ul-' + oldRecordParentId).remove();
				$('.sortableListsOpener', oldRecordParent).remove();
			} else if (oldParentId != newParendId) {
				$('#' + t.recordId).remove();
			}

			if (oldParentId != newParendId && 0 < $('#' + newParendId).length) {
				$('#' + newParendId).replaceWith(t.listingHtml);
				$('#' + newParendId).find('.sortableListsOpener i').click();
			} else if (0 < $('#' + t.recordId).length) {
				$('#' + t.recordId).replaceWith(t.listingHtml);
			} else if (0 < t.newRecord && 0 < $('#' + t.parentCatId).length) {
				$('#' + t.parentCatId).replaceWith(t.listingHtml);
			} else {
				$(".categoriesListJs").append(t.listingHtml);
			}

			if (isActiveBefore != isActive) {
				updateChildAndParentStatus(t.recordId, isActiveBefore, isActive, childEle, parentEle);
			}

			if (t.langId > 0) {
				editLangData(t.recordId, t.langId);
			}
			return;
		});
	};

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

	displaySubCategories = function (obj, catId = 0, data, callable = '') {
		if (catId > 0) {
			var recordId = catId;
		} else {
			var recordId = $(obj).closest('.liJs').attr('id');
		}

		if ($("#" + recordId + ' ul.append-ul').length) {
			$("#" + recordId + ' ul:first').slideDown();
			if (catId == 0) {
				togglePlusMinus(recordId);
			}
			if (catId > 0) {
				updateCatOrder(data);
			}
			return false;
		}

		fcom.updateWithAjax(fcom.makeUrl('BlogPostCategories', 'getSubCategories'), 'recordId=' + recordId, function (res) {
			fcom.closeProcessing();
			if ($("#" + recordId).children('ul.append-ul').length) {
				$("#" + recordId).children('ul.append-ul').append(res.html);
			} else {
				$("#" + recordId).append('<ul class="append-ul ulJs ul-' + recordId + '" style="display:none;">' + res.html + '</ul>');
			}

			$('.ul-' + recordId).slideDown();

			if (catId == 0) {
				togglePlusMinus(recordId);
			}

			if (catId > 0) {
				updateCatOrder(data);
			}

			if ('' != callable) {
				window[callable]();
			}
		});
	}

	togglePlusMinus = function (catId) {
		$("#" + catId).children('div').children('.sortableListsOpener').remove();
		if ($("#" + catId).hasClass('sortableListsClosed')) {
			$("#" + catId).removeClass('sortableListsClosed').addClass('sortableListsOpen');
			$("#" + catId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-minus clickable sort-icon cat' + catId + '-js" onclick="hideItems(this)"></i></span>');
		} else {
			$("#" + catId).removeClass('sortableListsOpen').addClass('sortableListsClosed');
			$("#" + catId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon cat' + catId + '-js" onclick="displaySubCategories(this)"></i></span>');
		}

		$("#" + catId + ' > ul:first > li:has(> ul)').children('div').children('.sortableListsOpener').remove();
		$("#" + catId + ' > ul:first > li:has(> ul)').removeClass('sortableListsOpen').addClass('sortableListsClosed');
		$("#" + catId + ' > ul:first > li:has(> ul)').children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon" onclick="displaySubCategories(this)"></i></span>');
	}

	updateCatOrder = function (data) {
		$("#sorting-categories").prepend(fcom.getLoader());
		fcom.updateWithAjax(fcom.makeUrl('BlogPostCategories', 'updateOrder'), data, function (t) {
			fcom.displaySuccessMessage(t.msg);
			fcom.removeLoader();
		});
	}

	hideItems = function (obj) {
		var catId = $(obj).parent().parent().parent().attr('id');
		$("#" + catId + ' ul').slideUp();
		$("#" + catId).removeClass('sortableListsOpen').addClass('sortableListsClosed');
		var icon = $("#" + catId).children('div').children('.sortableListsOpener').remove();
		$("#" + catId).children('div').append('<span class="sortableListsOpener" ><i class="fa fa-plus c3 clickable sort-icon" onclick="displaySubCategories(this)"></i></span>');
	}

	goToBlog = function (bpcatId) {
		redirectToBlogPosts(0, { bpcat_id: bpcatId });
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

	updateChildAndParentStatus = function (recordId, oldStatus, status, childEle, parentEle) {
		/* Mark all children In-Active */
		if (0 < childEle.length && 0 == status) {
			$.each(childEle, function (key, children) {
				$(children).prop("checked", 1 == status);
				$(children).attr({
					"onclick": "updateStatus(event, this, " + $(children).val() + ", " + oldStatus + ")",
					"data-old-status": status,
				});
			});
		}

		/* Mark all parents Active */
		if (1 < parentEle.length && 1 == status) {
			$.each(parentEle, function (key, parent) {
				if ("" != parent) {
					var statusEle = '.statusEle-' + parseInt(parent);
					var val = $(statusEle).val();
					if (recordId != val) {
						$(statusEle).prop("checked", 1 == status);
						$(statusEle).attr({
							"onclick": "updateStatus(event, this, " + val + ", " + oldStatus + ")",
							"data-old-status": status,
						});
					}
				}
			});
		}
	}
})();
