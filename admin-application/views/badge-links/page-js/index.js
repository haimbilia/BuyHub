$(document).ready(function () {
    searchRecords(document.frmSearch);
});

var formClass = '.addUpdateForm--js ';

$(document).on('change', formClass + 'select[name="badgelink_condition_type"]', function () {
    var selector = $(formClass + 'input[name="badgelink_condition_from"], ' + formClass + 'input[name="badgelink_condition_to"]');

    var ratePercElements = [COND_TYPE_ORDER_COMPLETION_RATE, COND_TYPE_RETURN_ACCEPTANCE, COND_TYPE_ORDER_CANCELLED];
    var toSelector = $(formClass + 'input[name="badgelink_condition_to"]');
    var fromSelector = $(formClass + 'input[name="badgelink_condition_from"]');
    
    toSelector.attr('data-fatreq', JSON.stringify({ required: true }));
    if (1 > toSelector.closest('.field-set').find('label').children('.spn_must_field').length) {
        toSelector.closest('.field-set').find('label').append('<span class="spn_must_field">*</span>');
    }
    var htm = '<label class="field_label">' + langLbl.from + '<span class="spn_must_field">*</span></label>';
    fromSelector.closest('.field-set').find('label').replaceWith(htm);

    selector.closest('.field-set').parent().fadeIn().removeClass("col-md-6");

    if ('' == $(this).val()) {
        return;
    }

    if (-1 < jQuery.inArray(parseInt($(this).val()), ratePercElements)) {
        fromSelector.closest('.field-set').parent().addClass("col-md-6");
        toSelector.val('').closest('.field-set').parent().hide();
        toSelector.attr('data-fatreq', JSON.stringify({ required: false }));
        var htm = '<label class="field_label">' + langLbl.rate + '<span class="spn_must_field">*</span></label>';
        fromSelector.closest('.field-set').find('label').replaceWith(htm);
    }
});

$(document).on('change', formClass + 'select[name="badgelink_record_type"]', function () {
    var recordNameSelector = $(formClass + "select[name='record_name']");
    if ("" == recordNameSelector.val() || "undefined" == recordNameSelector.val()) { return; }
    $(formClass + "select[name='record_name']").val('').trigger('change');
});

$(document).on('change', formClass + 'select[name="badge_type"]', function () {
    var label = $(formClass + 'select[name="badge_name"]').closest('.field-set').find('label');
    var badgeTypeText = $(formClass + "select[name='badge_type'] option:selected").text();
    var htm = '<span class="badgeTypeText--js">' + badgeTypeText + '</span>';
    if (0 < $(formClass + '.badgeTypeText--js').length) {
        $(formClass + '.badgeTypeText--js').replaceWith(htm);
    } else {
        label.prepend(htm + " ");
    }
});

$(document).on('change', formClass + 'select[name="record_condition"]', function () {
    var recordCondition = $(this).val();
    /* 
        1 : Automatically 
        2 : Manually 
    */
    var recordNameSelector = $(formClass + 'select[name="record_name"]');
    var parent = recordNameSelector.closest('.field-set').parent();

    var conditionSelectors = $(formClass + 'select[name="badgelink_condition_type"], ' + formClass + 'input[name="badgelink_condition_from"], ' + formClass + 'input[name="badgelink_condition_to"]');
    if (1 == recordCondition) {
        var requirement = { required: false };
        parent.hide();
        $(formClass + 'select[name="badgelink_condition_type"]').closest('.row').hide();
        recordNameSelector.val("").trigger('change');
        conditionSelectors.val("").trigger('change');
        $(formClass + "input[name='badgelink_record_ids']").val('');
    } else {
        var requirement = { required: true };
        parent.fadeIn();
        $(formClass + 'select[name="badgelink_condition_type"]').closest('.row').fadeIn();
    }
    recordNameSelector.attr('data-fatreq', JSON.stringify(requirement));
    conditionSelectors.attr('data-fatreq', JSON.stringify(requirement));

});

