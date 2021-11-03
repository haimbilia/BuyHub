$(document).ready(function () {
    $(document).on("click", "#testMail-js", function () {
        fcom.ajax(fcom.makeUrl('Configurations', 'testEmail'), '', function (t) {
            var ans = $.parseJSON(t);
            if (ans.status == 1) {
                $.ykmsg.error(ans.msg);
                return false;
            }
            $.ykmsg.success(ans.msg);
        });
    });

    $(document).on("change", "select[name='CONF_TIMEZONE']", function () {
        var timezone = $("select[name='CONF_TIMEZONE']").val();
        fcom.ajax(fcom.makeUrl('Configurations', 'displayDateTime'), 'time_zone=' + timezone, function (t) {
            var ans = $.parseJSON(t);
            $('#currentDate').html(ans.dateTime);
        });
    });

    $(document).on("click", ".submitBtnJs", function () {
        $('.formBodyJs form').submit();
    });

    $(document).on('change', '.prefRatio-js', function() {
        var inputElement = $(this).closest('.form-group').find('input[type="file"]');
        var selectedVal = $(this).val();
        if (selectedVal == ratioTypeSquare) {
            inputElement.attr('data-min_width', 150)
            inputElement.attr('data-min_height', 150)
        } else {
            inputElement.attr('data-min_width', 150)
            inputElement.attr('data-min_height', 85)
        }
    });
    $(document).on('change', '.defaultLocationGeoFilter', function() {
        if ($(this).val() == 1) {
            $('select[name="CONF_GEO_DEFAULT_COUNTRY"]').prop('disabled', false); // enable
            $('select[name="CONF_GEO_DEFAULT_STATE"]').prop('disabled', false); // enable
            $('input[name="CONF_GEO_DEFAULT_ZIPCODE"]').prop('disabled', false); // enable
        } else {
            $('select[name="CONF_GEO_DEFAULT_COUNTRY"]').prop('disabled', true); // enable
            $('select[name="CONF_GEO_DEFAULT_STATE"]').prop('disabled', true); // enable
            $('input[name="CONF_GEO_DEFAULT_ZIPCODE"]').prop('disabled', true); // enable
        }
    });
    $(document).on('keyup', 'form[name="frmConfiguration"]', function(e) {
        e.stopImmediatePropagation();
        if (e.keyCode === 13) {
            $('.formBodyJs form').submit();
        }
    });
});

