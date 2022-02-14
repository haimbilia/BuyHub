$(document).ready(function () {
    searchRecords(document.frmRecordSearch);
});

(function () {
    var runningAjaxReq = false;
    var dv = '#profilesListing';
    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmProfileSearchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    }

    reloadList = function () {
        var frm = document.frmProfileSearchPaging;
        searchRecords(frm);
    };

    searchRecords = function (form) {
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        $(dv).prepend(fcom.getloader());
        fcom.ajax(fcom.makeUrl('ShippingProfile', 'search'), data, function (res) {
            fcom.removeLoader();
            $(dv).html(res);
        });
    }

    deleteRecord = function(shippingProfileId){        
        if (!confirm(langLbl.confirmDelete)) {
            return false;
        }
        data = 'id='+shippingProfileId;
        fcom.updateWithAjax(fcom.makeUrl('shippingProfile', 'deleteRecord'), data, function() { 
            reloadList(); 
        });
    };
})();