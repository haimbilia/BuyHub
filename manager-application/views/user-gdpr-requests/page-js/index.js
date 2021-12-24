
(function () {
    viewRequestPurpose = function (requestId) {
        fcom.updateWithAjax(fcom.makeUrl('UserGdprRequests', 'viewUserRequest', [requestId]), "", function (t) {
            $.ykmodal(t.html);
            $.ykmsg.close();
            fcom.removeLoader();
        });
    };

    truncateUserData = function (userId, userReqId) {
        if (!confirm(langLbl.confirmTruncateUserData)) {
            return;
        }
        var data = 'userId=' + userId + '&reqId=' + userReqId;
        fcom.updateWithAjax(fcom.makeUrl('UserGdprRequests', 'truncateUserData'), data, function (t) {
            if (t.userReqId > 0) {
                searchRecords();
            }
        });
    };
    updateRequestStatus = function (reqId, reqStatus) {
        if (!confirm(langLbl.confirmChangeRequestStatus)) {
            return;
        }
        var data = 'reqId=' + reqId + '&status=' + reqStatus;
        fcom.updateWithAjax(fcom.makeUrl('UserGdprRequests', 'updateRequestStatus'), data, function (t) {
            if (t.status == 1) {
                searchRecords();
            }
        });
    };
    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), {}, '', function () {
            clearSearch();
        });
    };
})();

$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});
