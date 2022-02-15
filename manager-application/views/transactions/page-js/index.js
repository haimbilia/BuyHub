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
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    showDescription = function (obj) {
        console.log($(obj).find('span').html());
        $.ykmodal($(obj).find('span').html(),true);
    };

    getDescription = function (recordId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "getDescription"), "recordId=" + recordId, function (t) {
            $.ykmodal(t.html, true);
            fcom.removeLoader();
        });
    };
})();