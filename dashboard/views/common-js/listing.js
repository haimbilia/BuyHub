/* Reset result on clear(cross) icon on keyword search field. */
$(document).on("search", "input[name='keyword']", function () {
    if ("" == $(this).val()) {
        searchRecords(document.frmRecordSearch);
    }
});
/* Reset result on clear(cross) icon on keyword search field. */