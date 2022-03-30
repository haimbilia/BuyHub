(function () {

    editLangForm = function (etplCode, langId, autoFillLangData = 0) {
        fcom.updateWithAjax(fcom.makeUrl('EmailTemplates', 'langForm', [etplCode, langId, autoFillLangData]), '', function (t) {
            $.ykmodal(t.html, '', 'modal-dialog-vertical-md');
            fcom.removeLoader();
            fcom.setEditorLayout(langId);
            if (!navigator.clipboard) {
                $('[data-toggle="tooltip"]').removeAttr('title');
                return;
            }
        });
    };

    saveLangData = function (frm) {
        if (!$(frm).validate()) { return; }

        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'langSetup'), data, function (res) {
            fcom.closeProcessing();
            reloadList();
        });
    };

    sendTestEmail = function () {
        var data = fcom.frmData(document.frmEtplLang);
        fcom.ajax(fcom.makeUrl('EmailTemplates', 'sendTestMail'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

    toggleStatus = function (e, obj, etplCode, status) {
        if (false === checkControllerName()) {
            return false;
        }

        e.stopPropagation();
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return false;
        }

        var oldStatus = $(obj).attr("data-old-status");
        $('.listingTableJs').prepend(fcom.getLoader());

        if ('' == etplCode) {
            $(obj).prop('checked', (1 == oldStatus));
            fcom.displayErrorMessage(langLbl.invalidRequest);
            fcom.removeLoader();
            return false;
        }

        data = 'etplCode=' + etplCode + '&status=' + status;
        fcom.ajax(fcom.makeUrl(controllerName, 'updateStatus'), data, function (res) {
            $(obj).prop('checked', (1 == status));
            var ans = JSON.parse(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
                $(obj).attr({ 'onclick': 'updateStatus(event, this, ' + etplCode + ', ' + oldStatus + ')', 'data-old-status': status });
            } else {
                $(obj).prop('checked', (1 == oldStatus));
                fcom.displayErrorMessage(ans.msg);
            }
            fcom.removeLoader();
        });
    };


    editLangForm = function (etplCode, langId, autoFillLangData = 0) {
        fcom.updateWithAjax(fcom.makeUrl('EmailTemplates', 'langForm', [etplCode, langId, autoFillLangData]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, '', 'modal-dialog-vertical-md');
            fcom.removeLoader();
            fcom.setEditorLayout(langId);
            if (!navigator.clipboard) {
                $('[data-toggle="tooltip"]').removeAttr('title');
                return;
            }
        });
    };
    
    editSettingsForm = function (langId, autoFillLangData = 0) {        
        fcom.resetEditorInstance();
        fcom.updateWithAjax(fcom.makeUrl('EmailTemplates', 'settingsForm', [langId, autoFillLangData]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html, '', 'modal-dialog-vertical-md');
            fcom.setEditorLayout(langId); 
        });
    };

    logoFormCallback = function (t) {     
        editSettingsForm(t.lang_id);        
    };

    setupSettings = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('EmailTemplates', 'setupSettings'), data, function (t) {
            fcom.closeProcessing();
            reloadList();
            
        });
    };

    resetToDefaultContent = function () {
        var agree = confirm(langLbl.confirmReplaceCurrentToDefault);
        if (!agree) { return false; }
        oUtil.obj.putHTML($("#editor_default_content").html());
    };

    removeEmailLogo = function (lang_id) {
        if (!confirm(langLbl.confirmDeleteImage)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('EmailTemplates', 'removeEmailLogo', [lang_id]), '', function (t) {
            fcom.closeProcessing();
            editSettingsForm(lang_id);
        });
    };  

})();
