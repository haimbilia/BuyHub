$(document).on('blur', '.metaUrlJs', function () {
    if (1 > $(this).val().trim().length) {
        return false;
    }
    var data = 'url=' + $(this).val();
    fcom.updateWithAjax(fcom.makeUrl('Home', 'segregateUrl'), data, function (t) {
        fcom.closeProcessing();
        $('.metaControllerJs').val(t.controller);
        $('.metaActionJs').val(t.action);
        $('.metaRecordIdJs').val(parseInt(t.recordId));
        $('.metaSubRecordIdJs').val(parseInt(t.subRecordId));
    });
});

(function () {
    var dv = '#metaTagsListing';
    var listingTableJs = '.listingTableJs';

    tabSearchRecords = function (object) {
        $(':input', document.frmRecordSearch).not(':hidden').val('');
        searchRecords(object);
    };

    setTabActive = function (type) {
        $('ul.metaTypesJs li.is-active').removeClass('is-active');
        $('ul.metaTypesJs li.tabJs-' + type).addClass('is-active');
    }

    searchRecords = function (object, replaceRowsOnly = false) {
        if (true === replaceRowsOnly) {
            $(listingTableJs).prepend(fcom.getLoader());
        } else {
            $(dv).prepend(fcom.getLoader());
        }

        if (isElement(object)) {
            var frm = object;
        } else {
            var frm = document.frmRecordSearch;
        }
        var metaType = frm.metaType.value;

        var type = metaType;
        if (typeof object === 'string' || object instanceof String) {
            frm.metaType.value = object;
            var type = object;

            if (metaType != type) {
                frm.page.value = 1;
                frm.sortBy.value = '';
                frm.sortOrder.value = '';
                frm.pageSize.value = '';
            }
        }

        data = fcom.frmData(frm);
        if (true === replaceRowsOnly) {
            data += '&loadRows=' + 1;
        }

        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'search'), data, function (res) {
            fcom.closeProcessing();
            fcom.removeLoader();
            setTabActive(type);

            if (true === replaceRowsOnly) {
                $(listingTableJs).html(res.listingHtml);
            } else {
                $(dv).replaceWith(res.listingHtml);
            }
        });
    };


    metaTagForm = function (id, metaType, metaTagRecordId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'form', [id, metaType, metaTagRecordId]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    editMetaTagForm = function (id, metaType, metaTagRecordId) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'form', [id, metaType, metaTagRecordId]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    setupMetaTag = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {
            fcom.closeProcessing();
            reloadList();
            if (t.langId > 0) {
                editMetaTagLangForm(t.metaId, t.langId, t.metaType, t.metaTagRecordId);
                return;
            }
        });
    }

    editMetaTagLangForm = function (metaId, langId, metaType, metaTagRecordId, autoFillLangData = 0) {
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'langForm', [metaId, langId, metaType, metaTagRecordId, autoFillLangData]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    setupLangMetaTag = function (frm, metaType) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'langSetup'), data, function (t) {
            fcom.closeProcessing();
            reloadList();
            if (t.langId > 0) {
                editMetaTagLangForm(t.metaId, t.langId, metaType);
                return;
            }
        });
    };
})();