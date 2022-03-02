$(document).ready(function () {
    bindSortable();
});
$(document).ajaxComplete(function () {
    bindSortable();
});

(function () {
    var dv = '#pluginsListing';
    var listingTableJs = '#listingTableJs';

    reloadList = function () {
        var activeListType = $('ul.pluginTypesJs li.is-active').data('listType');
        searchRecords(activeListType);
    };

    setTabActive = function (type) {
        $('ul.pluginTypesJs li.is-active').removeClass('is-active');
        $('ul.pluginTypesJs li.tabJs-' + type).addClass('is-active');
    }

    searchRecords = function (object) {
        $(dv).prepend(fcom.getLoader());
        var frm = document.frmRecordSearch;
        var pluginsType = frm.type.value;

        /* This function is also called from sort by columns functionality. */
        var type = object;
        if (isNaN(object)) {
            var type = frm.type.value;
        }

        frm.type.value = type;
        if (pluginsType != type) {
            frm.page.value = 1;
            frm.sortBy.value = '';
            frm.sortOrder.value = '';
        }
        data = fcom.frmData(frm);

        fcom.updateWithAjax(fcom.makeUrl(controllerName, 'search'), data, function (res) {
            fcom.removeLoader();
            setTabActive(type);
            window.history.pushState('', '', fcom.makeUrl('plugins', 'index', [type]));
            $(dv).html(res.listingHtml);
            fixTableColumnWidth();
        });
    };

    editSettingForm = function (keyName) {
        var data = 'keyName=' + keyName;
        fcom.updateWithAjax(fcom.makeUrl(keyName + 'Settings'), data, function (t) {
            fcom.removeLoader();
            $.ykmodal(t.html);
        });
    };

    setupPluginsSettings = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        var keyName = frm.keyName.value;
        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl(keyName + 'Settings', 'setup'), data, function (t) {
            fcom.removeLoader();
        });
    };

    changeStatusEitherPluginTypes = function (obj, status, msg) {
        msg = (0 < status) ? msg : langLbl.confirmUpdateStatus;
        if (!confirm(msg)) { return; }
        $(listingTableJs).prepend(fcom.getLoader());

        var pluginId = parseInt(obj.id);
        if (pluginId < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            fcom.removeLoader();
            return false;
        }
        fcom.displayProcessing();
        data = 'pluginId=' + pluginId + "&status=" + status;
        fcom.ajax(fcom.makeUrl(controllerName, 'changeStatusByType'), data, function (res) {
            fcom.removeLoader();
            fcom.closeProcessing();
            var ans = JSON.parse(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
            reloadList();
        });
    };

    syncCategories = function () {
        fcom.updateWithAjax(fcom.makeUrl('PatchUpdate', 'updateTaxCategories'), '', function (t) {
            fcom.removeLoader();
        }, {}, false);
    };
    exportSellerProducts = function (type) {
        var pluginId = $('#frmPlugins [name="plugin_id"]').val();
        var frm = '<form id="formExportSellerProducts" method="post" action="' + fcom.makeUrl('ImportExport', 'exportData', [type]) + '">';
        frm = frm.concat('<input type="hidden" name="plugin_id" value="' + pluginId + '"/>');
        $('body').prepend(frm);
        $('#formExportSellerProducts').submit();
    };

    bindSortable = function () {
        if (1 > $('[data-field="dragdrop"]').length) {
            return;
        }

        $("#pluginsJs > tbody").sortable({
            handle: '.handleJs',
            helper: fixWidthHelper,
            start: fixPlaceholderStyle,
            update: function (event, ui) {
                fcom.displayProcessing();
                $('.listingTableJs').prepend(fcom.getLoader());

                var order = $(this).sortable('toArray');
                var data = '';
                const bindData = new Promise((resolve, reject) => {
                    for (let i = 0; i < order.length; i++) {
                        data += 'plugin[]=' + order[i];
                        if (i + 1 < order.length) {
                            data += '&';
                        }
                    }
                    resolve(data);
                });
                bindData.then(
                    function (value) {
                        fcom.ajax(fcom.makeUrl('plugins', 'updateOrder'), value, function (res) {
                            fcom.removeLoader();
                            fcom.closeProcessing();
                            var ans = $.parseJSON(res);
                            if (ans.status == 1) {
                                fcom.displaySuccessMessage(ans.msg);
                                return;
                            }
                            fcom.displayErrorMessage(ans.msg);
                        });
                    },
                    function (error) {
                        fcom.removeLoader();
                        fcom.closeProcessing();
                        var ans = $.parseJSON(res);
                        if (ans.status == 1) {
                            fcom.displaySuccessMessage(ans.msg);
                            return;
                        }
                        fcom.displayErrorMessage(ans.msg);
                    });
            },
            function(error) {
                fcom.removeLoader();
                fcom.closeProcessing();
            }
        }).disableSelection();
    },
    deleteIcon = function (recordId) {
        if (!confirm(langLbl.confirmDelete)) {
            return;
        }
        fcom.updateWithAjax(
            fcom.makeUrl('plugins', "deleteIcon"),
            {recordId},
            function (t) {
                editRecord(recordId);
            }
        );
    };
})();

