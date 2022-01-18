$(document).ready

$(function() {
    $("#timetable .items").sortable({
        connectWith: "ul"
    });

    $("ul[id^='available']").draggable({
        helper: "clone",
        connectToSortable: ".items"
    });
});