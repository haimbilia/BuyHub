$(document).ready(function () {
    select2('searchFrmUserIdJs', fcom.makeUrl('Users', 'autoComplete'), {'deletedUser' : 1}, '', function () {
        clearSearch();
    });
});

(function () {
    viewRequestPurpose = function (requestId) {
        fcom.updateWithAjax(fcom.makeUrl('UserGdprRequests', 'viewUserRequest', [requestId]), "", function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    truncateUserData = function (userId, userReqId) {
        if (!confirm(langLbl.confirmTruncateUserData)) {
            return;
        }
        var data = 'userId=' + userId + '&reqId=' + userReqId;
        fcom.updateWithAjax(fcom.makeUrl('UserGdprRequests', 'truncateUserData'), data, function (t) {
            fcom.displaySuccessMessage(t.msg);
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
            fcom.displaySuccessMessage(t.msg);
            if (t.status == 1) {
                searchRecords();
            }
        });
    };
})();

