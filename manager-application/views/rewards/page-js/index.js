$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});

(function () {
    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), {}, '', function () {
            clearSearch();
        });
    }

    addNewRecord = function (userId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), "urp_user_id=" + userId, function (t) {
            $.ykmodal(t.html);
            $.ykmsg.close();
            fcom.removeLoader();
        });
    };

    getComments = function (recordId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "getComments"), "recordId=" + recordId, function (t) {
            $.ykmodal(t.html, true);
            $.ykmsg.close();
            fcom.removeLoader();
        });
    };
})();