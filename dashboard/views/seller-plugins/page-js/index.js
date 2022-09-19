(function () {

    searchPlugin = function (type) {
        var dv = $("#Listing");
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerPlugins', 'search', [type]), '', function (res) {
            fcom.removeLoader();
            $(dv).html(res);
        });
    };

    toggleStatus = function (obj, status) {
        if (!confirm(langLbl.confirmUpdateStatus)) {
            return;
        }
        var pluginId = parseInt(obj.value);
        if (pluginId < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'pluginId=' + pluginId + "&status=" + status;
        fcom.ajax(fcom.makeUrl('SellerPlugins', 'changeStatus'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
            searchPlugin(type);
        });
    };

    editSettingForm = function (keyName) {
        var data = 'keyName=' + keyName;
        fcom.ajax(fcom.makeUrl(keyName + 'Settings'), data, function (t) {
            try {
                res = jQuery.parseJSON(t);
                $.ykmodal(res.msg);
            } catch (e) {
                $.ykmodal(t);
            }

        });
    };

    setupPluginsSettings = function (frm) {
        if (!$(frm).validate()) { return; }
        var data = fcom.frmData(frm);
        var keyName = frm.keyName.value;
        fcom.updateWithAjax(fcom.makeUrl(keyName + 'Settings', 'setup'), data, function (t) {

        });
    };

    syncCarriers = function (recordId) {
        fcom.updateWithAjax(fcom.makeUrl('ShippingServices', 'syncCarriers', [recordId]), '', function (t) {
            fcom.displaySuccessMessage(t.msg);
            fcom.removeLoader();
        });
    }
})();
