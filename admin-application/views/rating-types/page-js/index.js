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

    ratingTypesForm = function(abusiveId) {
        $.facebox(function() {
            addRatingTypesForm(abusiveId);
        });
    };

    addRatingTypesForm = function(abusiveId) {
        fcom.ajax(fcom.makeUrl('RatingTypes', 'form', [abusiveId]), '', function(t) {
            fcom.updateFaceboxContent(t);
        });
    };

    setupRatingTypes = function(frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('RatingTypes', 'setup'), data, function(t) {
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
