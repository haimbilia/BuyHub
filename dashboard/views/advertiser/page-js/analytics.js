	
$(document).ready(function(){
	searchRecords(document.frmRecordSearch);	
});

(function() {	
	var dv = '#listing';	

	searchRecords = function(form){			
		var data = '';
		if (form) {
			data = fcom.frmData(form);
		}
		
		$(dv).prepend(fcom.getLoader());
		
		fcom.ajax(fcom.makeUrl('Advertiser','searchAnalyticsData'),data,function(res){
            fcom.removeLoader();
			$(dv).html(res);
		});
	};
	goToSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmRecordSearch;		
		$(frm.page).val(page);
		searchRecords(frm);
	};	

})();