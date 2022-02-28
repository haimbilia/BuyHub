$(document).ready(function () {
    searchCollections(document.frmSearchCollections);
});

(function () {
    var dv = '#listing';
    searchCollections = function (frm, append) {
        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl('Collections', 'search'), data, function (ans) {
            $.ykmsg.close();
            $(dv).html(ans);
        });
    };
})();