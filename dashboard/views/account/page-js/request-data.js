$(document).ready(function(){
	requestDataForm();		
});

(function() {
	var runningAjaxReq = false;
	var dv = '#requestDataFrmBlock';
	
	checkRunningAjax = function(){
		if( runningAjaxReq == true ){
			console.log(runningAjaxMsg);
			return;
		}
		runningAjaxReq = true;
	};
	
	requestDataForm = function(){				
		$(dv).prepend(fcom.getloader());
		fcom.ajax(fcom.makeUrl('Account', 'requestDataForm'), '', function(t) {
            fcom.removeLoader();
			$(dv).html(t);
		});
	};
	
	setupRequestData = function (frm){
		if (!$(frm).validate()) return;	
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('Account', 'setupRequestData'), data, function(t) {						
			requestDataForm();			
		});	
	};
	
})();	