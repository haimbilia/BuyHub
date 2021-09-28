
(function () {
    var dv = '#mainProfileBlockJs';
    var mtabId = '#mainProfileTabBlockJs';
    profileInfoForm = function () {
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Profile', 'profileInfoForm'), '', function (t) {
            $(dv).html(t);
            fcom.removeLoader();
        });
    };
    
    changePassword = function () {
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Profile', 'changePassword'), '', function (t) {
            $(dv).html(t);
            fcom.removeLoader();
        });
    };
    
    openProfileTab = function (tab = '') {  
        if(tab == ''){
           tab =  'profileInfoForm';
        }      
        let currentTabEle = $(mtabId).find( "a[onclick^='"+tab+"']" ); 
          console.log("a[onclick^='"+tab+"']");
        currentTabEle.siblings().removeClass('widget__item--active');
        currentTabEle.addClass('widget__item--active').trigger("click"); 
    };

    updateProfileInfo = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Profile', 'updateProfileInfo'), data, function (t) {           
        });
    };

    removeProfileImage = function () {
        fcom.ajax(fcom.makeUrl('Profile', 'removeProfileImage'), '', function (t) {
            profileInfoForm();
        });
    };

    popupImage = function (inputBtn) {
        $.ykmodal(fcom.getLoader(), " ", "modal-lg");
        if (inputBtn) {
            if (inputBtn.files && inputBtn.files[0]) {
                fcom.ajax(fcom.makeUrl('Profile', 'imgCropper'), '', function (t) {
                    $.ykmodal(t, " ", "modal-lg");
                    var file = inputBtn.files[0];
                    var options = {
                        aspectRatio: 1 / 1,
                        preview: '.img-preview',
                        imageSmoothingQuality: 'high',
                        imageSmoothingEnabled: true,
                        crop: function (e) {
                            var data = e.detail;
                        }
                    };
                    $(inputBtn).val('');
                    return cropImage(file, options, 'saveProfileImage', inputBtn);
                });
            }
        } else {
            fcom.ajax(fcom.makeUrl('Profile', 'imgCropper'), '', function (t) {
                $.ykmodal(t, " ", "modal-lg");
                var container = document.querySelector('.img-container');
                var image = container.getElementsByTagName('img').item(0);
                var options = {
                    aspectRatio: 1 / 1,
                    preview: '.img-preview',
                    imageSmoothingQuality: 'high',
                    imageSmoothingEnabled: true,
                    crop: function (e) {
                        var data = e.detail;
                    }
                };
                return cropImage(image, options, 'saveProfileImage');
            });
        }
    };

    saveProfileImage = function (formData) {
        $.ajax({
            url: fcom.makeUrl('Profile', 'uploadProfileImage'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#loader-js').html(fcom.getLoader());
            },
            complete: function () {
                $('#loader-js').html(fcom.getLoader());
            },
            success: function (ans) {
                $('#dispMessage').html(ans.msg);
                profileInfoForm();
                $.ykmodal.close()
                profileInfoForm();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

})();
