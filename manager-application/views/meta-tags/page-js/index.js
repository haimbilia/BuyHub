$(document).on('blur', '.metaUrlJs', function () {
    if (1 > $(this).val().trim().length) {
        return false;
    }
    var data = 'url=' + $(this).val();
    fcom.updateWithAjax(fcom.makeUrl('Home', 'segregateUrl'), data, function (t) {
        $('.metaControllerJs').val(t.controller);
        $('.metaActionJs').val(t.action);
        $('.metaRecordIdJs').val(parseInt(t.recordId));
        $('.metaSubRecordIdJs').val(parseInt(t.subRecordId));
    });
});

(function () {
    var dv = '#metaTagsListing';
    var listingTableJs = '.listingTableJs';

    reloadList = function () {
        searchRecords(document.frmRecordSearchPaging);
    };

    setTabActive = function (type) {
        $('ul.metaTypesJs li.is-active').removeClass('is-active');
        $('ul.metaTypesJs li.tabJs-' + type).addClass('is-active');
        $('html, body').animate({
            scrollTop: $("#metaTagsListing").offset().top
        }, 800);
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

        fcom.ajax(fcom.makeUrl(controllerName, 'search'), data, function (res) {
            fcom.removeLoader();
            setTabActive(type);

            var res = JSON.parse(res);
            if (true === replaceRowsOnly) {
                $(listingTableJs).html(res.listingHtml);
            } else {
                $(dv).html(res.listingHtml);
            }
        });
    };


    metaTagForm = function (id, metaType, metaTagRecordId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl(controllerName, 'form', [id, metaType, metaTagRecordId]), '', function (t) {
            $.ykmsg.close();
            $.ykmodal(t);
        });
    };

    editMetaTagForm = function (id, metaType, metaTagRecordId) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl(controllerName, 'form', [id, metaType, metaTagRecordId]), '', function (t) {
            $.ykmsg.close();
            $.ykmodal(t);
        });
    };

    setupMetaTag = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'setup'), data, function (t) {
            $.ykmsg.close();
            reloadList();
            if (t.langId > 0) {
                editMetaTagLangForm(t.metaId, t.langId, t.metaType, t.metaTagRecordId);
                return;
            }
        });
    }

    editMetaTagLangForm = function (metaId, langId, metaType, metaTagRecordId, autoFillLangData = 0) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl(controllerName, 'langForm', [metaId, langId, metaType, metaTagRecordId, autoFillLangData]), '', function (t) {
            $.ykmsg.close();
            $.ykmodal(t);
        });
    };

    setupLangMetaTag = function (frm, metaType) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'langSetup'), data, function (t) {
            $.ykmsg.close();
            reloadList();
            if (t.langId > 0) {
                editMetaTagLangForm(t.metaId, t.langId, metaType);
                return;
            }
        });
    };
})();