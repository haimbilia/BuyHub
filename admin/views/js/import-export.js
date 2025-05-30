(function () {
    addExportForm = function (actionType) {
        $.facebox(function () {
            exportForm(actionType);

        });
    };
    exportForm = function (actionType) {
        fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'exportForm', [actionType]), '', function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            $.ykmodal(t.html);
        });
    }

    exportMediaForm = function (actionType) {
        fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'exportMediaForm', [actionType]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };


    exportData = function (frm, actionType) {
        if (!$(frm).validate()) {
            fcom.removeLoader();
            return;
        }
        document.frmImportExport.action = fcom.makeUrl('ImportExport', 'exportData', [actionType]);
        document.frmImportExport.submit();
        fcom.removeLoader();
    };

    exportMedia = function (frm, actionType) {
        if (!$(frm).validate()) {
            fcom.removeLoader();
            return;
        }
        document.frmImportExport.action = fcom.makeUrl('ImportExport', 'exportMedia', [actionType]);
        document.frmImportExport.submit();
        fcom.removeLoader();
    };

    importForm = function (actionType) {
        fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'importForm', [actionType]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    }

    getImportInstructions = function (actionType) {
        if (actionType == 13) {
            fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'importLabelsForm'), '', function (t) {
                fcom.closeProcessing();
                $.ykmodal(t.html);
                fcom.removeLoader();
            });
        } else {
            fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'importInstructions', [actionType]), '', function (t) {
                fcom.closeProcessing();
                $.ykmodal(t.html);
                fcom.removeLoader();
            });
        }
    }

    importMediaForm = function (actionType) {
        fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'importMediaForm', [actionType]), '', function (t) {
            fcom.closeProcessing();
            $.ykmodal(t.html);
            fcom.removeLoader();
        });
    };

    importFile = function (method, actionType) {
        var data = new FormData();
        $inputs = $('#frmImportExport input[type=text],#frmImportExport select,#frmImportExport input[type=hidden]');
        $inputs.each(function () {
            data.append(this.name, $(this).val());
        });
        $.each($('#import_file')[0].files, function (i, file) {
            fcom.displayProcessing();
            $('#fileupload_div').html(fcom.getLoader());
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
                        var ans = JSON.parse(t);
                        console.log(ans);
                        if (ans.status == 1) {
                            fcom.displaySuccessMessage(ans.msg);
                        } else {
                            $('#fileupload_div').html('');
                            fcom.displayErrorMessage(ans.msg);
                        }

                        if (typeof ans.CSVfileUrl !== 'undefined') {
                            location.href = ans.CSVfileUrl;
                        } /* else {
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } */
                    } catch (exc) {
                        var msg = ('undefined' != typeof t.msg ? t.msg : t);
                        fcom.displayErrorMessage(msg);
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

})();
