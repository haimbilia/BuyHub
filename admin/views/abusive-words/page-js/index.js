(function () {
    changeFormLayOut = function (el) {
        var langId = $(el).val();
        var dir = langLayOuts[langId];
        if ('undefined' == typeof dir)  {
            return;
        }
        var className = 'layout--' + dir;
        $("#frmAbusiveWordJs").removeClass(function (index, className) {
            return (className.match(/(^|\s)layout--\S+/g) || []).join(' ');
        });
        $("#frmAbusiveWordJs").addClass(className).attr('dir', dir);;
    };
})();