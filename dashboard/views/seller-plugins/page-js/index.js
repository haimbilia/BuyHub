(function () {

    searchPlugin = function (type) {
        var dv = $("#Listing");
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SellerPlugins', 'search', [type]), '', function (res) {
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
                $.mbsmessage(ans.msg, true, 'alert--success');
            } else {
                $.mbsmessage(ans.msg, true, 'alert--danger');
            }            
            searchPlugin(type);
        });
    };

    editSettingForm = function (keyName) {

        $.facebox(function () {
            var data = 'keyName=' + keyName;
            fcom.ajax(fcom.makeUrl(keyName + 'Settings'), data, function (t) {
                try {
                    res = jQuery.parseJSON(t);
                    $.facebox(res.msg );
                } catch (e) {
                    $.facebox(t );
                }
                fcom.resetFaceboxHeight();
            });
        });

    };    
    
    setupPluginsSettings = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        var keyName = frm.keyName.value;
        fcom.updateWithAjax(fcom.makeUrl(keyName + 'Settings', 'setup'), data, function (t) { 
            $(document).trigger('close.facebox');
        });
    };

})();
