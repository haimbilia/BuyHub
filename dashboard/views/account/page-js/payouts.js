(function () {
	var dv = '#payoutsSection';
    pluginForm = function (keyName) {
        $(dv).prepend(fcom.getLoader());
        $("ul.tabs-js li").removeClass("is-active");
        $("#tab-" + keyName).addClass("is-active");
        fcom.ajax(fcom.makeUrl(keyName, 'form'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
        });
    };

    setupPluginForm = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(frm.keyName.value, 'setupAccountForm'), data, function (t) {
            pluginForm(frm.keyName.value);
        });
    };
})();