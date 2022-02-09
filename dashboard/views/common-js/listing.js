/* Reset result on clear(cross) icon on keyword search field. */
$(document).on("search", "input[type='search']", function () {
    if ("" == $(this).val()) {
        searchRecords(document.frmRecordSearch);
    }
});
/* Reset result on clear(cross) icon on keyword search field. */



(function () {
    clearSearch = function () {
        document.frmRecordSearch.reset();
        searchRecords(document.frmRecordSearch);
    };
})();