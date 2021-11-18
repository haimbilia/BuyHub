
(function () {    
    updateBulkPermissions = function (permission) {
        var element = "form.actionButtonsJs";
        $(element).attr("action", fcom.makeUrl(controllerName, "updateBulkPermissions"));
        $(element + " input[name='permission']").val(permission);
        $(element).submit();
    }
    updatePermission = function (moduleId, permission) {
        if (1 > moduleId) {
            if (!(permission = $('.permissionForAll').val())) {
                return false;
            }
        }

        data = fcom.frmData(document.frmRecordSearch);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'updatePermission', [moduleId, permission]), data, function (t) {
            if (t.moduleId == 0) {
                reloadList();
            }
        });
    };

})();
