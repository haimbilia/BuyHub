$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});

(function () {
    bindUserSelect2 = function (element, data = {}) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), data);
    }

    addNewRecord = function (userId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), "urp_user_id=" + userId, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    getComments = function (recordId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "getComments"), "recordId=" + recordId, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };
})();