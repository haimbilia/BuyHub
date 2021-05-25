(function() {
	setupFeedback = function(frm) { 
		if (!$(frm).validate()) return;
		let formData = new FormData(frm);
		formData.delete("spreview_image[]");
		$('.imgToUpload--js').each(function() {
			const file = DataURIToBlob($(this).attr('src'))
			formData.append("spreview_image[]", file, $(this).attr('title'));
		});
		$.ajax({
			url: fcom.makeUrl('Buyer', 'setupOrderFeedback'),
			type: 'post',
			dataType: 'json',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$.mbsmessage(langLbl.processing, false,'alert--process');
			},
			success: function(ans) {
				if(ans.status == true){
					$.mbsmessage( ans.msg, true, 'alert--success');
					setTimeout(function(){ $.mbsmessage(langLbl.redirecting, true,'alert--process'); location.href = ans.redirectUrl; }, 1500);					
					return;
				}else{
					$.mbsmessage( ans.msg, true, 'alert--danger');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});


		
	};
})();	