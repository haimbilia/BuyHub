
$(document).on('click','.bgImageFile-Js',function(){
	const node = this;
	$('#form-upload').remove();
	var formName = $(node).attr('data-frm');

	const lang_id =$(node).attr('data-langId');
	const epage_id = document.frmBlock.epage_id.value;

	const file_type = $(node).attr('data-file_type');

	let frm = '<form enctype="multipart/form-data" id="form-upload" style="position:absolute; top:-100px;" >';
	frm = frm.concat('<input type="file" name="file" />');
	frm = frm.concat('<input type="hidden" name="file_type" value="' + file_type + '">');
	frm = frm.concat('<input type="hidden" name="epage_id" value="' + epage_id + '">');
	frm = frm.concat('<input type="hidden" name="lang_id" value="' + lang_id + '">');
	frm = frm.concat('</form>');
	$('body').prepend(frm);
	$('#form-upload input[name=\'file\']').trigger('click');
	if (typeof timer != 'undefined') {
		clearInterval(timer);
	}
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);
			$val = $(node).val();
			$.ajax({
					url: fcom.makeUrl('ContentBlock', 'setUpBgImage'),
					type: 'post',
					dataType: 'json',
					data: new FormData($('#form-upload')[0]),
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function() {
						$(node).val('Loading');
					},
					complete: function() {
						$(node).val($val);
					},
					success: function(ans) {
                        console.log(ans);
                        $.ykmsg.success(ans.msg);
						$(".temp-hide").show();
						/* addBlockLangForm(ans.epage_id,ans.lang_id); */
						var dt = new Date();
						var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
						$(".uploaded--image").html('<img src="'+fcom.makeUrl('image', 'cblockBackgroundImage', [ans.epage_id,ans.lang_id,'THUMB',file_type], SITE_ROOT_URL)+'?'+time+'"> <a href="javascript:void(0);" onclick="removeBgImage('+[ans.epage_id,ans.lang_id,ans.file_type]+')" class="remove--img"><i class="ion-close-round"></i></a>');
						$.ykmsg.success(ans.msg);
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
		}
	}, 500);
});

