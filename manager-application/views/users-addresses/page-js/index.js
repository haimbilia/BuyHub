$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});

(function () {
    bindUserSelect2 = function (element, data = {}) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), data); 
    }

    editAddress = function (recordId, addrRecordId) {
        if (false === checkControllerName()) {
            return false;
        }
        data = "recordId=" + recordId + "&addr_record_id=" + addrRecordId;
        fcom.updateWithAjax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };
})();