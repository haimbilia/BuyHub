$(document).on('change', '.requestStatusJs', function () {
    if (requestType == RETURN_REQUEST_TYPE_REFUND) {
        if ($(this).val() == RETURN_REQUEST_STATUS_REFUNDED) {
            $('.refundToWalletSectionJs').removeClass('hide');
            $('.commentSectionJs').removeClass('hide');
        } else {
            $('.commentSectionJs').addClass('hide');
            $('.refundToWalletSectionJs').addClass('hide');
        }
    }
});

(function () {
    searchMessages = function (frm, append = 0) {
        var dv = "#messagesList";
        var data = fcom.frmData(frm);
        $(dv).prepend(fcom.getLoader());
        data += '&rows_only=' + append;
        fcom.ajax(fcom.makeUrl(controllerName, 'messageSearch'), data, function (res) {
            var ans = JSON.parse(res);
            fcom.removeLoader();

            if (append == 1) {
                $(dv + ' table').append(ans.html);
                var lastTbodyEle = $(dv + ' table tbody:last');
                var lastTbodyEleHtm = lastTbodyEle.html();
                lastTbodyEle.remove();
                $(dv + ' table tbody:last').append(lastTbodyEleHtm);
            } else {
                $(dv).html(ans.html);
            }

            if (ans.endRecord == ans.totalRecords) {
                $("#loadMoreBtnJs").remove();
                return;
            }
        });
    };

    goToMessageSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        $("#loadMoreBtnJs").attr('onclick', 'goToMessageSearchPage(' + (page + 1) + ')');
        var frm = document.frmRecordSearchPaging;
        $(frm.page).val(page);
        searchMessages(frm, 1);
    };

    addNewComment = function (orrequestId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "addNewComment", [orrequestId]), "", function (t) {
            $.ykmodal(t.html, true);
            fcom.removeLoader();
            $.ykmsg.close();
        });
    };

    setupMessage = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setupMessage'), data, function (t) {
            $.ykmodal.close();
            location.reload();
        });
    };

    requestStatusForm = function (orrequestId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "requestStatusForm", [orrequestId]), "", function (t) {
            $.ykmodal(t.html);
            $.ykmsg.close();
            fcom.removeLoader();
        });
    };

    setupStatus = function (frm) {
        if ($(frm).data('status') == frm.orrequest_status.value) {
            return false;
        }
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        var transferLocation = $(".refundToWalletJs:checked").val();
        if (0 != transferLocation && !confirm(langLbl.areYouSure)) { return; }
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setupUpdateStatus'), data, function (t) {
            window.location.reload();
        });
    };

    displayCommentSection = function () {
        if ($(this).is(':checked')) {
            $('.commentSectionJs').removeClass('hide');
        } else {
            $('.commentSectionJs').addClass('hide');
        }
    }

    getItem = function (orrequestId) {
        if (0 < $(".orrDetailsJs" + orrequestId).length) {
            $.ykmodal.show();
        } else {
            fcom.updateWithAjax(fcom.makeUrl(controllerName, 'getItem', [orrequestId]), '', function (ans) {
                fcom.removeLoader();
                $.ykmsg.close();
                $.ykmodal(ans.html);
            });
        }
    };
})();