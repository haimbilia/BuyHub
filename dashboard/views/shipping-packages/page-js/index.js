$(document).ready(function() {
    searchRecords(document.frmRecordSearch);
});

(function() {	
    var dv = '#listing';
    goToPackagesSearchPage = function(page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmPackageSearchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    reloadList = function() {
        var frm = document.frmPackageSearchPaging;
        searchRecords(frm);
    };
	
	searchRecords = function(form) {		
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('ShippingPackages', 'search'), data, function(res) {
            $(dv).html(res);
        });
	}
})(); 