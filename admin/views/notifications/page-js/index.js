$(document).ready(function () {
    select2('searchFrmUserIdJs', fcom.makeUrl('Users', 'autoComplete'), {appendGuestUser : 1}, '', function () {
        clearSearch();
    });

});