$(document).ready(function () {
    searchRecords(document.frmSearch);
});

(function () {
    var dv = '#listing';
    var controller = 'Badges';

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSrchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    reloadList = function () {
        var frm = document.frmSrchPaging;
        searchRecords(frm);
    };

    searchRecords = function (form) {
        $(dv).html(fcom.getLoader());
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        fcom.ajax(fcom.makeUrl(controller, 'search'), data, function (res) {
            $(dv).html(res);
        });
    };

    form = function (badge_id, type) {
        fcom.ajax(fcom.makeUrl(controller, 'form', [badge_id, type]), '', function (t) {
            $('.pagebody--js').hide();
            $('.editRecord--js').html(t);
        });
    };

    backToListing = function () {
        $('.editRecord--js').html("");
        $('.pagebody--js').fadeIn();
    }

    langForm = function (badge_id, langId, autoFillLangData = 0) {
        $('.tabsNav--js a').removeClass('active');
        $('.langtab--js').removeClass('fat-inactive');
        $('.langtab--js a').addClass('active');
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl(controller, 'langForm', [badge_id, langId, autoFillLangData]), '', function (t) {
            $.systemMessage.close();
            $('.tabs_panel--js').replaceWith(t);
        });
    };

    setup = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controller, 'setup'), data, function (t) {
            reloadList();
            form(t.badge_id, t.badge_type);
        });
    };
    setupLang = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controller, 'langSetup'), data, function (t) {
            reloadList();
            $(document).trigger('close.facebox');
        });
    };

    clearSearch = function () {
        document.frmSearch.reset();
        searchRecords(document.frmSearch);
        $('.searchHead--js').click();
    };

    toggleStatus = function (e, obj, status) {
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return;
        }
        var badge_id = parseInt(obj.value);
        if (badge_id < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'badge_id=' + badge_id + '&badge_active=' + status;
        fcom.ajax(fcom.makeUrl(controller, 'changeStatus'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
                $(obj).toggleClass("active");
                $(obj).attr('onclick', 'toggleStatus(event,this,' + (status ? 0 : 1) + ')');
            } else {
                $(obj).prop('checked', (1 != status));
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

    translateData = function (item) {
        var autoTranslate = $("input[name='auto_update_other_langs_data']:checked").length;
        var defaultLang = $(item).attr('defaultLang');
        var badge_name = $("input[name='badge_name[" + defaultLang + "]']").val();
        var toLangId = $(item).attr('language');
        var alreadyOpen = $('#collapse_' + toLangId).hasClass('active');
        if (autoTranslate == 0 || badge_name == "" || alreadyOpen == true) {
            return false;
        }

        if ('' != $("input[name='badge_name[" + toLangId + "]']").val()) {
            return false;
        }

        var data = "badge_name=" + badge_name + "&toLangId=" + toLangId;
        fcom.updateWithAjax(fcom.makeUrl(controller, 'translatedCategoryData'), data, function (t) {
            if (t.status == 1) {
                $("input[name='badge_name[" + toLangId + "]']").val(t.badge_name);
            }
            $.systemMessage.close();
        });
    }
})()
