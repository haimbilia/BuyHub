$(document).ready(function () {
    loadForm('general_instructions');
});

(function () {
    var dv = '#tabData';

    loadForm = function (formType, obj) {
        if (typeof obj != 'undefined') {
            $('.importExportUlJs').find('li').each(function () {
                $(this).removeClass('is-active');
            });
            $(obj).closest('li').addClass('is-active');
        }

        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('ImportExport', 'loadForm', [formType]), '', function (t) {
            $(dv).html(t);
            fcom.removeLoader();
            if ('bulk_media' == formType) {
                searchFiles();
            }
        });
    };

    searchFiles = function () {
        var data = '';
        var dv = $('#listing');
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('ImportExport', 'bulkMediaList'), data, function (res) {
            $("#listing").html(res);
        });
    };

    updateSettings = function (frm) {
        $('.importExportBtnJs').addClass('loading');
        var data = fcom.frmData(frm);
        console.log(data); return;
        $(dv).prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'updateSettings'), data, function (ans) {
            loadForm('settings');
            $('.importExportBtnJs').removeClass('loading');
        });
    };

    uploadZip = function () {
        var data = new FormData();
        $.each($('#bulk_images')[0].files, function (i, file) {
            fcom.displayProcessing();
            data.append('bulk_images', file);
            $.ajax({
                url: fcom.makeUrl('ImportExport', 'upload'),
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (t) {
                    $.ykmsg.close();
                    try {
                        var ans = $.parseJSON(t);
                        if (ans.status == 1) {
                            $.ykmsg.success(ans.msg, 'alert--success', false);
                            loadForm('bulk_media');
                            location.href = fcom.makeUrl('UploadBulkImages', 'downloadPathsFile', [ans.path]);
                        } else {
                            $(document).trigger('close.mbsmessage');
                            $.ykmsg.error(ans.msg);
                        }
                    } catch (exc) {
                        $(document).trigger('close.mbsmessage');
                        $.ykmsg.error(t);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error Occured.");
                }
            });
        });
    };

    downloadPathsFile = function (path) {
        location.href = fcom.makeUrl('ImportExport', 'downloadPathsFile', [path]);
    };

    removeDir = function (dir) {
        if (true == confirm(langLbl.confirmDelete)) {
            fcom.displayProcessing();
            fcom.ajax(fcom.makeUrl('ImportExport', 'removeDir', [dir]), '', function (t) {
                $.ykmsg.close();
                var ans = $.parseJSON(t);
                if (ans.status == 1) {
                    $(document).trigger('close.facebox');
                    $.ykmsg.success(ans.msg);
                    loadForm('bulk_media');
                } else {
                    $(document).trigger('close.mbsmessage');
                    $.ykmsg.error(ans.msg);
                }
            });
        }
    };

    submitImportLaeblsUploadForm = function () {
        var data = new FormData();
        $inputs = $('#frmImportLabels input[type=text],#frmImportLabels select,#frmImportLabels input[type=hidden]');
        $inputs.each(function () { data.append(this.name, $(this).val()); });

        $.each($('#import_file')[0].files, function (i, file) {
            $('#fileupload_div').html(fcom.getLoader());
            data.append('import_file', file);
            $.ajax({
                url: fcom.makeUrl('ImportExport', 'uploadLabelsImportedFile'),
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (t) {
                    try {
                        var ans = $.parseJSON(t);
                        if (ans.status == 1) {
                            $(document).trigger('close.facebox');
                            fcom.displaySuccessMessage(ans.msg);
                            loadForm('import');
                        } else {
                            fcom.displayErrorMessage(ans.msg);
                            $('#fileupload_div').html('');
                        }
                    }
                    catch (exc) {
                        fcom.displayErrorMessage(t);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error Occured.");
                }
            });
        });
    };


})();