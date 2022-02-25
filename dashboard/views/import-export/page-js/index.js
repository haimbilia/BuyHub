$(document).ready(function () {
    loadForm('general_instructions');
});

(function () {
    var dv = '#importExportBlock';
    var settingDv = '#settingFormBlock';
    var exportDv = '#exportFormBlock';
    var importDv = '#importFormBlock';
    var runningAjaxReq = false;

    loadForm = function (formType) {
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('ImportExport', 'loadForm', [formType]), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
            if ('bulk_media' == formType) {
                searchFiles();
            }
        });
    };
    generalInstructions = function (frmType) {
        fcom.resetEditorInstance();
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Configurations', 'generalInstructions', [frmType]), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t);
        });
    };
    updateSettings = function (frm) {
        var data = fcom.frmData(frm);
        $(settingDv).prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'updateSettings'), data, function (ans) {
            fcom.removeLoader();
            loadForm('settings');
        });
    };

    exportForm = function (actionType) {
        if (actionType == inventoryUpdate) {
            location.href = fcom.makeUrl('seller', 'exportInventory');
        } else {
            fcom.ajax(fcom.makeUrl('ImportExport', 'exportForm', [actionType]), '', function (t) {
                fcom.removeLoader();
                $(exportDv).html(t);
            });
        }
    };

    exportData = function (frm, actionType) {
        if (!$(frm).validate()) return;
        document.frmImportExport.action = fcom.makeUrl('ImportExport', 'exportData', [actionType]);
        document.frmImportExport.submit();
    };

    exportMediaForm = function (actionType) {
        fcom.ajax(fcom.makeUrl('ImportExport', 'exportMediaForm', [actionType]), '', function (t) {
            $(exportDv).html(t);
        });
    };

    exportMedia = function (frm, actionType) {
        if (!$(frm).validate()) return;
        document.frmImportExport.action = fcom.makeUrl('ImportExport', 'exportMedia', [actionType]);
        document.frmImportExport.submit();
    };

    importForm = function (actionType, formData = '') {
        if (actionType == inventoryUpdate) {
            inventoryUpdateForm();
        } else {
            fcom.ajax(fcom.makeUrl('ImportExport', 'importForm', [actionType]), formData, function (t) {
                $(importDv).html(t);
            });
        }
    };

    getInstructions = function (actionType) {
        if (actionType == inventoryUpdate) {
            importForm(actionType);
        } else {
            fcom.ajax(fcom.makeUrl('ImportExport', 'importInstructions', [actionType]), '', function (t) {
                $(importDv).html(t);
            });
        }
    };

    importMediaForm = function (actionType) {
        fcom.ajax(fcom.makeUrl('ImportExport', 'importMediaForm', [actionType]), '', function (t) {
            $(importDv).html(t);
        });
    };

    importFile = function (method, actionType) {
        var data = new FormData();
        var form = $('#frmImportExport')[0]; // You need to use standard javascript object here
        var formData = fcom.frmData(form);
        $inputs = $('#frmImportExport input[type=text],#frmImportExport select,#frmImportExport input[type=hidden]');
        $inputs.each(function () {
            data.append(this.name, $(this).val());
        });
        if ($('#import_file')[0].files.length == 0) {
            fcom.displayErrorMessage(langLbl.selectFile);
        }
        $.each($('#import_file')[0].files, function (i, file) {
            fcom.displayProcessing();
            $('#fileupload_div').prepend(fcom.getLoader());
            data.append('import_file', file);
            $.ajax({
                url: fcom.makeUrl('ImportExport', method, [actionType]),
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (t) {
                    fcom.removeLoader();
                    try {
                        var ans = $.parseJSON(t);
                        if (ans.status == 1 || ans.status == true) {
                            fcom.displaySuccessMessage(ans.msg);
                        } else {
                            $('#fileupload_div').html('');
                            fcom.displayErrorMessage(ans.msg);
                        }

                        if ('importData' == method) {
                            importForm(actionType, formData);
                        } else {
                            importMediaForm(actionType);
                        }

                        if (typeof ans.CSVfileUrl !== 'undefined') {
                            location.href = ans.CSVfileUrl;
                        }
                    } catch (exc) {
                        if ('importData' == method) {
                            importForm(actionType, formData);
                        } else {
                            importMediaForm(actionType);
                        }
                        fcom.displayErrorMessage(exc.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error Occured.");
                }
            });
        });
    };

    showHideExtraFld = function (type, BY_ID_RANGE, BY_BATCHES) {
        if (type == BY_ID_RANGE) {
            $(".range_fld").show();
            $(".batch_fld").hide();
        } else if (type == BY_BATCHES) {
            $(".range_fld").hide();
            $(".batch_fld").show();
        } else {
            $(".range_fld").hide();
            $(".batch_fld").hide();
        }
    };

    uploadZip = function () {
        var data = new FormData();
        $.each($('#bulk_images')[0].files, function (i, file) {
            fcom.displayProcessing();
            data.append('bulk_images', file);
            $.ajax({
                url: fcom.makeUrl('ImportExport', 'uploadBulkMedia'),
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (t) {
                    try {
                        var ans = $.parseJSON(t);
                        if (ans.status == 1) {
                            fcom.displaySuccessMessage(ans.msg);
                            document.uploadBulkImages.reset();
                            $("#uploadFileName").text('');
                            setTimeout(function () {
                                searchFiles();
                                location.href = fcom.makeUrl('ImportExport', 'downloadPathsFile', [ans.path]);
                            }, 5000);

                        } else {
                            fcom.displayErrorMessage(ans.msg);
                        }
                    } catch (exc) {
                        fcom.displayErrorMessage(exc.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error Occured.");
                }
            });
        });
    };

    searchFiles = function (form) {
        if (runningAjaxReq == true) {
            return;
        }
        runningAjaxReq = true;
        /*[ this block should be before dv.html('... anything here.....') otherwise it will through exception in ie due to form being removed from div 'dv' while putting html*/
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        /*]*/
        var dv = $('#listing');
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('ImportExport', 'uploadedBulkMediaList'), data, function (res) {
            fcom.removeLoader();
            runningAjaxReq = false;
            $("#listing").html(res);
        });
    };

    removeDir = function (dir) {
        if (true == confirm(langLbl.confirmDelete)) {
            fcom.displayProcessing();
            fcom.ajax(fcom.makeUrl('ImportExport', 'removeDir', [dir]), '', function (t) {
                var ans = $.parseJSON(t);
                if (ans.status == 1) {
                    fcom.displaySuccessMessage(ans.msg);
                    searchFiles();
                } else {
                    fcom.displayErrorMessage(ans.msg);
                }
            });
        }
    };

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSearchPaging;
        $(frm.page).val(page);
        searchFiles(frm);
    };
    downloadPathsFile = function (path) {
        location.href = fcom.makeUrl('ImportExport', 'downloadPathsFile', [path]);
    };

    inventoryUpdateForm = function () {
        fcom.ajax(fcom.makeUrl('Seller', 'InventoryUpdateForm'), '', function (t) {
            $(importDv).html(t);
        });
    };

})();

