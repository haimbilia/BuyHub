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
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), "utxn_user_id=" + userId, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    getDescription = function (recordId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "getDescription"), "recordId=" + recordId, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };
})();