$(document).ready(function () {
    select2('userIdJs', fcom.makeUrl('Users', 'autoCompleteJson'), {}, '', function () {
        reloadList();
    });
});