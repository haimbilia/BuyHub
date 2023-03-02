
(function () {
    saveCategoryRecord = function (frm) {
        if (!$(frm).validate()) { return; }

        $.ykmodal(fcom.getLoader(), !$.ykmodal.isSideBarView());
        var oldParentId = frm.prodcat_parent.dataset.oldParentId;
        var newParendId = frm.prodcat_parent.value;
        var recordId = frm.prodcat_id.value;

        var childEle = [];
        var parentEle = [];
        if (0 < $('#' + recordId).length) {
            childEle = $('#' + recordId).find('.statusEleJs');
            parentEle = $('#' + recordId).data('parentCatCode').split('_');
        }

        var isActiveBefore = frm.prodcat_active.dataset.oldValue;
        var isActive = Number($(frm.prodcat_active).is(":checked"));

        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('productCategories', 'setup'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
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

            if (0 == newParendId && oldParentId == '') {
                $(".categoriesListJs").append(t.listingHtml);
            } else if (oldParentId != newParendId && 0 < $('#' + newParendId).length) {
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
            } else if ("openMediaForm" in t) {
                catMediaForm(t.recordId);
            }
            return;
        });
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

    saveLangData = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        $.ykmodal(fcom.getLoader(), !$.ykmodal.isSideBarView());

        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "langSetup"), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();

            if (t.langId == langLbl.defaultFormLangId) {
                reloadList();
            }

            if (t.langId > 0) {
                editLangData(t.recordId, t.langId);
            } else if ("openMediaForm" in t) {
                if ('undefined' != typeof catMediaForm) {
                    catMediaForm(t.recordId);
                } else {
                    mediaForm(t.recordId);
                }
            }
        });
    };
})();