(function () { 
    var dv = '#frmBlockJs';
    getForm = function (frmType, langId = 0) {
        fcom.resetEditorInstance();
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Configurations', 'form', [frmType, langId]), '', function (t) {          
            fcom.removeLoader();
            $.ykmsg.close();
            $(dv).html(t);
            setTabActive(frmType);
        });
    };  

    setTabActive = function (type) {
        $('ul.confTypesJs li.is-active').removeClass('is-active');
        $('ul.confTypesJs li.tabJs-' + type).addClass('is-active');
        /* $('html, body').animate({
            scrollTop: $("#frmBlockJs").offset().top
        }); */
    }
    setup = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Configurations', 'setup'), data, function (t) {
            $.ykmsg.close();
        });
    }

    removeMediaImage = function (file_type, lang_id) {
        if (!confirm(langLbl.confirmDeleteImage)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Configurations', 'removeMediaImage', [file_type, lang_id]), '', function (t) {
            $.ykmsg.close();
            getForm(document.frmConfiguration.form_type.value, lang_id);
        });
    };

    changedMessageAutoCloseSetting = function (val) {
        if (val == YES) {

        }
        if (val == NO) {
            $("input[name='CONF_TIME_AUTO_CLOSE_SYSTEM_MESSAGES']").val(0);
        }
    };    

    popupImage = function (inputBtn) {
        if (inputBtn.files && inputBtn.files[0]) {
            loadCropperSkeleton();      
            $("#modalBoxJs .modal-title").text($(inputBtn).attr('data-name'));
            fcom.ajax(fcom.makeUrl('Configurations', 'imgCropper'), '', function (t) {
                t = $.parseJSON(t);         
                $("#modalBoxJs .modal-body").html(t.body);
                $("#modalBoxJs .modal-footer").html(t.footer);
                
                var file = inputBtn.files[0];
                var minWidth = $(inputBtn).attr('data-min_width');
                var minHeight = $(inputBtn).attr('data-min_height');              
                var options = {
                    aspectRatio: minWidth / minHeight,
                    data: {
                        width: minWidth,
                        height: minHeight,
                    },
                    minCropBoxWidth: minWidth,
                    minCropBoxHeight: minHeight,
                    minContainerHeight: 350,
                    toggleDragModeOnDblclick: false,
                    imageSmoothingQuality: 'high',
                    imageSmoothingEnabled: true,
                };
                $(inputBtn).val('');
                setTimeout(function(){ cropImage(file, options, 'uploadConfImages', inputBtn) }, 100);
                return ;
            });
        }
    };

    uploadConfImages = function (formData) {
        var langId = document.frmConfiguration.lang_id.value;
        var formType = document.frmConfiguration.form_type.value;
        var fldName = "ratio_type_" + formData.get('file_type');
        var ratio_type = $('input[name="' + fldName + '"]:checked').val();

        formData.append('lang_id', langId);
        formData.append('form_type', formType);
        formData.append('ratio_type', ratio_type);
        $.ajax({
            url: fcom.makeUrl('Configurations', 'uploadMedia'),
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
                fcom.removeLoader();
                if (!ans.status) {
                    $.ykmsg.error(ans.msg);
                    return false;                  
                }
                $.ykmsg.success(ans.msg);
                getForm(formType, langId);
                $("#modalBoxJs").modal("hide");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                if (xhr.responseText) {
                    $.systemMessage(xhr.responseText, 'alert--danger');
                    return;
                }
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    deleteVerificationFile = function (fileType) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Configurations', 'deleteVerificationFile', [fileType]), '', function (t) {
            $.ykmsg.close();
            getForm(document.frmConfiguration.form_type.value,document.frmConfiguration.lang_id.value);
        });
    };

})();


form = function (form_type) {
    if (typeof form_type == undefined || form_type == null) {
        form_type = 1;
    }
    jQuery.ajax({
        type: "POST",
        data: {
            form: form_type,
            fIsAjax: 1
        },
        url: fcom.makeUrl("configurations", "form"),
        success: function (json) {
            json = $.parseJSON(json);
            if ("1" == json.status) {
                $("#tabs_0" + form_type).html(json.msg);
            } else {
                jsonErrorMessage(json.msg)
            }
        }
    });
}

submitForm = function (form, v) {
    $(form).ajaxSubmit({
        delegation: true,
        beforeSubmit: function () {
            v.validate();
            if (!v.isValid()) {
                return false;
            }
        },
        success: function (json) {
            json = $.parseJSON(json);

            if (json.status == "1") {
                jsonSuccessMessage(json.msg)

            } else {
                jsonErrorMessage(json.msg);
            }
        }
    });
    return false;
}

updateVerificationFile = function (inputBtn, fileType) {
    var formData = new FormData();
    formData.append('fileType', fileType);
    var file = inputBtn.files[0];
    if (inputBtn.files && inputBtn.files[0]) {
        var file = inputBtn.files[0];
        fcom.displayProcessing(langLbl.processing, ' ', true);
        formData.append('verification_file', file);
        $.ajax({
            url: fcom.makeUrl('Configurations', 'updateVerificationFile'),
            type: 'post',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (ans) {
                if (!ans.status) {
                    $.ykmsg.error(ans.msg);
                    return false;
                    return;
                }
                $.ykmsg.success(ans.msg);
                getForm(document.frmConfiguration.form_type.value);
                $(document).trigger('close.facebox');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                if (xhr.responseText) {
                    $.systemMessage(xhr.responseText, 'alert--danger');
                    return;
                }
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}
