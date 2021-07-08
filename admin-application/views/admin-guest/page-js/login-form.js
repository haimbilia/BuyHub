(function() {
	login = function(frm, v) {
		if (!$(frm).validate()) return;
		if (!v.isValid()) return;
		var data = fcom.frmData(frm);
		var autoClose = true;
		//$.systemMessage(langLbl.processing,'alert--process');
		fcom.ajax(fcom.makeUrl('AdminGuest', 'login'), data, function(t) {
			try{
				t = $.parseJSON(t);
				if(t.errorMsg)
				{
					if (typeof t.autoClose !== 'undefined' && t.autoClose == 0) {					
						autoClose = false;
					}
					$.mbsmessage(t.errorMsg, autoClose, 'alert--danger');
					//$.systemMessage(t.errorMsg,'alert--danger', autoClose);
					return false;
				}
				$.systemMessage(t.msg,'alert--success',true);
			}
			catch(exc){
				console.log(exc);
			}
			/* location.href = fcom.makeUrl(); */
			location.href = t.redirectUrl;
		});
	}
	sendResetPasswordLink = function(user) {
		if (user == '') {
			return false;
		}
		$.systemMessage.close();
		$.systemMessage(langLbl.processing, 'alert--process', false);
		fcom.updateWithAjax(fcom.makeUrl("adminGuest", "sendResetPasswordLink", [user]), '', function(t) {
			if(t.status){
				$.systemMessage(t.msg,'alert--success');
			}
			else
			{
				$.systemMessage(t.msg,'alert--danger');
			}
		}); 
		return false;
	}

})();
