
(function () {
    var dv = '#mainProfileBlockJs';
    var mtabId = '#mainProfileTabBlockJs';
    profileInfoForm = function () {
        $(dv).prepend(fcom.getLoader());
        markMainTabActive();
        fcom.updateWithAjax(fcom.makeUrl('Profile', 'profileInfoForm'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t.html);
        });
    };

    changePassword = function () {
        $(dv).prepend(fcom.getLoader());
        markMainTabActive();
        fcom.updateWithAjax(fcom.makeUrl('Profile', 'changePassword'), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t.html);
        });
    };

    openProfileTab = function (tab = '') {
        if (tab == '') {
            tab = 'profileInfoForm';
        }
        $(mtabId).find("a[onclick^='" + tab + "']").trigger("click");
    };

    markMainTabActive = function () {
        let currentTabEle = $(mtabId).find("a[onclick^='" + markMainTabActive.caller.name + "']");
        currentTabEle.siblings().removeClass('widget__item--active');
        currentTabEle.addClass('widget__item--active');
    }

    updateProfileInfo = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Profile', 'updateProfileInfo'), data, function (t) {
        });
    };

    updatePassword = function (frm) {
        if (!$(frm).validate())
            return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Profile', 'updatePassword'), data, function (t) {
        });
    };

    removeProfileImage = function () {
        fcom.ajax(fcom.makeUrl('Profile', 'removeProfileImage'), '', function (t) {
            profileInfoForm();
        });
    };

    popupImage = function (inputBtn) {
        loadCropperSkeleton();
        $("#modalBoxJs .modal-title").text(cropperHeading);
        if (inputBtn) {
            if (inputBtn.files && inputBtn.files[0]) {
                if(!validateFileUpload(inputBtn.files[0])){
                    return;    
                }
                fcom.updateWithAjax(fcom.makeUrl('Profile', 'imgCropper'), '', function (t) {
                    $("#modalBoxJs .modal-body").html(t.body);
                    $("#modalBoxJs .modal-footer").html(t.footer);
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
                    setTimeout(function () { cropImage(file, options, 'saveProfileImage', inputBtn); }, 500);
                    return;
                });
            }
        } else {
            fcom.updateWithAjax(fcom.makeUrl('Profile', 'imgCropper'), '', function (t) {
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);
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
                setTimeout(function () { cropImage(image, options, 'saveProfileImage'); }, 100);
                return
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
                fcom.displaySuccessMessage(ans.msg);
                $("#modalBoxJs").modal("hide");
                profileInfoForm();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

})();
