$(document).ready(function(){
	searchPromotionCharges();
});

searchPromotionCharges = function(form){
    var dv = '#listing';
    var data = '';
    if (form) {
        data = fcom.frmData(form);
    }
    $(dv).prepend(fcom.getLoader());
    fcom.ajax(fcom.makeUrl('Advertiser', 'searchPromotionCharges'), data , function(t) {
        fcom.removeLoader();
        $(dv).html(t);
    });
};

goToSearchPage = function(page) {
	if(typeof page == undefined || page == null){
		page =1;
	}
	var frm = document.frmChargesSearchPaging;
	$(frm.page).val(page);
	searchPromotionCharges(frm);
};