$(document).on('click', '.uploadFile-Js', function () {
    var node = this;
    $('#form-upload').remove();
    var pluginId = $(node).attr('data-plugin_id');
    var frm = '<form enctype="multipart/form-data" id="form-upload" style="position:absolute; top:-100px;" >';
    frm = frm.concat('<input type="file" name="file" />');
    frm = frm.concat('<input type="hidden" name="pluginId" value="' + pluginId + '"/>');
    $('body').prepend(frm);
    $('#form-upload input[name=\'file\']').trigger('click');
    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }
    timer = setInterval(function () {
        if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);
            $val = $(node).val();
            fcom.displayProcessing();
            $.ykmodal(fcom.getLoader());
            $.ajax({
                url: fcom.makeUrl(controllerName, 'uploadIcon', [$('#form-upload input[name=\'pluginId\']').val()]),
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
                    fcom.removeLoader();
                    fcom.closeProcessing();
                    $('.text-danger').remove();
                    $('#plugin_icon').html(ans.msg);
                    if (ans.status == true) {
                        $(".nav-tabs .nav-link.active").click();
                    } else {
                        $('#plugin_icon').removeClass('text-success');
                        $('#plugin_icon').addClass('text-danger');
                        fcom.displayErrorMessage(ans.msg);
                    }
                    reloadList();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    fcom.displayErrorMessage(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    fcom.removeLoader();
                }
            });
        }
    }, 500);
});

$(document).ajaxComplete(function () {
    /* StripeConnect */
    $('.StripeConnectPayoutInterval--js').trigger('change');
    /* StripeConnect */
});

/* StripeConnect */
$(document).on('change', '.StripeConnectPayoutInterval--js', function () {
    var payoutMonthlyEle = '.StripeConnectPayoutMonthDays--js';
    var payoutWeeklyEle = '.StripeConnectPayoutWeekly--js';
    var payoutDaysEle = '.StripeConnectPayoutDelayDays--js';
    if ('manual' == $(this).val() || '' == $(this).val()) {
        $(payoutMonthlyEle + ', ' + payoutWeeklyEle + ', ' + payoutDaysEle).val("").attr('disabled', 'disabled');
    } else if ('daily' == $(this).val()) {
        $(payoutDaysEle).removeAttr('disabled');
        $(payoutWeeklyEle + ", " + payoutMonthlyEle).val("").attr('disabled', 'disabled');
    } else if ('monthly' == $(this).val()) {
        $(payoutMonthlyEle).removeAttr('disabled');
        $(payoutDaysEle + ", " + payoutWeeklyEle).val("").attr('disabled', 'disabled');
    } else if ('weekly' == $(this).val()) {
        $(payoutWeeklyEle).removeAttr('disabled');
        $(payoutDaysEle + ", " + payoutMonthlyEle).val("").attr('disabled', 'disabled');
    }
});
/* StripeConnect */