$(document).on('click', ".group__head-js", function () {
    if ($(this).parents('.group-js').hasClass('is-active')) {
        $(this).siblings('.group__body-js').slideUp();
        $('.group-js').removeClass('is-active');
    } else {
        $('.group-js').removeClass('is-active');
        $(this).parents('.group-js').addClass('is-active');
        $('.group__body-js').slideUp();
        $(this).siblings('.group__body-js').slideDown();
    }
});

$(document).on('click', '.csvFile-Js', function () {
    var node = this;
    $('#form-upload').remove();
    var lang_id = document.frmInventoryUpdate.lang_id.value;
    var frm = '<form enctype="multipart/form-data" id="form-upload" style="position:absolute; top:-100px;" >';
    frm = frm.concat('<input type="file" name="file" />');
    frm = frm.concat('<input type="hidden" name="lang_id" value="' + lang_id + '">');
    frm = frm.concat('</form>');
    $('body').prepend(frm);
    $('#form-upload input[name=\'file\']').trigger('click');
    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }
    timer = setInterval(function () {
        if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);
            $val = $(node).val();
            $.ajax({
                url: fcom.makeUrl('ImportExport', 'updateInventory'),
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(node).val('Loading');
                },
                complete: function () {
                    $(node).val($val);
                },
                success: function (ans) {
                    //$('.text-danger').remove();
                    /* $.ykmsg.close();				 */
                    if (ans.status == true) {
                        fcom.displaySuccessMessage(ans.msg);
                        loadForm('inventoryUpdate');
                    } else {
                        fcom.displayErrorMessage(ans.msg);
                    }
                    if (typeof ans.CSVfileUrl !== 'undefined') {
                        location.href = ans.CSVfileUrl;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
});
