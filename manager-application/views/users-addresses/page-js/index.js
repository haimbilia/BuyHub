$(document).ready(function () {
    bindUserSelect2('searchFrmUserIdJs');
});

(function () {
    bindUserSelect2 = function (element) {
        select2(element, fcom.makeUrl('Users', 'autoComplete'), {}, '', function () {
            clearSearch();
        }); 
    }

    editAddress = function (recordId, addrRecordId) {
        if (false === checkControllerName()) {
            return false;
        }
        $.ykmodal(fcom.getLoader());
        data = "recordId=" + recordId + "&addr_record_id=" + addrRecordId;
        fcom.ajax(fcom.makeUrl(controllerName, "form"), data, function (t) {
            $.ykmodal(t);
            fcom.removeLoader();
        });
    };
})();