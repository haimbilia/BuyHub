$(document).ready(function(){
	searchOrderReturnRequestMessages(document.frmOrderReturnRequestMsgsSrch);
});
(function() {
	searchOrderReturnRequestMessages = function(frm, append = 0){
		var dv = $("#messagesList");
		$(dv).prepend(fcom.getLoader());
		var data = fcom.frmData(frm);
		fcom.ajax(fcom.makeUrl('Account','orderReturnRequestMessageSearch'), data, function(ans){
            fcom.removeLoader();
			ans = $.parseJSON(ans);
			if( append == 1 ){
				$(dv).find('.loader-yk').remove();
				$(dv).prepend(ans.html);
			} else {
				$(dv).html( ans.html );
			}
			
			/* for LoadMore[ */
			$("#loadMoreBtnDiv").html( ans.loadMoreBtnHtml );
			/* ] */
		});
	};
	
	goToLoadPrevious = function(page) {
		if( typeof page==undefined || page == null ){
			page = 1;
		}		
		var frm = document.frmOrderReturnRequestMsgsSrchPaging;		
		$(frm.page).val(page);
		$("form[name='frmOrderReturnRequestMsgsSrchPaging']").remove();
		searchOrderReturnRequestMessages(frm, 1);
	};
	
	setUpReturnOrderRequestMessage = function(frm){
		if (!$(frm).validate()) { return; }
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl( 'Buyer', 'setUpReturnOrderRequestMessage'), data, function(t) {
			searchOrderReturnRequestMessages( document.frmOrderReturnRequestMsgsSrch );
			frm.reset();
		});
	}
})();