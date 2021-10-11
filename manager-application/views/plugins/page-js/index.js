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
            frm.sortBy.value ='';
            frm.sortOrder.value ='';
        }
        data = fcom.frmData(frm);

        fcom.ajax(fcom.makeUrl(controllerName, 'search'), data, function (res) {
            fcom.removeLoader();
            setTabActive(type);

            var res = $.parseJSON(res);
            $(dv).html(res.listingHtml);
        });
    };

    editSettingForm = function (keyName) {
        fcom.displayProcessing();
        var data = 'keyName=' + keyName;
        fcom.ajax(fcom.makeUrl(keyName + 'Settings'), data, function (t) {
            fcom.removeLoader();
            $.ykmsg.close();
            var res = isJson(t);
            if (res && res.status == 0) {
                $.ykmsg.error(res.msg);
            } else {
                $.ykmodal(t);
            }
        });
    };

    setupPluginsSettings = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        var keyName = frm.keyName.value;
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
            $.ykmsg.error(langLbl.invalidRequest);
            fcom.removeLoader();
            return false;
        }
        fcom.displayProcessing();
        data = 'pluginId=' + pluginId + "&status=" + status;
        fcom.ajax(fcom.makeUrl(controllerName, 'changeStatusByType'), data, function (res) {
            fcom.removeLoader();
            $.ykmsg.close();
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                $.ykmsg.success(ans.msg);
            } else {
                $.ykmsg.error(ans.msg);
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
                    $.ykmsg.close();
                    $('.text-danger').remove();
                    $('#plugin_icon').html(ans.msg);
                    if (ans.status == true) {
                        $(".nav-tabs .nav-link.active").click();
                    } else {
                        $('#plugin_icon').removeClass('text-success');
                        $('#plugin_icon').addClass('text-danger');
                        $.ykmsg.error(ans.msg);
                    }
                    reloadList();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $.ykmsg.error(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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