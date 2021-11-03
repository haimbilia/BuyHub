
(function () {
	mediaForm = function (banner_id,langId = 0, slide_screen = 1) {        
        $.ykmodal(fcom.getLoader());
		fcom.ajax(fcom.makeUrl('Brands', 'media', [banner_id, langId, slide_screen]), '', function (t) {
			$.ykmodal(t);  
            brandImages(banner_id, 'logo', slide_screen, langId);
            brandImages(banner_id, 'image', slide_screen, langId);
			fcom.removeLoader();  
        });
    };

	brandImages = function (brandId, fileType, slide_screen, langId) {
        fcom.ajax(fcom.makeUrl('Brands', 'images', [brandId, fileType, langId, slide_screen]), '', function (t) {		
            if (fileType == 'logo') {
                $('#logoListingJs').html(t);
            } else {
                $('#imageListingJs').html(t);
            }          
        });
    };

	logoPopupImage = function (inputBtn) {
        if (inputBtn.files && inputBtn.files[0]) {
			loadCropperSkeleton();
            fcom.ajax(fcom.makeUrl('Brands', 'imgCropper'), '', function (t) {
                t = $.parseJSON(t);  	
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);
                var file = inputBtn.files[0];
                var minWidth = document.frmBrandLogo.logo_min_width.value;
                var minHeight = document.frmBrandLogo.logo_min_height.value;
                if (minWidth == minHeight) {
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
                return cropImage(file, options, 'uploadBrandImages', inputBtn);
            });
        }
    };
	bannerPopupImage = function (inputBtn) {
        if (inputBtn.files && inputBtn.files[0]) {
			loadCropperSkeleton();
            fcom.ajax(fcom.makeUrl('Brands', 'imgCropper'), '', function (t) {
				t = $.parseJSON(t);  	
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);	
                var file = inputBtn.files[0];
                var minWidth = document.frmBrandImage.banner_min_width.value;
                var minHeight = document.frmBrandImage.banner_min_height.value;
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
                return cropImage(file, options, 'uploadBrandImages', inputBtn);
            });
        }
    };
	uploadBrandImages = function (formData) {
        var frmName = formData.get("frmName");
        if ('frmBrandLogo' == frmName) {
            var brandId = document.frmBrandLogo.banner_id.value;
            var langId = document.frmBrandLogo.lang_id.value;
            var fileType = document.frmBrandLogo.file_type.value;
            var imageType = 'logo';
            var ratio_type = $('input[name="ratio_type"]:checked').val();
        } else {
            var brandId = document.frmBrandImage.banner_id.value;
            var langId = document.frmBrandImage.lang_id.value;
            var slideScreen = document.frmBrandImage.slide_screen.value;
            var fileType = document.frmBrandImage.file_type.value;
            var imageType = 'banner';
            var ratio_type = 0;
        }

        formData.append('brand_id', brandId);
        formData.append('slide_screen', slideScreen);
        formData.append('lang_id', langId);
        formData.append('file_type', fileType);
        formData.append('ratio_type', ratio_type);
        $.ajax({
            url: fcom.makeUrl('Brands', 'uploadMedia'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.ykmodal(fcom.getLoader());
            },            
            success: function (ans) {
				fcom.removeLoader();
				if (ans.status == 0) {				
					$.ykmsg.error(ans.msg);
					return;
				}
				$.ykmsg.success(ans.msg);
				brandImages(brandId, imageType, slideScreen, langId);			
				$("#modalBoxJs").modal("hide");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
	deleteMedia = function (brandId, fileType, afileId ,langId , slide_screen) {
        if (!confirm(langLbl.confirmDelete)) { return; }
        fcom.updateWithAjax(fcom.makeUrl('brands', 'removeBrandMedia', [brandId, fileType, afileId]), '', function (t) {
            brandImages(brandId, fileType, slide_screen, langId);
            reloadList();
        });
    };
})();

