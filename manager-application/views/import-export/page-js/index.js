$(document).ready(function () {
    loadForm('export');
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
        fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'loadForm', [formType]), '', function (t) {
            fcom.removeLoader();
            $(dv).html(t.html);
        });
    };

    uploadSuccessCallback = function (resp) {
        searchRecords();
    }

    searchFiles = function () {
        var data = '';
        var dv = $('#listing');
        $("#listing").html(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'bulkMediaList'), data, function (res) {
            fcom.removeLoader();
            $("#listing").html(res.html);
        });
    };

    updateSettings = function (formName) {
        let frm = document.forms[formName];
        var data = fcom.frmData(frm);
        $(dv).prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'updateSettings'), data, function (ans) {
            fcom.removeLoader();
            loadForm('settings');
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
                    fcom.closeProcessing();
                    try {
                        var ans = JSON.parse(t);
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
                fcom.closeProcessing();
                var ans = JSON.parse(t);
                if (ans.status == 1) {
                    
                    $.ykmsg.success(ans.msg);
                    loadForm('bulk_media');
                } else {
                    $(document).trigger('close.mbsmessage');
                    $.ykmsg.error(ans.msg);
                }
            });
        }
    };

    uploadLabelsImportFile = function (frm) {
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
                        var ans = JSON.parse(t);
                        if (ans.status == 1) {
                            frm.reset();
                            $("#importFileName").html("");
                            
                            $.ykmsg.success(ans.msg);
                            loadForm('import');
                        } else {
                            $.ykmsg.error(ans.msg);
                            $('#fileupload_div').html('');
                        }
                    }
                    catch (exc) {
                        $.ykmsg.error(t);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.ykmsg.error("Error Occured.");
                }
            });
        });
    };


})();