$(document).ready(function () {
    select2('searchFrmUserIdJs', fcom.makeUrl('Users', 'autoComplete'), {'deletedOnly' : 1});
});

(function () {
    restoreUser = function (userId) {
        if (!confirm(langLbl.confirmRestore)) { return; }
        var data = 'user_id=' + userId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'restore'), data, function (t) {
            fcom.closeProcessing();
            reloadList();
        });
    };
})();