$(document).ready(function () {
    select2('searchFrmUserIdJs', fcom.makeUrl('Users', 'autoComplete'), {}, '', function () {
        clearSearch();
    });
});

(function () {
    restoreUser = function (userId) {
        if (!confirm(langLbl.confirmRestore)) { return; }
        var data = 'user_id=' + userId;
        fcom.updateWithAjax(fcom.makeUrl(ControllerName, 'restore'), data, function (t) {
            reloadUserList();
        });
    };
})();