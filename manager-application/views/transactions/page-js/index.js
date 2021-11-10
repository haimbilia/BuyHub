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
        $.ykmodal(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controllerName, "form"), "utxn_user_id=" + userId, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };
})();