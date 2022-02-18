$(document).ready(function(){
	searchRecords(document.frmRecordSearch);
});
(function() {
	searchRecords = function(frm){
		/*[ this block should be written before overriding html of 'form's parent div/element, otherwise it will through exception in ie due to form being removed from div */
		var data = fcom.frmData(frm);
		/*]*/
		
		$("#cancelOrderRequestsListing").html( fcom.getLoader() );
		fcom.ajax(fcom.makeUrl('Buyer','orderCancellationRequestSearch'), data, function(res){
			$("#cancelOrderRequestsListing").html(res);
		}); 
	};
	
	goToOrderCancelRequestSearchPage = function(page) {
		if(typeof page==undefined || page == null){
			page =1;
		}
		var frm = document.frmOrderCancellationRequestSrchPaging;		
		$(frm.page).val(page);
		searchRecords(frm);
	}
	
	clearOrderCancelRequestSearch = function(){
		document.frmRecordSearch.reset();
		searchRecords(document.frmRecordSearch);
	};
})();