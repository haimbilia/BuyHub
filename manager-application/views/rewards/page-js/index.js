$(document).ready(function () {
    select2('userIdJs', fcom.makeUrl('Users', 'autoComplete'), {}, '', function () {
        reloadList();
    });
});