// $(document).ready(function () {
//     searchEtpls(document.frmEtplsSearch);
// });

(function () {   

    editLangForm = function (etplCode, langId, autoFillLangData = 0) {
        $.ykmodal(fcom.getLoader());
        //fcom.resetEditorInstance();
        fcom.ajax(fcom.makeUrl('EmailTemplates', 'langForm', [etplCode, langId, autoFillLangData]), '', function (t) { 
            $.ykmodal(t);
            fcom.removeLoader();
            fcom.setEditorLayout(langId);
        });
    };

    saveLangData = function (frm) {   

        if (!$(frm).validate()) { return; }
        $.ykmodal(fcom.getLoader());

        var data = fcom.frmData(frm);
        fcom.ajax(fcom.makeUrl(controllerName, 'langSetup'), data, function (res) {
            fcom.removeLoader();
            var t = JSON.parse(res);
            if (t.status == 0) {
                $.ykmsg.error(t.msg);
                return false;
            }
            $.ykmsg.success(t.msg);
            reloadList(); 

        });
    };

    sendTestEmail = function () {
        var data = fcom.frmData(document.frmEtplLang);
        $.systemMessage(langLbl.processing, 'alert--process', false);
        fcom.ajax(fcom.makeUrl('EmailTemplates', 'sendTestMail'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
            $(document).trigger('close.facebox');
        });
    };

    toggleStatus = function (e, obj, etplCode, status) {
        if (false === checkControllerName()) {
            return false;
        }

        e.stopPropagation();
        if (!confirm(langLbl.confirmUpdateStatus)) {
            e.preventDefault();
            return false;
        }

        var oldStatus = $(obj).attr("data-old-status");
        $('.listingTableJs').prepend(fcom.getLoader());

        if ( '' == etplCode ) {
            $(obj).prop('checked', (1 == oldStatus));
            $.ykmsg.error(langLbl.invalidRequest);
            fcom.removeLoader();
            return false;
        }

        data = 'etplCode=' + etplCode + '&status=' + status;
        fcom.ajax(fcom.makeUrl(controllerName, 'updateStatus'), data, function (res) {
            $(obj).prop('checked', (1 == status));
            var ans = JSON.parse(res);
            if (ans.status == 1) {
                $.ykmsg.success(ans.msg);
                $(obj).attr({ 'onclick': 'updateStatus(event, this, ' + etplCode + ', ' + oldStatus + ')', 'data-old-status': status });
            } else {
                $(obj).prop('checked', (1 == oldStatus));
                $.ykmsg.error(ans.msg);
            }
            fcom.removeLoader();
        });
    };



    // toggleStatus = function (obj) {
    //     if (!confirm(langLbl.confirmUpdateStatus)) {
    //         return;
    //     }
    //     var etplCode = obj.id;
    //     if (etplCode == '') {
    //         fcom.displayErrorMessage(langLbl.invalidRequest);
    //         return false;
    //     }
    //     data = 'etplCode=' + etplCode;
    //     fcom.displayProcessing();
    //     fcom.ajax(fcom.makeUrl('EmailTemplates', 'changeStatus'), data, function (res) {
    //         var ans = $.parseJSON(res);
    //         if (ans.status == 1) {
    //             $(obj).toggleClass("active");
    //             fcom.displaySuccessMessage(ans.msg);
    //         } else {
    //             fcom.displayErrorMessage(ans.msg);
    //         }
    //     });
    //     $.systemMessage.close();
    // };

    // clearSearch = function () {
    //     document.frmEtplsSearch.reset();
    //     searchEtpls(document.frmEtplsSearch);
    // };

    // toggleBulkStatues = function (status) {
    //     if (!confirm(langLbl.confirmUpdateStatus)) {
    //         return false;
    //     }
    //     $("#frmEmailTempListing input[name='status']").val(status);
    //     $("#frmEmailTempListing").submit();
    // };

    settingsForm = function(langId) {
        fcom.resetEditorInstance();
        $.facebox(function() {
            editSettingsForm(langId);
        });
    };


    editSettingsForm = function(langId, autoFillLangData = 0) {
        fcom.displayProcessing();
        fcom.resetEditorInstance();

        fcom.ajax(fcom.makeUrl('EmailTemplates', 'settingsForm', [langId, autoFillLangData]), '', function(t) {
            fcom.updateFaceboxContent(t);
            fcom.setEditorLayout(langId);
            fcom.resetFaceboxHeight();
            var frm = $('#facebox form')[0];
            var validator = $(frm).validation({
                errordisplay: 3
            });
            $(frm).submit(function(e) {
                e.preventDefault();
                validator.validate();
                if (!validator.isValid()) return;
                var data = fcom.frmData(frm);
                fcom.updateWithAjax(fcom.makeUrl('EmailTemplates', 'setupSettings'), data, function(t) {
                    fcom.resetEditorInstance();
                    reloadList();
                    if (t.lang_id > 0) {
                        editSettingsForm(t.lang_id);
                        return;
                    }
                    $(document).trigger('close.facebox');
                });
            });

        });
    };

    setupSettings = function(frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('EmailTemplates', 'setupSettings'), data, function(t) {
            reloadList();
            $(document).trigger('close.facebox');
        });
    };

    resetToDefaultContent =  function(){
		var agree  = confirm(langLbl.confirmReplaceCurrentToDefault);
		if( !agree ){ return false; }
		oUtil.obj.putHTML( $("#editor_default_content").html() );
	};

    removeEmailLogo = function(lang_id) {
        if (!confirm(langLbl.confirmDeleteImage)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('EmailTemplates', 'removeEmailLogo', [lang_id]), '', function(t) {
            settingsForm(lang_id);
        });
    };

    popupImage = function(inputBtn){
		if (inputBtn.files && inputBtn.files[0]) {
	        fcom.ajax(fcom.makeUrl('Shops', 'imgCropper'), '', function(t) {
				$('#cropperBox-js').html(t);
				$("#mediaForm-js").css("display", "none");
                var file = inputBtn.files[0];
	            var minWidth = document.frmEtplSettingsForm.logo_min_width.value;
	            var minHeight = document.frmEtplSettingsForm.logo_min_height.value;
				if(minWidth == minHeight){
					var aspectRatio = 1 / 1
				} else {
	                var aspectRatio = 16 / 9;
	            }
	    		var options = {
	                aspectRatio: aspectRatio,
	                data: {
	                    width: minWidth,
	                    height: minHeight,
	                },
	                minCropBoxWidth: minWidth,
	                minCropBoxHeight: minHeight,
                    toggleDragModeOnDblclick: false,
                    imageSmoothingQuality: 'high',
					imageSmoothingEnabled: true,
		        };
				$(inputBtn).val('');
    	  		return cropImage(file, options, 'uploadShopImages', inputBtn);
	    	});
		}
	};

	uploadShopImages = function(formData){
        var frmName = formData.get("frmName");
        var langId = document.frmEtplSettingsForm.lang_id.value;
        var fileType = document.frmEtplSettingsForm.file_type.value;
        var ratio_type = $('.prefRatio-js:checked').val();;

        formData.append('lang_id', langId);
        formData.append('file_type', fileType);
        formData.append('ratio_type', ratio_type);
        $.ajax({
            url: fcom.makeUrl('EmailTemplates', 'uploadLogo'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#loader-js').html(fcom.getLoader());
            },
            complete: function() {
                $('#loader-js').html(fcom.getLoader());
            },
			success: function(ans) {
                if (!ans.status) {
                    $.systemMessage(ans.msg, 'alert--danger');
                    return;
                }
                $(".temp-hide").show();
                var dt = new Date();
                var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                $(".uploaded--image").html('<img src="' + fcom.makeUrl('image', 'emailLogo', [ans.lang_id], SITE_ROOT_URL) + '?' + time + '">');
                $.systemMessage(ans.msg, 'alert--success');
                settingsForm(ans.lang_id);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
        });
	}

})();
