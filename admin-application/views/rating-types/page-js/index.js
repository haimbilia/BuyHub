$(document).ready(function() {
    searchRatingTypes(document.frmRatingTypesSearch);
});

(function() {
    var currentPage = 1;
    var runningAjaxReq = false;
    var dv = '#listing';

    goToSearchPage = function(page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmRatingTypesSrchPaging;
        $(frm.page).val(page);
        searchRatingTypes(frm);
    };

    reloadList = function() {
        var frm = document.frmRatingTypesSrchPaging;
        searchRatingTypes(frm);
    };

    searchRatingTypes = function(form) {
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

    removeRatingTypes = function(id) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        data = 'id=' + id;
        fcom.updateWithAjax(fcom.makeUrl('RatingTypes', 'deleteRecord'), data, function(res) {
            reloadList();
        });
    };

    clearSearch = function() {
        document.frmRatingTypesSearch.reset();
        searchRatingTypes(document.frmRatingTypesSearch);
    };

	deleteSelected = function(){
        if(!confirm(langLbl.confirmDelete)){
            return false;
        }
        $("#frmRatingTypesListing").attr("action",fcom.makeUrl('RatingTypes','deleteSelected')).submit();
    };
})()
