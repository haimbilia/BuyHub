$(document).ready(function() {
    searchSystemLog(document.frmSyslogSearch);
});

(function() {
    var currentPage = 1;
    
    goToSearchPage = function(page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSyslogSearchPaging;
        $(frm.page).val(page);
        searchSystemLog(frm);
    };

    searchSystemLog = function(form, page) {
        if (!page) {
            page = currentPage;
        }
        currentPage = page;
        /*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        /*]*/

        $("#syslogListing").html(fcom.getLoader());

        fcom.ajax(fcom.makeUrl('SystemLog', 'search'), data, function(res) {
            $("#syslogListing").html(res);
        });
    };

    reloadUserList = function() {
        searchSystemLog(document.frmSyslogSearchPaging, currentPage);
    };

    clearSystemLogSearch = function() {
        document.frmSyslogSearch.reset();
        searchSystemLog(document.frmSyslogSearch);
    };

})();
