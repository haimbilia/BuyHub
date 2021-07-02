$(document).ready(function() {
    searchRecords(document.frmSearch);
});

(function() {
    var dv = '#listing';

    goToSearchPage = function(page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmRatingTypesSrchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    reloadList = function() {
        var frm = document.frmRatingTypesSrchPaging;
        searchRecords(frm);
    };

    searchRecords = function(form) {
        $(dv).html(fcom.getLoader());
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        fcom.ajax(fcom.makeUrl('RatingTypes', 'search'), data, function(res) {
            $(dv).html(res);
        });
    };

    ratingTypesForm = function(rtId) {
        $.facebox(function() {
            addRatingTypesForm(rtId);
        });
    };

    addRatingTypesForm = function(rtId) {
        fcom.ajax(fcom.makeUrl('RatingTypes', 'form', [rtId]), '', function(t) {
            fcom.updateFaceboxContent(t);
        });
    };

    ratingTypesLangForm = function (rtId, langId, autoFillLangData = 0) {
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('RatingTypes', 'langForm', [rtId, langId, autoFillLangData]), '', function (t) {
            fcom.updateFaceboxContent(t);
        });
    };

    setupRatingTypes = function(frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('RatingTypes', 'setup'), data, function(t) {
            reloadList();
            if (t.langId > 0) {
                ratingTypesLangForm(t.rtId, t.langId);
                return;
            }
            $(document).trigger('close.facebox');
        });
    };
    setupRatingTypesLang = function(frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('RatingTypes', 'langSetup'), data, function(t) {
            reloadList();
            $(document).trigger('close.facebox');
        });
    };

    clearSearch = function() {
        document.frmSearch.reset();
        searchRecords(document.frmSearch);
    };

    toggleStatus = function (e, obj, status) {
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return;
        }
        var rtId = parseInt(obj.value);
        if (rtId < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'ratingtype_id=' + rtId + '&status=' + status;
        fcom.ajax(fcom.makeUrl('RatingTypes', 'changeStatus'), data, function (res) {
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
})()
