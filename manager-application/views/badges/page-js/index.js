(function () {
    mediaForm = function (recordId, langId = 0, slide_screen = 1) {
        $.ykmodal(fcom.getLoader(), !$.ykmodal.isSideBarView());
        fcom.ajax(
            fcom.makeUrl(controllerName, "media", [recordId, langId, slide_screen]),
            "",
            function (t) {
                fcom.removeLoader();
                loadImages(recordId, langId);
                $.ykmodal(t, !$.ykmodal.isSideBarView());
            }
        );
    };

    loadImages = function (recordId, lang_id) {
        fcom.ajax(fcom.makeUrl(controllerName, 'images', [recordId, lang_id]), '', function (t) {
            var uploadedContentEle = $(".dropzoneContainerJs .dropzoneUploadedJs");
            if (0 < uploadedContentEle.length) {
                uploadedContentEle.remove();
            }

            if ('' != t) {
                $(".dropzoneContainerJs").append(t);
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
                $.ykmsg.error(ans.msg);
                return;
            }
            
            $.ykmsg.success(ans.msg);
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
})()
