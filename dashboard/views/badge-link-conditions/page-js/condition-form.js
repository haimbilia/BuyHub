var formClass = '.addUpdateForm--js ';

$(document).on('change', formClass + '[name="blinkcond_record_type"]', function () {
    if ("" == $(this).val() && REC_COND_MANUAL == $(formClass + ".recCond--js").val()) {
        $(this).val(RECORD_TYPE_SELLER_PRODUCT);
        return;
    }
    var recordNameSelector = $(formClass + "select.recordIds--js");
    if ("" == recordNameSelector.val() || "undefined" == recordNameSelector.val()) { return; }
    $(formClass + "select.recordIds--js").val('').trigger('change');
});

$(document).on('change', formClass + 'select[name="blinkcond_position"]', function () {
    var badgeSection = $('.badgeImageSection--js .badges');
    if (RIGHT == $(this).val()) {
        badgeSection.addClass('badges-right');
        if (badgeSection.hasClass('badges-left')) {
            badgeSection.removeClass('badges-left')
        }
    } else if (LEFT == $(this).val() && badgeSection.hasClass('badges-right')) {
        badgeSection.addClass('badges-left');
        if (badgeSection.hasClass('badges-right')) {
            badgeSection.removeClass('badges-right')
        }
    }
});

(function () {
    var dv = '#listing';
    var controller = 'BadgeLinkConditions';

    hideSearchFormFilter = function (blinkcond_id) {
        if (0 < blinkcond_id)  {
            $(".listingSection--js, .searchform_filter").show();
        }
    }

    clearForm = function () {
        $(formClass + "input[name='blinkcond_from_date'], " + formClass + "input[name='blinkcond_to_date'], " + formClass + "input[name='blinkcond_condition_from'], " + formClass + "input[name='blinkcond_condition_to']").val("");
        var sellerSelctor = $(formClass + "select[name='seller'], " + formClass + "input[name='blinkcond_user_id']");
        if (0 < sellerSelctor.length) {
            sellerSelctor.val("").trigger('change');
        }
    };

    badgeForm = function (blinkcond_id, badgeId) {
        $('.listingSection--js, .searchform_filter').hide();
        $('#otherTopForm--js').html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controller, 'form', [TYPE_BADGE, badgeId, blinkcond_id]), '', function (t) {
            $('#otherTopForm--js').html(t);

            bindRecordsSelect2();

            if ($(formClass + '.recCond--js').val() == REC_COND_AUTO) {
                $(formClass + 'select[name="blinkcond_condition_type"]').change();
                var recordNameSelector = $(formClass + 'select.recordIds--js');
                recordNameSelector.closest('.field-set').parent().hide();
                $(formClass + '.linkType--js').hide();

            } else {
                $(formClass + ".conditionType--js").hide();
                $(formClass + '[name="blinkcond_record_type"]').trigger('change');
                
                hideSearchFormFilter(blinkcond_id);
            }

            $(formClass + 'input[name="blinkcond_from_date"], ' + formClass + 'input[name="blinkcond_to_date"]').datetimepicker({
                minDate: new Date(),
                dateFormat: 'yy-mm-dd'
            });
            setTimeout(() => {
                $('.select2-search__field').each(function () {
                    $(this).attr('name', $(this).closest('.select2').siblings('select').attr('name') + '_select2-search__field');
                });
            }, 200);
            reloadRecordsList(blinkcond_id);

            updateRecordIds();
        });
    };

    ribbonForm = function (blinkcond_id, badgeId) {
        $('.listingSection--js, .searchform_filter').hide();
        $('#otherTopForm--js').html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controller, 'form', [TYPE_RIBBON, badgeId, blinkcond_id]), '', function (t) {
            $('#otherTopForm--js').html(t);

            bindRecordsSelect2();

            if ($(formClass + '.recCond--js').val() == REC_COND_MANUAL) {
                $(formClass + '[name="blinkcond_record_type"]').trigger('change');
                hideSearchFormFilter(blinkcond_id);
            }

            $(formClass + 'input[name="blinkcond_from_date"], ' + formClass + 'input[name="blinkcond_to_date"]').datetimepicker({
                minDate: new Date(),
                dateFormat: 'yy-mm-dd'
            });
            setTimeout(() => {
                $('.select2-search__field').each(function () {
                    $(this).attr('name', $(this).closest('.select2').siblings('select').attr('name') + '_select2-search__field');
                });
            }, 200);
            reloadRecordsList(blinkcond_id);

            updateRecordIds();
        });
    };

    backToListing = function () {
        window.location.href = fcom.makeUrl(controller, 'list', [badgeId , badgeType]);
    }

    setup = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controller, 'setup'), data, function (t) {
            backToListing();
        });
    };

    getRecordTypeURL = function () {
        var searchSelector = $("select.recordIds--js").siblings('.select2').find('[aria-owns]').attr('aria-owns');
        $("#" + searchSelector).html("");
        var recordType = $('[name="blinkcond_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            return fcom.makeUrl('Products', 'autoComplete');
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return fcom.makeUrl('Seller', 'sellerProductsAutoComplete');
        }else if (RECORD_TYPE_SHOP == recordType) {
            return fcom.makeUrl('Seller', 'getShopDetail', [1]);
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    getRecordData = function (data) {
        var recordType = $('[name="blinkcond_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            return data
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return data.suggestions;
        } else if (RECORD_TYPE_SHOP == recordType) {
            return [data.shopData];
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    bindRecordsSelect2 = function () {
        var selector = $(formClass + "select.recordIds--js");
        selector.select2({
            tags: true,
            closeOnSelect: true,
            allowClear: true,
            dir: langLbl.layoutDirection,
            placeholder: selector.attr('placeholder'),
            ajax: {
                url: function () {
                    return getRecordTypeURL()
                },
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    return { keyword: params.term };
                },
                processResults: function (data, params) {
                    return { results: getRecordData(data) };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: function (result) {
                return result.name || result.value;
            },
            templateSelection: function (result) {
                return result.name || result.value;
            }
        }).on('select2:selecting', function (e) {
            var badgeType = $(formClass + 'input[name="badge_type"]').val();
            var recordType = $(formClass + '[name="blinkcond_record_type"]').val();
            var position = 0;
            if (0 < $(formClass + 'input[name="blinkcond_position"]').length) {
                position = $(formClass + 'input[name="blinkcond_position"]').val();
            }

            var record = e.params.args.data;
            $(".listingSection--js, .searchform_filter").show();

            var JSONObj = [record.id];
            var badgeLinkRecordIds = $(formClass + "input[name='record_ids']").val();
            if ('' != badgeLinkRecordIds) {
                JSONObj = JSON.parse(badgeLinkRecordIds);
                if (JSONObj.includes(record.id)) {
                    selector.val('').trigger('change');
                    $.systemMessage(langLbl.alreadySelected, 'alert--danger');
                    return false;
                }
                JSONObj.push(record.id);
            }
            $(formClass + "input[name='record_ids']").val(JSON.stringify(JSONObj));
            setTimeout(function () {
                selector.val('').trigger('change');
            }, 200);
            var badgeLinkCondId = $(formClass + "input[name='blinkcond_id']").val();
            if ('' != badgeLinkCondId) {
                bindLink(badgeType, badgeLinkCondId, record.id, position);
            } else {
                var recordName = (record.name || record.value);
                var htm = '<tr class="recordRow--js"><td><a class="text-dark" href="javascript:void(0)" title="' + langLbl.remove + '" onClick="removeRecordRow(this, ' + record.id + ');"><i class="fa fa-times"></i></a></id><td>' + recordName + '</td></tr>';
                var tbl = "";
                if (1 > $('table.recordListing--js').length) {
                    var tbl = '<table class="table table-responsive table--hovered recordListing--js"><tbody></tbody></table>';
                    $('#listing').html(tbl);
                }
                $('.recordListing--js').append(htm);
            }
            $(formClass + "select[name='blinkcond_record_type']").attr('disabled', 'disabled');
        }).on('select2:unselect', function (e) {
            updateRecordIds(e.params.args.data.id);
        });
    }

    searchRecords = function (form) {
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl(controller, 'records', [$('.formSearch--js input[name="blinkcond_id"]').val()]), fcom.frmData(form), function (res) {
            $(dv).html(res);
        });
    };

    clearSearch = function () {
        document.frmSearch.reset();
        reloadRecordsList($('.formSearch--js input[name="blinkcond_id"]').val(), 1);
    };

    reloadRecordsList = function (blinkcond_id, page) {
        $(dv).html(fcom.getLoader());
        var data = 'page=' + page;
        fcom.ajax(fcom.makeUrl(controller, 'records', [blinkcond_id]), data, function (t) {
            $(dv).html(t);
            if (1 > $('.recordListing--js .recordRow--js').length) {
                $(".listingSection--js, .searchform_filter").hide();
            }
        });
    };

    removeBadgeLinkRecord = function (e, blinkcond_id, recordId) {
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }

        if (blinkcond_id < 1 || recordId < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        updateRecordIds(recordId);
        fcom.updateWithAjax(fcom.makeUrl(controller, 'unlinkRecord', [blinkcond_id, recordId]), '', function (t) {
            reloadRecordsList(blinkcond_id);
        });
    }

    bindLink = function (badgeType, blinkcond_id, recordId, position) {
        fcom.updateWithAjax(fcom.makeUrl(controller, 'linkRecord', [badgeType, blinkcond_id, recordId, position]), '', function (t) {
            reloadRecordsList(blinkcond_id);
        });
    }

    updateRecordIds = function (removeRecordId = 0) {
        var selectedRecords = $(formClass + "input[name='record_ids']").val();
        if ('' != selectedRecords && 'undefined' != typeof selectedRecords) {
            selectedRecords = $.parseJSON(selectedRecords);
            if (removeRecordId) {
                var index = selectedRecords.indexOf(removeRecordId);
                if (index > -1) {
                    selectedRecords.splice(index, 1);
                }
            }

            $(formClass + "input[name='record_ids']").val(JSON.stringify(selectedRecords));
            var recordType = $(formClass + "select[name='blinkcond_record_type']");
            if (1 > selectedRecords.length) {
                recordType.removeAttr('disabled');
            } else {
                recordType.attr('disabled', 'disabled');
            }
        }
    }

    removeRecordRow = function (element, removeRecordId) {
        $(element).closest('tr').remove();
        updateRecordIds(removeRecordId);

        if (1 > $('.recordListing--js .recordRow--js').length) {
            $('.listingSection--js').hide();
        }
    }
})()

$(document).ready(function () {
    if (TYPE_BADGE == badgeType) {
        badgeForm(blinkcond_id, badgeId);
    } else if (TYPE_RIBBON == badgeType) {
        ribbonForm(blinkcond_id, badgeId);
    } else {
        $.systemMessage(langLbl.invalidRequest, 'alert--danger');
        return false;
    }
});