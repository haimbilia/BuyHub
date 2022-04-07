$(document).on('change', '.badgeTriggerTypeJs', function () {
    if (2 == $(this).val()) {
        $('.badgeApprovalJs').val('').attr('disabled', 'disabled');
    } else {
        $('.badgeApprovalJs').val('').removeAttr('disabled');
    }
});

(function () {
    mediaForm = function (recordId, langId = 0, slide_screen = 1) {
        fcom.updateWithAjax(
            fcom.makeUrl(controllerName, "media", [recordId, langId, slide_screen]),
            "",
            function (t) {
                fcom.removeLoader();
                loadImages(recordId, langId);
                $.ykmodal(t.html, !$.ykmodal.isSideBarView());
            }
        );
    };

    loadImages = function (recordId, lang_id) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'images', [recordId, lang_id]), '', function (t) {
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

    deleteImage = function (recordId, afile_id, lang_id, slide_screen) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.ajax(fcom.makeUrl(controllerName, 'deleteImage', [recordId, afile_id, lang_id, slide_screen]), '', function (t) {
            var ans = $.parseJSON(t);
            if (ans.status == 0) {
                fcom.displayErrorMessage(ans.msg);
                return;
            }
            
            fcom.displaySuccessMessage(ans.msg);
            loadImages(recordId, lang_id);
        });
    }

    conditionType = function (element) {
        var approvalFld = $('#badgeRequiredApprovalJs');
        if (condAuto == element.value) {
            approvalFld.val("").attr({'data-fatreq' : '{"required":false}', 'disabled': 'disabled'});
            return;
        }

        approvalFld.attr('data-fatreq', '{"required":true}').removeAttr('disabled');
    }

    clearSearch = function (loadRowsOnly = false) {
        document.frmRecordSearch.reset();
        $('input', document.frmRecordSearch).not(':hidden').val('');
        $("input:checkbox[name=listingFld]:checked").each(function () {
            if ($(this).attr("disabled") != "disabled") {
                $(this).prop("checked", false);
            }
        });
        $('.select2-hidden-accessible').val('').trigger('change');
        $('.badgeApprovalJs').val('').removeAttr('disabled');
        searchRecords(document.frmRecordSearch, loadRowsOnly);

    };
})()