(function () {
    var dv = '#listing';
    var controller = 'BadgeLinks';

    goToSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmSrchPaging;
        $(frm.page).val(page);
        searchRecords(frm);
    };

    reloadList = function () {
        var frm = document.frmSrchPaging;
        searchRecords(frm);
    };

    searchRecords = function (form) {
        $(dv).html(fcom.getLoader());
        var data = '';
        if (form) {
            data = fcom.frmData(form);
        }
        fcom.ajax(fcom.makeUrl(controller, 'search'), data, function (res) {
            $(dv).html(res);
        });
    };

    form = function (badgelink_id, recordType = 0) {
        fcom.ajax(fcom.makeUrl(controller, 'form', [badgelink_id, recordType]), '', function (t) {
            $('.pagebody--js').hide();
            $('.editRecord--js').html(t);
            bindBadgeNameSelect2();
            bindRecordsSelect2();

            if (0 < badgelink_id) {
                $(formClass + 'select[name="badgelink_condition_type"]').change();
                $(formClass + "input[name='badgelink_record_ids']").val(JSON.stringify($(formClass + "select[name='record_name']").val()));
            }
            $(formClass + 'select[name="badge_type"], ' + formClass + 'select[name="record_condition"]').change();
            $(formClass + 'input[name="badgelink_from_date"], ' + formClass + 'input[name="badgelink_to_date"]').datetimepicker({
                minDate: new Date(),
                dateFormat: 'yy-mm-dd'
            });
            setTimeout(() => {
                $('.select2-search__field').each(function () {
                    $(this).attr('name', $(this).closest('.select2').siblings('select').attr('name') + '_select2-search__field');
                });
            }, 200);
        });
    };

    backToListing = function () {
        $('.editRecord--js').html("");
        $('.pagebody--js').fadeIn();
    }

    setup = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl(controller, 'setup'), data, function (t) {
            reloadList();
            // form(t.badgelink_id, t.recordType);
            backToListing();
        });
    };

    clearSearch = function () {
        document.frmSearch.reset();
        searchRecords(document.frmSearch);
        $('.searchHead--js').click();
    };

    unlink = function (e, badgelink_id) {
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }

        if (badgelink_id < 1) {
            fcom.displayErrorMessage(langLbl.invalidRequest);
            return false;
        }
        data = 'badgelink_id=' + badgelink_id;
        fcom.ajax(fcom.makeUrl(controller, 'badgeUnlink'), data, function (res) {
            var ans = $.parseJSON(res);
            if (ans.status == 1) {
                fcom.displaySuccessMessage(ans.msg);
                reloadList();
            } else {
                fcom.displayErrorMessage(ans.msg);
            }
        });
    };

    bulkBadgesUnlink = function (e) {
        if (1 > $('.selectItem--js:checked').length) {
            fcom.displayErrorMessage(langLbl.atleastOneRecord);
            return;
        }
        if (!confirm(langLbl.areYouSure)) {
            e.preventDefault();
            return;
        }
        $('.badgesLinksList--js').submit();
    };

    bindBadgeNameSelect2 = function () {
        var selector = $("select[name='badge_name']");
        selector.select2({
            closeOnSelect: true,
            dir: layoutDirection,
            allowClear: true,
            placeholder: selector.attr('placeholder'),
            ajax: {
                url: function () {
                    return fcom.makeUrl('Badges', 'autoComplete', [$(formClass + 'select[name="badge_type"]').val()]);
                },
                dataType: 'json',
                delay: 250,
                method: 'post',
                data: function (params) {
                    return { keyword: params.term };
                },
                processResults: function (data, params) {
                    return { results: data.badges };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: function (result) {
                return result.name;
            },
            templateSelection: function (result) {
                return result.name || result.text;
            }
        }).on('select2:selecting', function (e) {
            $(formClass + "input[name='badgelink_badge_id']").val(e.params.args.data.id);

        }).on('select2:unselecting', function (e) {
            $(formClass + "input[name='badgelink_badge_id']").val("");
        });
    }

    getRecordTypeURL = function () {
        var searchSelector = $(formClass + "select[name='record_name']").siblings('.select2').find('[aria-owns]').attr('aria-owns');
        $("#" + searchSelector).html("");
        var recordType = $(formClass + 'select[name="badgelink_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType) {
            return fcom.makeUrl('Products', 'autoComplete');
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return fcom.makeUrl('SellerProducts', 'autoCompleteProducts');
        } else if (RECORD_TYPE_SHOP == recordType) {
            return fcom.makeUrl('Shops', 'autoComplete');
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    getRecordData = function (data) {
        var recordType = $(formClass + 'select[name="badgelink_record_type"]').val();
        if (RECORD_TYPE_PRODUCT == recordType || RECORD_TYPE_SHOP == recordType) {
            return data
        } else if (RECORD_TYPE_SELLER_PRODUCT == recordType) {
            return data.products;
        } else {
            $.systemMessage(langLbl.invalidRequest, 'alert--danger');
            return false;
        }
    }

    bindRecordsSelect2 = function () {
        var selector = $("select[name='record_name']");
        selector.select2({
            closeOnSelect: true,
            dir: layoutDirection,
            allowClear: true,
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
                return result.name;
            },
            templateSelection: function (result) {
                return result.name || result.text;
            }
        }).on('select2:selecting', function (e) {
            var JSONObj = [e.params.args.data.id];

            var badgeLinkRecordIds = $(formClass + "input[name='badgelink_record_ids']").val();
            if ('' != badgeLinkRecordIds) {
                JSONObj = JSON.parse(badgeLinkRecordIds);
                JSONObj.push(e.params.args.data.id);
            }
            $(formClass + "input[name='badgelink_record_ids']").val(JSON.stringify(JSONObj));
        }).on('select2:unselect', function (e) {
            $(formClass + "input[name='badgelink_record_ids']").val(JSON.stringify($(formClass + "select[name='record_name']").val()));
        });
    }
})()